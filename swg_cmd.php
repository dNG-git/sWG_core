<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

This Source Code Form is subject to the terms of the Mozilla Public License,
v. 2.0. If a copy of the MPL was not distributed with this file, You can
obtain one at http://mozilla.org/MPL/2.0/.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;mpl2
----------------------------------------------------------------------------
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* This is the console PHP file for the secured WebGine. It will secure inputs,
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
* @since     v0.1.08
* @license   http://www.direct-netware.de/redirect.php?licenses;mpl2
*            Mozilla Public License, v. 2.0
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Check and set constants to their default values if necessary.
------------------------------------------------------------------------- */

if (!defined ("OW_error_reporting")) { define ("OW_error_reporting",false); }
if (!defined ("OW_set_time_limit_custom")) { define ("OW_set_time_limit_custom",false); }
if (!defined ("USE_backtrace")) { define ("USE_backtrace",true); }
if (!defined ("USE_charset_html_filtering")) { define ("USE_charset_html_filtering",true); }
if (!defined ("USE_cookies")) { define ("USE_cookies",true); }
if (!defined ("USE_debug_reporting")) { define ("USE_debug_reporting",true); }

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
elseif (USE_set_time_limit_20) { set_time_limit (20); }
else { set_time_limit (0); }

if (!defined ("INFO_magic_quotes_input")) { define ("INFO_magic_quotes_input",(get_magic_quotes_gpc ())); }
if (!defined ("INFO_magic_quotes_runtime")) { define ("INFO_magic_quotes_runtime",(get_magic_quotes_runtime ())); }
if (!defined ("INFO_magic_quotes_sybase")) { define ("INFO_magic_quotes_sybase",(get_cfg_var ("magic_quotes_sybase"))); }

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
$direct_cachedata['core_debug_starttime'] = /*#ifndef(PHP4) */microtime (true)/* #*//*#ifdef(PHP4):time ():#*/;

/* -------------------------------------------------------------------------
Set up variables that can be changed with an integration script.
------------------------------------------------------------------------- */

$g_variables = array (
"swg_ihandler" => array (&$swg_ihandler,"ihandler","cmd"),
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

if (!isset ($direct_settings['iscript'])) { $direct_settings['iscript'] = $_SERVER['PHP_SELF']; }

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

$direct_settings['timeout'] = 3600;
$direct_settings['timeout_core'] = 3600;
$direct_settings['timeout_lightmode'] = 3600;

//j// Functions and classes

if (file_exists ($direct_settings['path_system']."/functions/swg_inline_functions.php")) { include_once ($direct_settings['path_system']."/functions/swg_inline_functions.php"); }
if (file_exists ($direct_settings['path_system']."/functions/swg_phpback.php")) { include_once ($direct_settings['path_system']."/functions/swg_phpback.php"); }

//j// Script specific commands

if ((function_exists ("direct_autoload"))&&(direct_autoload ('dNG\sWG\directVirtualClass'))&&(direct_autoload ('dNG\sWG\directActionParserCmd'))&&(direct_autoload ('dNG\sWG\directOHandlerCmd')))
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

	$g_variables = /*#ifdef(PHP5n) */dNG\sWG\directActionParserCmd::ilineParse ()/* #*//*#ifndef(PHP5n):directActionParserCmd::ilineParse ():#*/;
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

	if (($direct_settings['m'] == "default")&&($direct_settings['s'] == "index")&&($direct_settings['a'] == "info"))
	{
/* -------------------------------------------------------------------------
Create instances of required classes
------------------------------------------------------------------------- */

		if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=info_ (#echo(__LINE__)#)"); }

		direct_class_init ("output");

		$g_loaded_extensions = get_loaded_extensions ();
		natsort ($g_loaded_extensions);
		$g_loaded_extensions = implode (", ",$g_loaded_extensions);

/* -------------------------------------------------------------------------
Show me the credits - please do not remove
------------------------------------------------------------------------- */

$direct_globals['output']->output_content = ("<p style='text-align:center'><strong>$direct_settings[product_lcode_html]</strong>".(USE_debug_reporting ? " ".$direct_settings['product_version'] : "")." - <strong>Program information</strong></p>
<p style='text-align:center'><strong>About the developers</strong></p>
<p style='text-align:center;font-size:10px'><strong>Developer:</strong> <a href='http://www.direct-netware.de/redirect.php?web;en' target='_blank'><em>direct</em> Netware Group</a><br />
<strong>Copyright holder:</strong> <a href='http://www.direct-netware.de' target='_blank'><em>direct</em> Netware Group</a> - All rights reserved</p>");

		if (USE_debug_reporting)
		{
$direct_globals['output']->output_content .= ("\n<p style='text-align:center'><strong>About the $direct_settings[product_lcode_html]</strong></p>
<p style='text-align:center;font-size:10px'><strong>Program version:</strong> $direct_settings[product_version]<br />
<strong>Build-ID:</strong> $direct_settings[product_buildid]<br />
<strong>Interlinking-ID:</strong> <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'>$direct_settings[product_icode]</a></p>
<p style='text-align:center;font-size:10px'>Error reporting is ".(OW_error_reporting ? "off" : "on"));
/*#ifdef(PHP4):
			$direct_globals['output']->output_content .= "<br />\nMagic_Quotes_Runtime overwriting is ";
			$direct_globals['output']->output_content .= (OW_magic_quotes_runtime ? "on" : "off");
:#\n*/
$direct_globals['output']->output_content .= ("<br />\nCompression for output (if available) is ".(((USE_outputenc)&&(extension_loaded ("zlib"))) ? "on" : "off")."<br />
Using SOCKET functions is ".(USE_socket ? "on" : "off")."<br />
Timeout value is $direct_settings[timeout] (core: +$direct_settings[timeout_core])<br />
Light version activation value is $direct_settings[timeout_lightmode]</p>
<p style='text-align:center'><strong>About the server</strong></p>
<p style='text-align:center;font-size:10px'><strong>Installed PHP version:</strong> ").PHP_VERSION.(" [Zend Engine ").(zend_version ()).("]<br />
<strong>Running operation system:</strong> ").PHP_OS.(" [").(php_uname ()).("]<br />
<strong>Activated PHP extensions:</strong> $g_loaded_extensions</p>");
		}

		direct_class_init ("output_theme");

		$direct_globals['output']->header (false,true);
		$direct_globals['output']->outputSend ($direct_settings['product_lcode_htmltitle']);

		$direct_cachedata['core_service_activated'] = true;
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