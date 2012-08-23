<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This work is distributed under the W3C (R) Software License, but without any
warranty; without even the implied warranty of merchantability or fitness
for a particular purpose.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;w3c
----------------------------------------------------------------------------
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* This is the main PHP file for the secured WebGine. It will secure inputs,
* handle emergency modes and control classes and functions.
*
* @internal  We are using phpDocumentor to automate the documentation process
*            for creating the Developer's Manual. All sections including
*            these special comments will be removed from the release source
*            code.
*            Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author    direct Netware Group
* @copyright (C) direct Netware Group - All rights reserved
* @package   sWG_core
* @since     v0.1.01
* @license   http://www.direct-netware.de/redirect.php?licenses;w3c
*            W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Check and set constants to their default values if necessary.
------------------------------------------------------------------------- */

if (!defined ("OW_error_reporting")) { define ("OW_error_reporting",true); }
if (!defined ("OW_set_time_limit_custom")) { define ("OW_set_time_limit_custom",false); }
if (!defined ("USE_backtrace")) { define ("USE_backtrace",false); }
if (!defined ("USE_charset_html_filtering")) { define ("USE_charset_html_filtering",true); }
if (!defined ("USE_cookies")) { define ("USE_cookies",true); }
if (!defined ("USE_debug_reporting")) { define ("USE_debug_reporting",false); }

if (!defined ("USE_debug_reporting_level"))
{
	if (USE_debug_reporting) { define ("USE_debug_reporting_level",3); }
	else { define ("USE_debug_reporting_level",0); }
}

if (!defined ("USE_debug_reporting_timing")) { define ("USE_debug_reporting_timing",false); }
if (!defined ("USE_file_locking_alternative")) { define ("USE_file_locking_alternative",false); }
if (!defined ("USE_html_charset")) { define ("USE_html_charset",""); }
if (!defined ("USE_set_time_limit_0")) { define ("USE_set_time_limit_0",false); }
if (!defined ("USE_set_time_limit_20")) { define ("USE_set_time_limit_20",true); }
if (!defined ("USE_socket")) { define ("USE_socket",true); }
if (!defined ("USE_outputenc")) { define ("USE_outputenc",true); }

/* -------------------------------------------------------------------------
Now setting error_reporting to nothing (strongly recommended in production
enviroments) as well as Magic-Quotes-Runtime and time limit and co.
------------------------------------------------------------------------- */

if (OW_error_reporting) { error_reporting (0); }
ignore_user_abort (1);
mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);

/*#ifdef(PHP4):
if (!defined ("OW_magic_quotes_runtime")) { define ("OW_magic_quotes_runtime",true); }
if (OW_magic_quotes_runtime) { set_magic_quotes_runtime (0); }

:#\n*/
if (OW_set_time_limit_custom) { set_time_limit (OW_set_time_limit_custom); }
elseif (USE_set_time_limit_0) { set_time_limit (0); }
elseif (USE_set_time_limit_20) { set_time_limit (20); }

if (!defined ("INFO_magic_quotes_input")) { define ("INFO_magic_quotes_input",(get_magic_quotes_gpc ())); }
if (!defined ("INFO_magic_quotes_runtime")) { define ("INFO_magic_quotes_runtime",(get_magic_quotes_runtime ())); }
if (!defined ("INFO_magic_quotes_sybase")) { define ("INFO_magic_quotes_sybase",(get_cfg_var ("magic_quotes_sybase"))); }

extract ($_COOKIE,(EXTR_PREFIX_ALL | EXTR_REFS),"i");
extract ($_POST,(EXTR_PREFIX_ALL | EXTR_REFS),"i");

//j// Data initialisation

/* -------------------------------------------------------------------------
The following lines will initiate all arrays that should be used after this
part
------------------------------------------------------------------------- */

/**
* Everything that should be cached for output or used on other places of an
* script may use this variable.
*/
$direct_cachedata = array ("core_cookies" => array (),"core_debug" => array (),"core_error" => array (),"core_service_activated" => false,"output_warning" => array ());
/**
* $direct_globals is mainly for internal use. It contains a list of initiated
* classes and their current full names.
*/
$direct_globals = array ("@names" => array ());
/**
* All localisation strings should be saved into this array.
*/
$direct_local = array ();
/**
* All settings will be saved into this array.
*/
$direct_settings = array ("lang" => NULL,"theme" => NULL,"swg_chmod_dirs_change" => "0750","swg_chmod_files_change" => "0640","swg_umask_change" => "0000");

$direct_cachedata['core_time'] = (isset ($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time ());
/*#ifndef(PHP4) */$direct_cachedata['core_debug_starttime'] = microtime (true);/* #*//*#ifdef(PHP4):$direct_cachedata['core_debug_starttime'] = time ();:#*/

/* -------------------------------------------------------------------------
Set up variables that can be changed with an integration script.
------------------------------------------------------------------------- */

$g_variables = array (
"swg_ihandler" => array (&$swg_ihandler,"ihandler","http"),
"swg_iscript_form" => array (&$swg_iscript_form,"iscript_form",""),
"swg_iscript_url" => array (&$swg_iscript_url,"iscript_url",""),
"swg_path_data" => array (&$swg_path_data,"path_data","data"),
"swg_path_lang" => array (&$swg_path_lang,"path_lang","lang"),
"swg_path_mmedia" => array (&$swg_path_mmedia,"path_mmedia","data/mmedia"),
"swg_path_system" => array (&$swg_path_system,"path_system","system"),
"swg_path_themes" => array (&$swg_path_themes,"path_themes","data/themes"),
"swg_server" => array (&$swg_server,"swg_server",""),
"swg_shadow_url" => array (&$swg_shadow_url,"swg_shadow_url","")
);

foreach ($g_variables as $g_variable => $g_data)
{
	if ((isset ($_COOKIE[$g_variable]))||(isset ($_GET[$g_variable]))||(isset ($_POST[$g_variable]))) { $g_data[0] = ""; }
	$direct_settings[$g_data[1]] = (empty ($g_data[0]) ? $g_data[2] : $g_data[0]);
}

$g_variable = $g_data = NULL;
unset ($g_variables);

//j// Basic data

/* -------------------------------------------------------------------------
The iscript var contains the current sWG file name. Our first step is to
make sure that the query key gets removed.
------------------------------------------------------------------------- */

$direct_settings['iscript'] = (defined ("OW_PHP_SELF") ? OW_PHP_SELF : basename (str_replace ("?".$_SERVER['QUERY_STRING'],"",$_SERVER['PHP_SELF'])));

/* -------------------------------------------------------------------------
Let's play around with iscript. Our idea is to allow a perfect integration.
For that reason an administrator has to define custom $swg_iscript_url and
$swg_iscript_form values.
------------------------------------------------------------------------- */

if ((empty ($direct_settings['iscript_form']))||(empty ($direct_settings['iscript_url'])))
{
	$direct_settings['iscript_form'] = "<form action='".$direct_settings['iscript']."' method='post' enctype='multipart/form-data' target='_self'";
	$direct_settings['iscript_url'] = $direct_settings['iscript']."?";
}
/* -------------------------------------------------------------------------
You are a guest - until we know more about you ...
------------------------------------------------------------------------- */

$direct_settings['user'] = array ("id" => "","type" => "gt","timezone" => 0);

/* -------------------------------------------------------------------------
Production related information - please do not remove
------------------------------------------------------------------------- */

$direct_settings['product_buildid'] = "#echo(sWGcoreBuildID)#";
$direct_settings['product_icode'] = "swg";
$direct_settings['product_iversion'] = "#echo(sWGcoreIVersion)#";
$direct_settings['product_lcode_html'] = "secured <b>WebGine</b>";
$direct_settings['product_lcode_htmltitle'] = "secured WebGine";
$direct_settings['product_lcode_txt'] = "secured WebGine";
$direct_settings['product_lcode_subtitle_html'] = "net-based application engine";
$direct_settings['product_lcode_subtitle_txt'] = "net-based application engine";
$direct_settings['product_scode_html'] = "<b>sWG</b>";
$direct_settings['product_scode_txt'] = "sWG";
$direct_settings['product_version'] = "#echo(sWGcoreVersion)#";

define ("direct_product_iversion",$direct_settings['product_iversion']);

/* -------------------------------------------------------------------------
Evalute the available timeout (not getting a timeout error)
------------------------------------------------------------------------- */

if (USE_set_time_limit_0) { $direct_settings['timeout'] = 3600; }
else
{
	$direct_settings['timeout'] = (OW_set_time_limit_custom ? OW_set_time_limit_custom : get_cfg_var ("max_execution_time"));

	if ($direct_settings['timeout'])
	{
		$direct_settings['timeout'] = ceil ($direct_settings['timeout'] / 1.5);
		if ($direct_settings['timeout'] < 2) { $direct_settings['timeout'] = 2; }
		if ($direct_settings['timeout'] > 20) { $direct_settings['timeout'] = 20; }
	}
	else { $direct_settings['timeout'] = 2; }
}

$direct_settings['timeout_core'] = ceil ($direct_settings['timeout'] / 3);
$direct_settings['timeout_lightmode'] = floor ($direct_settings['timeout'] - ($direct_settings['timeout_core'] / 3));

//j// Functions and classes

if (file_exists ($direct_settings['path_system']."/functions/swg_inline_functions.php")) { include_once ($direct_settings['path_system']."/functions/swg_inline_functions.php"); }
if (file_exists ($direct_settings['path_system']."/functions/swg_phpback.php")) { include_once ($direct_settings['path_system']."/functions/swg_phpback.php"); }

//j// Script specific commands

if ((function_exists ("direct_autoload"))&&(direct_autoload ('dNG\sWG\directVirtualClass'))&&(direct_autoload ('dNG\sWG\directActionParser'))&&(direct_autoload ('dNG\sWG\directOHandler')))
{
/*#ifdef(PHP5n) */
	spl_autoload_register ("direct_autoload");
/* #*//*#ifndef(PHP5n):
/**
	* PHP's "__autoload ()"-function will be used to load additional, missing
	* classes if they are matching our default name convention.
	*
	* @param string $f_class Requested but missing class name
	* @since v0.1.01
*\/
	function __autoload ($f_class) { direct_autoload ($f_class); }
:#\n*/

/* -------------------------------------------------------------------------
Identify the request
------------------------------------------------------------------------- */

	$g_variables = /*#ifdef(PHP5n) */dNG\sWG\directActionParser::ilineParse ();/* #*//*#ifndef(PHP5n):directActionParser::ilineParse ();:#*/
	$direct_settings['a'] = (isset ($g_variables['a']) ? preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",(urldecode ($g_variables['a']))) : "");
	$direct_settings['m'] = (isset ($g_variables['m']) ? preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",$g_variables['m']) : "");

	if (isset ($g_variables['s']))
	{
		if (strpos ($g_variables['s']," ") !== false) { $g_variables['s'] = urlencode ($g_variables['s']); }
		$direct_settings['s'] = preg_replace (array ("#[\+]+#i","#^\W*#","#[\/\\\?:@\=\&\.]+#","#\W*$#","#\\x20+#"),(array (" ","","","","/")),$g_variables['s']);
	}
	else { $direct_settings['s'] = ""; }

	$direct_settings['dsd'] = (isset ($g_variables['dsd']) ? $g_variables['dsd'] : "");
	$direct_settings['ohandler'] = (((isset ($g_variables['ohandler']))&&($g_variables['ohandler'])) ? $g_variables['ohandler'] : "xhtml");

/* -------------------------------------------------------------------------
If there is no action or service defined, set "index"
------------------------------------------------------------------------- */

	if ($direct_settings['a'] == "") { $direct_settings['a'] = "index"; }
	if ($direct_settings['m'] == "") { $direct_settings['m'] = "default"; }
	if ($direct_settings['s'] == "") { $direct_settings['s'] = "index"; }

/* -------------------------------------------------------------------------
The next few actions are for internal use - they will show images and basic
system information
------------------------------------------------------------------------- */

	if (($direct_settings['m'] == "default")&&($direct_settings['s'] == "index")&&(($direct_settings['a'] == "cache")||($direct_settings['a'] == "info")))
	{
/* -------------------------------------------------------------------------
Create instances of required classes
------------------------------------------------------------------------- */

		direct_class_init ("output");

		//j// if ($direct_settings['a'] == "cache")
		if (($direct_settings['a'] == "cache")&&(isset ($direct_settings['dsd'])))
		{
			if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=cache_ (#echo(__LINE__)#)"); }
			$g_base64 = "";

			if ($direct_settings['dsd'] == "dfile+swg_bg.png")
			{
/* -------------------------------------------------------------------------
The base64-encoded background image for the sWG page
------------------------------------------------------------------------- */

				$g_base64 = "iVBORw0KGgoAAAANSUhEUgAAADYAAABFCAYAAAAB8xWyAAAAAXNSR0IArs4c6QAAAAZiS0dEABkAOAB5lxIzPAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9gGEwweBsttWr0AAAAgdEVYdENvbW1lbnQAKGMpIGRpcmVjdCBOZXR3YXJlIEdyb3VweVc7DwAAANBJREFUaN7t100OgjAURWGeYQf+7n9NrICEpGpdQx2JOAWJWr+OGJBHTs7tuyG6ritNhSdKKVWCtX3f18jVbJpKTxsRjAH7xSier7fx+bjfzv7w2nMYG4tv8v6SxbP2nBiGoVgewBQ0Y4w9wF7K7pKfZXfYzS/NL5jzJ1F8U2l+w5xIKRXLw7oHJoqMzTWWJqV5WlC+a8+p9kez2ihGzllB24qMMQZMFBljDJgoMgZMFIEBszxEEZgoMsaY5SGKjDEGzFYE5o4BE0Vg7hiwj5076vUxjnsT618AAAAASUVORK5CYII=";
			}
			elseif ($direct_settings['dsd'] == "dfile+swg_logo.png")
			{
/* -------------------------------------------------------------------------
The base64-encoded sWG logo
------------------------------------------------------------------------- */

/*n// NOTE
----------------------------------------------------------------------------
We are using images created by the "Tango Desktop Project"
Thanks for your work (Latest update: 08/02/11)
----------------------------------------------------------------------------
NOTE_END //n*/

$g_base64 = ("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");
			}

			if ($g_base64)
			{
				$direct_cachedata['core_service_activated'] = true;
				$direct_globals['output']->header (true,false);
				$direct_globals['output']->outputHeader ("Content-Type","image/png");
				$direct_globals['output']->output_data = base64_decode ($g_base64);
				$direct_globals['output']->outputSend (NULL);
			}
		}
		//j// else [($direct_settings['a'] == "info")]
		else
		{
			if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=info_ (#echo(__LINE__)#)"); }

			$g_loaded_extensions = get_loaded_extensions ();
			natsort ($g_loaded_extensions);
			$g_loaded_extensions = implode (", ",$g_loaded_extensions);

/* -------------------------------------------------------------------------
Show me the credits - please do not remove
------------------------------------------------------------------------- */

$direct_globals['output']->output_content = ("<p class='pagecontent' style='text-align:center'><strong>$direct_settings[product_lcode_html]</strong> $direct_settings[product_version] - <strong>Program information</strong></p>
<p class='pagecontent' style='text-align:center'><strong>About the developers</strong></p>
<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Developer:</strong> <a href='http://www.direct-netware.de/redirect.php?web;en' target='_blank'><em>direct</em> Netware Group</a><br />
<strong>Copyright holder:</strong> <a href='http://www.direct-netware.de' target='_blank'><em>direct</em> Netware Group</a> - All rights reserved</p>
<p class='pagecontent' style='text-align:center'><strong>About the $direct_settings[product_lcode_html]</strong></p>
<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Program version:</strong> $direct_settings[product_version]<br />
<strong>Build-ID:</strong> $direct_settings[product_buildid]<br />
<strong>Interlinking-ID:</strong> <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'>$direct_settings[product_icode]</a></p>");

/* -------------------------------------------------------------------------
Show me the basic settings
------------------------------------------------------------------------- */

			$direct_globals['output']->output_content .= "<p class='pagecontent' style='text-align:center;font-size:10px'>Error reporting is ";
			$direct_globals['output']->output_content .= (OW_error_reporting ? "off" : "on");
/*#ifdef(PHP4):
			$direct_globals['output']->output_content .= "<br />\nMagic_Quotes_Runtime overwriting is ";
			$direct_globals['output']->output_content .= (OW_magic_quotes_runtime ? "on" : "off");
:#\n*/
			$direct_globals['output']->output_content .= "<br />\nCompression for output (if available) is ";
			$direct_globals['output']->output_content .= (((USE_outputenc)&&(extension_loaded ("zlib"))) ? "on" : "off");

			$direct_globals['output']->output_content .= "<br />\nUsing SOCKET functions is ";
			$direct_globals['output']->output_content .= (USE_socket ? "on" : "off");

$direct_globals['output']->output_content .= ("<br />
Timeout value is $direct_settings[timeout] (core: +$direct_settings[timeout_core])<br />
Light version activation value is $direct_settings[timeout_lightmode]</p>");

/* -------------------------------------------------------------------------
Show me the system configuration (in debug mode) - thank you
------------------------------------------------------------------------- */

		if (USE_debug_reporting)
		{
$direct_globals['output']->output_content .= ("<p class='pagecontent' style='text-align:center'><strong>About the server</strong></p>
<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Installed PHP version:</strong> ").PHP_VERSION.(" [Zend Engine ").(zend_version ()).("]<br />
<strong>Running operation system:</strong> ").PHP_OS.(" [").(php_uname ()).("]<br />
<strong>Activated PHP extensions:</strong> $g_loaded_extensions</p>");
		}

			direct_class_init ("output_theme");

			$direct_globals['output']->header (false,true);
			$direct_globals['output']->outputSend ($direct_settings['product_lcode_htmltitle']);

			$direct_cachedata['core_service_activated'] = true;
		}
	}
	else
	{
		//j// Switching to kernel

/* -------------------------------------------------------------------------
The following call will initiate the so called kernel
------------------------------------------------------------------------- */

		if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
/*#ifndef(PHP4) */

		try/* #*/
		{
			if (file_exists ($direct_settings['path_system']."/swg_kernel.php")) { include_once ($direct_settings['path_system']."/swg_kernel.php"); }
		}
/*#ifndef(PHP4) */
		catch (Exception $g_handled_exception) { $g_error = $g_handled_exception->getMessage (); }
/* #\n*/
	}

	//j// Fetching fatal errors

/* -------------------------------------------------------------------------
If the kernel or startup fail, the error will still be displayed
------------------------------------------------------------------------- */

	if (!$direct_cachedata['core_service_activated'])
	{
/* -------------------------------------------------------------------------
Create instances of required classes
------------------------------------------------------------------------- */

		$g_service_error = NULL;

		if ((isset ($direct_globals['kernel']))&&(direct_class_function_check ($direct_globals['kernel'],"serviceInit"))) { $g_service_error = $direct_globals['kernel']->serviceInit (); }
		else { direct_class_init ("basic_functions"); }

		direct_class_init ("output");

/*#ifndef(PHP4) */
		if (isset ($g_error)) { $g_error = array ("core_unknown_error","FATAL ERROR:<br />Unknown exception catched: ".$g_error,"The WebGine has catched an unknown error.<br /><br />Unknown exception catched: ".$g_error,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
		elseif (empty ($g_service_error)) { $g_error = array ("core_unsupported_command","FATAL ERROR: Request terminated","The WebGine has been accessed using an unknown command.<br /><br />Request terminated","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
		else { $g_error = $g_service_error; }

		try/* #\n*/
/*#ifdef(PHP4):
		$g_error = (isset ($g_service_error) ? $g_service_error : array ("core_unsupported_command","FATAL ERROR: Request terminated","The WebGine has been accessed using an unknown command.<br /><br />Request terminated","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"));
:#*/
		{
			if (direct_class_function_check ($direct_globals['output'],"outputSendError"))
			{
				$direct_globals['output']->outputHeader ("HTTP/1.1","HTTP/1.1 500 Internal Server Error",true);

				if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->outputSendError ("fatal",$g_error[0],$g_error[1],$g_error[3]); }
				else { $direct_globals['output']->outputSendError ("fatal",$g_error[2],$g_error[1],$g_error[3]); }
			}
			else
			{
				header ("HTTP/1.1 500 Internal Server Error");
				echo ($g_error[1]);
			}
		}
/*#ifndef(PHP4) */
		catch (Exception $g_handled_exception)
		{
			if (!$direct_cachedata['core_service_activated'])
			{
				header ("HTTP/1.1 500 Internal Server Error");
				echo ($g_handled_exception->getMessage ());
			}
		}
/* #\n*/
	}
}
else
{
	header ("HTTP/1.1 500 Internal Server Error");
	echo ("Required core files not available.");
}

//j// EOF
?>