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

if (!defined ("OW_error_reporting")) { define ("OW_error_reporting",false); }
/*#ifdef(PHP4):if (!defined ("OW_magic_quotes_runtime")) { define ("OW_magic_quotes_runtime",true); }:#\n*/
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
/*#ifdef(PHP4):if (OW_magic_quotes_runtime) { set_magic_quotes_runtime (0); }:#\n*/
ignore_user_abort (1);
mt_srand (/*#ifdef(PHP4):((double)microtime ()) * 1000000:#*/);

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
/*#ifndef(PHP4) */$direct_cachedata['core_debug_starttime'] = microtime (true);/* #*//*#ifdef(PHP4):$direct_cachedata['core_debug_starttime'] = time ();:#*/

/* -------------------------------------------------------------------------
Identify the request
------------------------------------------------------------------------- */

$g_variables = direct_basic_functions_inline::iline_parse ();
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
If there is no action or service defined, set "index"
------------------------------------------------------------------------- */

if ($direct_settings['a'] == "") { $direct_settings['a'] = "index"; }
if ($direct_settings['m'] == "") { $direct_settings['m'] = "default"; }
if ($direct_settings['s'] == "") { $direct_settings['s'] = "index"; }

/* -------------------------------------------------------------------------
Evalute the available timeout (not getting a timeout error)
------------------------------------------------------------------------- */

$direct_settings['timeout'] = 3600;
$direct_settings['timeout_core'] = 3600;
$direct_settings['timeout_lightmode'] = 3600;

//j// Functions and classes

if (file_exists ($direct_settings['path_system']."/functions/swg_phpback.php")) { include_once ($direct_settings['path_system']."/functions/swg_phpback.php"); }

/**
* This is the root for all other classes and provides our "Virtual Binding"
* functionality.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.05
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_virtual_class
{
/**
	* @var array $functions Array to save active functions
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $functions;

/* -------------------------------------------------------------------------
Construct the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (direct_virtual_class)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->__construct (direct_virtual_class)- (#echo(__LINE__)#)"); }

		$this->functions = array ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['debug'] = true;
		$this->functions['debug_walker'] = true;
		$this->functions['v_call'] = true;
		$this->functions['v_call_check'] = true;
		$this->functions['v_call_get'] = true;
		$this->functions['v_call_rref'] = true;
		$this->functions['v_call_set'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_virtual_class
	* (direct_virtual_class)
	*
	* @since v0.1.01
*\/
	function direct_virtual_class () { $this->__construct (); }
:#\n*/
/**
	* Destructor (PHP5) __destruct (direct_virtual_class)
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct ()
	{
		// Nothing to do for me
	}

/* -------------------------------------------------------------------------
This clone function is not defined because we are happy with PHP's default
behavior
------------------------------------------------------------------------- */

	// Run PHP-internal function __clone () { ... }

/**
	* This operation prints $this->dvar to the browser (and exists) or to
	* $direct_cachedata['core_debug'].
	*
	* @param boolean $f_exit True to print_r and exit
	* @param array $f_data External array (will overwrite the $this->var
	*        output)
	* @uses  direct_virtual_class::debug_walker()
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function debug ($f_exit = false,$f_data = "")
	{
		global $direct_cachedata;

		if (!is_array ($f_data)) { $f_data = get_object_vars ($this); }

		if ($f_exit)
		{
			echo $this->debug_walker ($f_data);
			echo "\n\n".$this->debug_walker ($direct_cachedata['core_debug']);
			echo "\n\n".$this->debug_walker ($direct_cachedata['core_error']);
			exit ();
		}
		else
		{
$direct_cachedata['output_warning'][] = array ("title" => direct_html_encode_special ("sWG/#echo(__FILEPATH__)# -virtual_class->debug (+f_exit,+f_data)- (#echo(__LINE__)#)"),"text" => ($this->debug_walker ($f_data))."

".($this->debug_walker ($direct_cachedata['core_error'])));
		}
	}

/**
	* Recursively read, convert and return given input data.
	*
	* @param  array $f_data Input array to walk through
	* @uses   direct_debug()
	* @uses   direct_debug_value()
	* @uses   USE_debug_reporting
	* @return string List of variable types and contents
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */protected /* #*/function debug_walker ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -virtual_class->debug_walker (+f_data)- (#echo(__LINE__)#)"); }
		$f_return = "";

		if (is_array ($f_data))
		{
			foreach ($f_data as $f_key => $f_value)
			{
				if ($f_return) { $f_return .= "\n"; }
				$f_return .= $f_key.": ".(direct_debug_value ($f_value));
			}
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -virtual_class->debug_walker ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* The sWG provides a method called "Virtual Binding" to add non class methods
	* or functions virtually to the object. This method is used to call these
	* virtual methods (or real ones if not applicable). Normally we use
	* "call_user_func" to support "Virtual Binding". This is about 4 times slower
	* than dynamic function calls ($example->$callme ()). We strongly recommend
	* to use and support v_ function calls if possible.
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_check()
	* @uses   USE_debug_reporting
	* @return mixed Returned data from method (NULL on error)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_call ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call (...)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = NULL;

		if (!empty ($f_data))
		{
			$f_function = $f_data[0];
			unset ($f_data[0]);

			if ($this->v_call_check ($f_function))
			{
				if (is_array ($this->functions[$f_function])) { $f_return = (empty ($f_data) ? $this->functions[$f_function][0]->{$this->functions[$f_function][1]} () : call_user_func_array ($this->functions[$f_function],$f_data)); }
				else { $f_return = (empty ($f_data) ? $this->{$f_function} () : call_user_func_array ((array (&$this,$f_function)),$f_data)); }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Check if a method exists.
	*
	* @param  string $f_function Function name
	* @param  boolean $f_virtual_type True to check for "Virtual Bindings"
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if the method is available
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_call_check ($f_function,$f_virtual_type = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_check ($f_function,+f_virtual_type)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = false;

		if ((is_string ($f_function))&&(!empty ($f_function)))
		{
			if (isset ($this->functions[$f_function]))
			{
				if (($f_virtual_type)&&(isset ($this->functions[$f_function]))&&(!empty ($this->functions[$f_function]))) { $f_return = true; }
				elseif ((!$f_virtual_type)&&($this->functions[$f_function])) { $f_return = true; }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_check ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Returns the callable array or false if it is either a invalid function name
	* or not allowed to be a "Virtual Binding".
	*
	* @param  string $f_function Function name
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_check()
	* @uses   USE_debug_reporting
	* @return mixed Callable array or false on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */protected /* #*/function v_call_get ($f_function)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_get ($f_function)- (#echo(__LINE__)#)"); }
		return ($this->v_call_check ($f_function,true) ? $this->functions[$f_function] : false);
	}

/**
	* This method is similar to v_call but will return a reference to the
	* resulting object.
	*
	* @param  string $f_function Function name
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_check()
	* @uses   USE_debug_reporting
	* @return mixed Returned data from method (NULL on error)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function &v_call_rref ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_rref (...)- (#echo(__LINE__)#)"); }

		$f_data = func_get_args ();
		$f_return = NULL;

		if (!empty ($f_data))
		{
			$f_function = $f_data[0];
			unset ($f_data[0]);

			if ($this->v_call_check ($f_function))
			{
				if (is_array ($this->functions[$f_function]))
				{
					if (empty ($f_data)) { $f_return =& $this->functions[$f_function][0]->{$this->functions[$f_function][1]} (); }
					else { $f_return =& call_user_func_array ($this->functions[$f_function],$f_data); }
				}
				else
				{
					if (empty ($f_data)) { $f_return =& $this->{$f_function} (); }
					else { $f_return =& call_user_func_array ((array (&$this,$f_function)),$f_data); }
				}
			}
		}

		return $f_return;
	}

/**
	* Sets and overwrites a "Virtual Binding".
	*
	* @param  string $f_function Function name
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Callable array or false on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_call_set ($f_function_virtual,&$f_object,$f_function)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_set ($f_function_virtual,+f_object,$f_function)- (#echo(__LINE__)#)"); }
		$f_return = false;

		if ((is_string ($f_function_virtual))&&(!empty ($f_function_virtual)))
		{
			if (isset ($this->functions[$f_function_virtual]))
			{
				if (is_array ($this->functions[$f_function_virtual]))
				{
					$this->functions[$f_function_virtual] = array ($f_object,$f_function);
					$f_return = true;
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -virtual_class->v_call_set ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Define this class
------------------------------------------------------------------------- */

define ("CLASS_direct_virtual_class",true);

/**
* The following class is our namespace for basic (inline) functions.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @uses       CLASS_direct_virtual_class
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_basic_functions_inline extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (direct_basic_functions_inline)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_functions_class->__construct (direct_basic_functions_inline)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['iline_parse'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_basic_functions_inline
	* (direct_basic_functions_inline)
	*
	* @since v0.1.01
*\/
	function direct_basic_functions_inline () { $this->__construct (); }
:#\n*/
/**
	* We are trying to catch all errors - even semi-fatal ones. For that reason
	* we provide the emergency mode function that does not require an active theme
	* or localiation strings to work.
	*
	* @param string $f_iline Input query string with ";" delimiter.
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_oxhtml_inline::header()
	* @uses  direct_oxhtml_inline::output_send()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public static /* #*/function iline_parse ($f_iline = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basic_functions_class->iline_parse (+f_line)- (#echo(__LINE__)#)"); }

		if (!isset ($f_iline))
		{
			if ((isset ($_SERVER['argc']))&&($_SERVER['argc'] > 2))
			{
				$direct_settings['iscript'] = $_SERVER['argv'][0];
				$f_iline = $_SERVER['argv'][2];
			}
			else
			{
				$direct_settings['iscript'] = basename ($_SERVER['argv'][0]);
				$f_iline = $_SERVER['argv'][1];
			}
		}

		$f_iline_array = explode (";",$f_iline);
		$f_return = array ();

		foreach ($f_iline_array as $f_iline)
		{
			$f_value_array = explode ("=",$f_iline,2);

			if (count ($f_value_array) > 1) { $f_return[$f_value_array[0]] = $f_value_array[1]; }
			elseif (!isset ($f_return['ohandler'])) { $f_return['ohandler'] = preg_replace ("#\W#","",$f_iline); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basic_functions_class->iline_parse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}
/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['basic_functions'] = "direct_basic_functions_inline";
define ("CLASS_direct_basic_functions_inline",true);

/**
* The following class is the basic (inline) output system, giving everybody
* functions for headers and the internal sWG page theme.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage output
* @uses       CLASS_direct_virtual_class
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_output_inline extends direct_virtual_class
{
/**
	* @var integer $last_modified Variable to save the oset data
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $last_modified;
/**
	* @var string $output_content Variable containing the content
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_content;
/**
	* @var string $output_data This variable contains the result data
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_data;
/**
	* @var array $output_headers Headers are used by the final node
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers;
/**
	* @var integer $output_headers_index Current named headers index
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers_index;
/**
	* @var array $output_headers_indexed Headers using a header index
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers_indexed;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (direct_output_inline)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class(inline)->__construct (direct_output_inline)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['header'] = true;
		$this->functions['last_modified'] = true;
		$this->functions['theme_page'] = true;
		$this->functions['output_header'] = true;
		$this->functions['output_response'] = true;
		$this->functions['output_send'] = true;
		$this->functions['output_send_error'] = true;

/* -------------------------------------------------------------------------
Set "last modified" time to "0".
------------------------------------------------------------------------- */

		$this->last_modified = 0;
		$this->output_content = NULL;
		$this->output_data = NULL;
		$this->output_headers = array ();
		$this->output_headers_index = 0;
		$this->output_headers_indexed = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_inline (direct_output_inline)
	*
	* @since v0.1.01
*\/
	function direct_output_inline () { $this->__construct (); }
:#*/
/**
	* Important headers will be created here. This includes caching, cookies, the
	* compression setting and information about P3P.
	*
	* @param boolean $f_cacheing Allow caching at client
	* @param boolean $f_withenc Send page GZip encoded (if supported)
	* @param string $f_p3purl Valid P3P-URL
	* @param string $f_p3pcp Valid P3P header string
	* @uses  direct_debug()
	* @uses  USE_cookies
	* @uses  USE_debug_reporting
	* @uses  USE_outputenc
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function header ($f_cacheing = false,$f_withenc = true,$f_p3purl = "",$f_p3pcp = "")
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->header ($f_cacheing,$f_withenc,+f_p3purl,+f_p3pcp)- (#echo(__LINE__)#)"); }

		if ($f_cacheing)
		{
			$f_headers = array ("Cache-Control" => "public");
			$f_expires = gmdate ("D, d M Y H:i:s",($direct_cachedata['core_time'] + 18748800));
			if (!$this->last_modified) { $f_last_modified = "Thu, 01 Jan 2004 00:00:00"; }
		}
		else
		{
			$f_headers = array ("Cache-Control" => "no-cache, must-revalidate","Pragma" => "no-cache");
			$f_expires = gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']);
			if (!$this->last_modified) { $f_last_modified = gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']); }
		}

		$f_headers['Expires'] = $f_expires." GMT";
		if ($this->last_modified) { $f_last_modified = gmdate ("D, d M Y H:i:s",$this->last_modified); }
		$f_headers['Last-Modified'] = $f_last_modified." GMT";

		if (!empty ($direct_cachedata['core_cookies']))
		{
			$f_headers['Set-Cookie'] = array ();
			foreach ($direct_cachedata['core_cookies'] as $f_cookie) { $f_headers['Set-Cookie'][] = $f_cookie; }
		}

		$this->output_headers = array_merge ($this->output_headers,$f_headers);
	}

/**
	* Set's a custom "last modified" header entry for the upcoming output.
	*
	* @param integer $f_timestamp UNIX timestamp
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function last_modified ($f_timestamp)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->last_modified ($f_timestamp)- (#echo(__LINE__)#)"); }
		$this->last_modified = $f_timestamp;
	}

/**
	* Returns or sets a header.
	*
	* @param string $f_name Header name
	* @param mixed $f_value Header value as string or array
	* @param boolean $f_name_as_key True if the name is used as a key
	* @param boolean $f_value_append True if headers should be appended
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function output_header ($f_name = "",$f_value = NULL,$f_name_as_key = false,$f_value_append = false)
	{
		$f_return = NULL;

		if (isset ($f_value))
		{
			if ($f_name_as_key)
			{
				if (isset ($this->output_headers_indexed[$f_name]))
				{
					if ($f_value_append)
					{
						if (is_array ($this->output_headers[$this->output_headers_indexed[$f_name]])) { $f_value = array_merge ($this->output_headers[$this->output_headers_indexed[$f_name]],(array ($f_value))); }
						else { $f_value = array ($this->output_headers[$this->output_headers_indexed[$f_name]],$f_value); }
					}

					$this->output_headers[$this->output_headers_indexed[$f_name]] = $f_value;
				}
				else
				{
					$this->output_headers[$this->output_headers_index] = $f_value;
					$this->output_headers_indexed[$f_name] = $this->output_headers_index;
					$this->output_headers_index++;
				}
			}
			elseif (is_array ($f_value)) { $this->output_headers[$f_name] = ((count ($f_value) > 1) ? $f_value : array_pop ($f_value)); }
			elseif (($f_value_append)&&(isset ($this->output_headers[$f_name])))
			{
				if (is_array ($this->output_headers[$f_name])) { $f_value = array_merge ($this->output_headers[$f_name],(array ($f_value))); }
				else { $f_value = array ($this->output_headers[$f_name],$f_value); }
			}
			else { $this->output_headers[$f_name] = $f_value; }
		}
		elseif (isset ($this->output_headers[$f_name])) { $f_return = $this->output_headers[$f_name]; }
		elseif (($f_name_as_key)&&(isset ($this->output_headers_indexed[$f_name]))) { $f_return = $this->output_headers[$this->output_headers_indexed[$f_name]]; }

		return $f_return;
	}

/**
	* This function will actually send the prepared content and debug information
	* to user.
	*
	* @param string $f_title Valid XHTML page title
	* @param array $f_headers Additional output headers
	* @uses  direct_debug()
	* @uses  direct_html_encode_special()
	* @uses  direct_local_get()
	* @uses  direct_output_inline::theme_page()
	* @uses  direct_outputenc_xhtml_legacy()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function output_response ($f_title = "",$f_headers = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->output_response (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		if ((!isset ($direct_local['lang_charset']))||(!$direct_local['lang_charset'])) { $direct_local['lang_charset'] = "UTF-8"; }
		echo "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><swg xmlns='urn:de-direct-netware-xmlns:swg.v1'>";

		if (is_array ($direct_settings['dsd']))
		{
			$f_debug_inline = isset ($direct_settings['dsd']['debug_inline']);
			$f_debug_text = isset ($direct_settings['dsd']['debug_text']);
			$f_debug_xml = isset ($direct_settings['dsd']['debug_xml']);
		}
		else
		{
			$f_debug_inline = false;
			$f_debug_text = false;
			$f_debug_xml = false;
		}

		if ((USE_debug_reporting)&&(($f_debug_text)||($f_debug_xml)))
		{
			if ($f_debug_xml)
			{
				if ((is_array ($direct_cachedata['core_debug']))&&(!empty ($direct_cachedata['core_debug'])))
				{
					echo "<debug>";

					$f_line = 0;

					foreach ($direct_cachedata['core_debug'] as $f_line_data)
					{
						$f_line++;
						$f_line_data = str_replace ("]]>","]]&gt;",$f_line_data);
						echo "<step line='$f_line'><![CDATA[{$f_line_data}]]></step>";
					}

					echo "</debug>";
				}

				if ((is_array ($direct_cachedata['core_error']))&&(!empty ($direct_cachedata['core_error'])))
				{
					echo "<errors>";
					$f_line = 0;

					foreach ($direct_cachedata['core_error'] as $f_line_data)
					{
						$f_line++;
						$f_line_data = str_replace ("]]>","]]&gt;",$f_line_data);
						echo "<error number='$f_line'><![CDATA[{$f_line_data}]]></error>";
					}

					echo "</errors>";
				}
			}
		}
		elseif (isset ($f_title))
		{
			if ($f_title)
			{
				if (isset ($direct_settings['swg_title_txt'])) { $f_title = (direct_html_encode_special ($direct_settings['swg_title_txt'])).": ".$f_title; }
			}
			else { $f_title = direct_html_encode_special ($direct_settings['swg_title_txt']); }

			echo "<title><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_title))."]]></title>";

			if ($f_debug_inline)
			{
				echo "<debug>";

				if ((USE_debug_reporting)&&(is_array ($direct_cachedata['core_debug']))&&(!empty ($direct_cachedata['core_debug'])))
				{
					foreach ($direct_cachedata['core_debug'] as $f_line_data) { echo "<debug><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_line_data))."]]></debug>"; }
				}

				if ((is_array ($direct_cachedata['core_error']))&&(!empty ($direct_cachedata['core_error'])))
				{
					foreach ($direct_cachedata['core_error'] as $f_line_data) { echo "<error><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_line_data))."]]></error>"; }
				}

				echo "</debug>";
			}

			if ((isset ($this->output_data))&&(function_exists ($this->output_data))) { $this->output_data (); }
			$this->output_response_headers ();

			$this->output_content = "<data><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$this->output_content))."]]></data>";
			$this->output_response_data ($this->output_content);
		}
		else
		{
			$this->output_response_headers ();

			if (($this->output_data)||(!is_string ($this->output_header ("HTTP/1.1",NULL,true)))) { $this->output_response_data ($this->output_data); }
			else { $this->output_send_error ("fatal",($this->output_header ("HTTP/1.1",NULL,true)),"","sWG/#echo(__FILEPATH__)# -output_class->output_response ()- (#echo(__LINE__)#)"); }
		}

		$f_debug_endtime = /*#ifndef(PHP4) */microtime (true)/* #*//*#ifdef(PHP4):time ():#*/;

		if (USE_debug_reporting)
		{
			if (!$f_debug_text) { echo "<!--\n"; }

echo ("Delivered page after: ".($f_debug_endtime - $direct_cachedata['core_debug_starttime'])."
Debug checkpoints reached: ".(count ($direct_cachedata['core_debug']))."
Errors: ".(count ($direct_cachedata['core_error'])));

			if (function_exists ("memory_get_usage")) { echo "\nMemory in use: ".(memory_get_usage (true))." bytes"; }

			if ($f_debug_text)
			{
echo ("\n\nDebug checkpoint list:
".(implode ("\n",$direct_cachedata['core_debug']))."

Error list:
".(implode ("\n",$direct_cachedata['core_error'])));
			}

			echo "\n\n$direct_settings[product_lcode_txt] $direct_settings[product_version] ($direct_settings[product_buildid])\nhttp://www.direct-netware.de/redirect.php?$direct_settings[product_icode]";
			if (!$f_debug_text) { echo "\n// -->"; }
		}
		elseif (isset ($f_title))
		{
echo ("<!--
Delivered page after: ".($f_debug_endtime - $direct_cachedata['core_debug_starttime'])." seconds
$direct_settings[product_lcode_txt]
// -->");
		}

		echo "</swg>";
	}

/**
	* Send the content of a page.
	*
	* @param string &$f_data Data to send
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */protected /* #*/function output_response_data (&$f_data) { echo $f_data; }

/**
	* This function will actually send the prepared headers to user.
	*
	* @param string $f_title Valid XHTML page title
	* @uses  direct_debug()
	* @uses  direct_html_encode_special()
	* @uses  direct_local_get()
	* @uses  direct_output_inline::theme_page()
	* @uses  direct_outputenc_xhtml_legacy()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */protected /* #*/function output_response_headers ()
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->output_response_headers ()- (#echo(__LINE__)#)"); }
		echo "<headers>";

		foreach ($this->output_headers as $f_header_name => $f_header_value)
		{
			if (is_int ($f_header_name)) { echo "<header>$f_header_value</header>"; }
			elseif (is_array ($f_header_value))
			{
				foreach ($f_header_value as $f_header_array_value)
				{
					echo "<header>";
					foreach ($f_header_value as $f_header_array_value) { echo "<header>$f_header_name: $f_header_value</header>"; }
					echo "</header>";
				}
			}
			else { echo "<header>$f_header_name: $f_header_value</header>"; }
		}

		echo "</headers>";
	}

/**
	* This function is used for later multi-level delivery. Only the final
	* node actually sends data to the requesting client.
	*
	* @param string $f_title Valid XHTML page title
	* @uses  direct_output_inline::output_response()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function output_send ($f_title = "",$f_headers = NULL) { $this->output_response ($f_title,$f_headers); }

/**
	* We are trying to catch all errors - even semi-fatal ones. For that reason
	* we provide the emergency mode function that does not require an active theme
	* or localiation strings to work.
	*
	* @param string $f_type Ignored error type - if this function is called,
	*        it is an emergency error. 
	* @param string $f_error A key for localisation strings or an error message
	* @param string $f_extra_data More detailed information to track down the
	*        problem
	* @param string $f_error_position Position where the error occurred
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_output_inline::header()
	* @uses  direct_output_inline::output_send()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->output_send_error ($f_type,$f_error,+f_extra_data,$f_error_position)- (#echo(__LINE__)#)"); }

		if ((!preg_match ("#\W#i",$f_error))&&(function_exists ("direct_local_get"))) { $f_error = direct_local_get ("errors_".$f_error); }

		if (strlen ($f_extra_data))
		{
			$f_extra_data = "\n<p class='pagecontent' style='text-align:center'>".$f_extra_data;
			if ((USE_debug_reporting)&&($f_error_position)) { $f_extra_data .= "<br />\n<span style='font-size:10px'>$f_error_position</span>"; }
			$f_extra_data .= "</p>";
		}
		elseif ((USE_debug_reporting)&&($f_error_position)) { $f_extra_data = "\n<p class='pagecontent' style='text-align:center;font-size:10px'>$f_error_position</p>"; }

$direct_globals['output']->output_content = ("<p class='pagecontent' style='text-align:center'><strong>$direct_settings[product_lcode_html]</strong> $direct_settings[product_version]</p>
<p class='pagecontent' style='text-align:center'><strong style='color:#FF0000'>Entering emergency mode:</strong><br />
$f_error</p>$f_extra_data
<p class='pagecontent' style='text-align:center;font-size:10px'>If this seems to be a bug then please <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode];itracker;bug' target='_blank'>report</a> it.</p>");

		if (USE_debug_reporting)
		{
			if (!empty ($direct_cachedata['core_debug']))
			{
				$f_data = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
				$direct_globals['output']->output_content .= ("\n<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Debug Data List:</strong><br />\n".(implode ("<br />\n",$f_data))."</p>");
			}

			if (!empty ($direct_cachedata['core_error']))
			{
				$f_data = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
				$direct_globals['output']->output_content .= ("\n<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Error List:</strong><br />\n".(implode ("<br />\n",$f_data))."</p>");
			}
		}

		$direct_globals['output']->header (false,true);
		$direct_globals['output']->output_send ($direct_settings['product_lcode_htmltitle']);

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new RuntimeException ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}

/**
	* Prepare an output for a XHTML encoded page with the standard sWG design.
	*
	* @param string $f_title Valid XHTML page title
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function theme_page ($f_title)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class(inline)->theme_page ($f_title)- (#echo(__LINE__)#)"); }

		if ((!isset ($direct_local['lang_iso_domain']))||(!$direct_local['lang_iso_domain'])) { $direct_local['lang_iso_domain'] = "en"; }
		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];

		$direct_globals['output']->output_header ("Content-Type",$direct_settings['theme_xhtml_type']);
		$this->output_data = $direct_globals['output']->output_content;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['output'] = "direct_output_inline";
$direct_globals['@names']['output_theme'] = "direct_output_inline";
define ("CLASS_direct_output_inline",true);

/**
* PHP's "__autoload ()"-function will be used to load additional, missing
* classes if they are matching our default name convention.
*
* @param string $f_class Requested but missing class name
* @uses  direct_basic_functions::include()
* @uses  direct_basic_functions::varfilter()
* @uses  direct_class_function_check()
* @uses  direct_debug()
* @uses  USE_debug_reporting
* @since v0.1.01
*/
function __autoload ($f_class)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -__autoload ($f_class)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Search for the requested class ...
------------------------------------------------------------------------- */

	$f_class = preg_replace ("#^direct_#","",$f_class);
	$f_include_check = false;

	if (isset ($direct_globals['basic_functions']))
	{
		if ((isset ($direct_settings['swg_autoload_extensions']))&&(is_array ($direct_settings['swg_autoload_extensions'])))
		{
			foreach ($direct_settings['swg_autoload_extensions'] as $f_extension)
			{
				if (!$f_include_check) { $f_include_check = $f_extension ($f_class); }
			} 
		}

		if ((!$f_include_check)&&(direct_class_function_check ($direct_globals['basic_functions'],"include_file")))
		{
			$f_include_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/dhandler/swg_$f_class.php");
			if (!$f_include_check) { $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_$f_class.php"); }
		}
	}
}

/**
* Check for a specific function of a specific class.
*
* @param  object $f_class Object where the function should exist
* @param  string $f_function Name of the function
* @uses   direct_virtual_class::v_call_check()
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True if the function exists
* @since  v0.1.01
*/
function direct_class_function_check (&$f_class,$f_function)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_class_function_check (+f_class,$f_function)- (#echo(__LINE__)#)"); }

	if ((is_object ($f_class))&&($f_class != NULL)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_function_check ()- (#echo(__LINE__)#)",:#*/(is_subclass_of ($f_class,"direct_virtual_class") ? $f_class->v_call_check ($f_function) : method_exists ($f_class,$f_function))/*#ifdef(DEBUG):,true):#*/; }
	else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_function_check ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
}

/**
* Initiate a specified class.
*
* @param  string $f_class Class to initialize
* @param  boolean $f_force_reinit Delete the current instance and reinitiate it
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.01
*/
function direct_class_init ($f_class,$f_force_reinit = false)
{
	global $direct_globals;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_class_init ($f_class,+f_force_reinit)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (isset ($direct_globals[$f_class]))
	{
		if ((!$f_force_reinit)&&(get_class ($direct_globals[$f_class]) == $direct_globals['@names'][$f_class])) { $f_return = true; }
		else { $direct_globals[$f_class] = NULL; }
	}

	if (!$f_return)
	{
		if (defined ("CLASS_".$direct_globals['@names'][$f_class]))
		{
			$direct_globals[$f_class] = new $direct_globals['@names'][$f_class] ();
			if (is_object ($direct_globals[$f_class])) { $f_return = true; }
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Handles debug information on various levels.
*
* @param  integer $f_debug_level Level from 1 (minimal) to 9 (verbose). 3 is
*         used for important function entry events, 5 for all ones and 7 for
*         function return value tracking (development versions only).
* @param  string $f_description Entry description
* @param  mixed $f_value Value to be added as debug result and as $f_return
* @param  boolean $f_value_parsing True to parse an output $f_value
* @uses   direct_debug_value()
* @uses   USE_debug_reporting
* @uses   USE_debug_reporting_level
* @uses   USE_debug_reporting_timing
* @return mixed Returns the given $f_value unchanged
* @since  v0.1.05
*/
function direct_debug ($f_debuglevel,$f_description,$f_value = "",$f_value_parsing = false)
{
	if (USE_debug_reporting)
	{
		global $direct_cachedata;

		if ($f_debuglevel <= USE_debug_reporting_level)
		{
			if (USE_debug_reporting_timing)
			{
				$f_debug_time = (/*#ifndef(PHP4) */microtime (true)/* #*//*#ifdef(PHP4):time ():#*/ - $direct_cachedata['core_debug_starttime']);
				$direct_cachedata['core_debug'][] = ($f_value_parsing ? ($f_description." returns: ".(direct_debug_value ($f_value)))." [{$f_debug_time}]" : $f_description." [{$f_debug_time}]");
			}
			else { $direct_cachedata['core_debug'][] = ($f_value_parsing ? ($f_description." returns: ".(direct_debug_value ($f_value))) : $f_description); }
		}
	}

	return $f_value;
}

/**
* Creates a string for all known value types.
*
* @param  mixed $f_value Value to be parsed as string
* @uses   direct_html_encode_special()
* @return string Output string
* @since  v0.1.05
*/
function direct_debug_value ($f_value)
{
	switch (gettype ($f_value))
	{
	case "array":
	{
		$f_return = "(array)\n".(serialize ($f_value));
		break 1;
	}
	case "boolean":
	{
		if ($f_value) { $f_return = "(boolean) true"; }
		else { $f_return = "(boolean) false"; }

		break 1;
	}
	case "double":
	{
		$f_return = "(double) ".$f_value;
		break 1;
	}
	case "float":
	{
		$f_return = "(float) ".$f_value;
		break 1;
	}
	case "integer":
	{
		$f_return = "(integer) ".$f_value;
		break 1;
	}
	case "NULL":
	{
		$f_return = "(NULL)";
		break 1;
	}
	case "object":
	{
		$f_return = "(object) ".(serialize ($f_value));
		break 1;
	}
	case "resource":
	{
		$f_return = "(resource) ".(serialize ($f_value));
		break 1;
	}
	case "string":
	{
		$f_return = "(string) \"".(direct_html_encode_special ($f_value))."\"";
		break 1;
	}
	default: { $f_return = "(unknown: ".(gettype ($f_value)).") ".(serialize ($f_value)); }
	}

	return $f_return;
}

/**
* Runs htmlspecialchars with or without a specified system charset.
*
* @param  string $f_data Input string
* @uses   direct_debug()
* @uses   USE_charset_html_filtering
* @uses   USE_debug_reporting
* @uses   USE_html_charset
* @return string Converted output string
* @since  v0.1.03
*/
function direct_html_encode_special ($f_data)
{
	global $direct_local,$direct_settings;

	if ((!isset ($direct_settings['swg_force_local_handling']))||($direct_settings['swg_force_local_handling'] != "text"))/*#ifndef(PHP4) */
	{
		if ((USE_charset_html_filtering)&&(isset ($direct_local['lang_charset']))) { return htmlspecialchars ($f_data,ENT_COMPAT,$direct_local['lang_charset']); }
		elseif (USE_html_charset) { return htmlspecialchars ($f_data,ENT_COMPAT,USE_html_charset); }
		else /* #*/ { return htmlspecialchars ($f_data); }
/*#ifndef(PHP4) */
	} /* #\n*/
}

/**
* If the theme is not compatible with XHTML, we need to convert the
* <script>-content of sWG provided JavaScript functions.
*
* @param string &$f_data Reference to the output content
* @param string $f_content_type Content type for $f_data
* @uses  direct_debug()
* @uses  USE_debug_reporting
* @since v0.1.05
*/
function direct_outputenc_xhtml_cleanup (&$f_data,$f_content_type = NULL)
{
	global $direct_local,$direct_settings;
	if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -direct_outputenc_xhtml_cleanup (+f_data,+f_content_type)- (#echo(__LINE__)#)"); }

	if ((!isset ($f_content_type))&&(isset ($direct_settings['theme_xhtml_type']))) { $f_content_type = $direct_settings['theme_xhtml_type']; }
	$f_html_content_type = (isset ($f_content_type) ? str_replace ("application/xhtml+xml","text/html",$f_content_type) : "text/html; charset=".$direct_local['lang_charset']);
	$f_data = preg_replace (array ("#\s*<\?(.*?)\?>(.*?)<#s","#\s*\/\s*>#s","#</head>#i","#<(script|style)(.*?)><\!\[CDATA\[(.*?)\]\]><\/(script|style)>#si"),(array ("<",">","<meta http-equiv='Content-Type' content=\"$f_html_content_type\">\n</head>","<\\1\\2><!--\\3// --></\\4>")),$f_data);
}

//j// Script specific commands

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
	$direct_globals['output']->output_send ($direct_settings['product_lcode_htmltitle']);

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
	if ((isset ($direct_globals['kernel']))&&(direct_class_function_check ($direct_globals['kernel'],"service_init"))) { $g_service_error = $direct_globals['kernel']->service_init (); }
	else { direct_class_init ("basic_functions"); }

	direct_class_init ("output");

/*#ifndef(PHP4) */
	if (empty ($g_service_error))
	{
		if (isset ($g_error)) { $g_error = array ("core_unknown_error","FATAL ERROR:<br />Unknown exception catched: ".$g_error,"The WebGine has catched an unknown error.<br /><br />Unknown exception catched: ".$g_error,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
		else { $g_error = array ("core_unsupported_command","FATAL ERROR: Request terminated","The WebGine has been accessed using an unknown command.<br /><br />Request terminated","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }
	}
	else { $g_error = $g_service_error; }

	try/* #\n*/
/*#ifdef(PHP4):
	$g_error = (isset ($g_service_error) ? $g_service_error : array ("core_unsupported_command","FATAL ERROR: Request terminated","The WebGine has been accessed using an unknown command.<br /><br />Request terminated","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"));
:#*/
	{
		if (direct_class_function_check ($direct_globals['output'],"output_send_error"))
		{
			$direct_globals['output']->output_header ("HTTP/1.1","HTTP/1.1 500 Internal Server Error",true);

			if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->output_send_error ("fatal",$g_error[0],$g_error[1],$g_error[3]); }
			else { $direct_globals['output']->output_send_error ("fatal",$g_error[2],$g_error[1],$g_error[3]); }
		}
		else
		{
			header ("HTTP/1.1 500 Internal Server Error");
			echo ($g_error[2]);
		}
	}
/*#ifndef(PHP4) */
	catch (Exception $g_unhandled_exception) { }
/* #*//*#ifdef(PHP4):

	exit ();
:#\n*/
}

//j// EOF
?>