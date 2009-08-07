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
* This file contains common error message handlers.
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage error_functions
* @uses       direct_product_iversion
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_error_functions"))
{
//c// direct_error_functions
/**
* "direct_error_functions" manages errors.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage error_functions
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_error_functions extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_error_functions->__construct () and direct_error_functions->direct_error_functions ()
/**
	* Constructor (PHP5) __construct (direct_error_functions)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -error_functions_class->__construct (direct_error_functions)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['backtrace_get'] = true;
		$this->functions['backtrace_get_text'] = true;
		$this->functions['error_page'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_error_functions (direct_error_functions)
	*
	* @since v0.1.01
*\/
	function direct_error_functions () { $this->__construct (); }
:#\n*/
	//f// direct_error_functions->__destruct ()
/**
	* Destructor (PHP5) __destruct (direct_error_functions)
	*
	* @since v0.1.09
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { restore_error_handler (); }

	//f// direct_error_functions->backtrace_get ($f_data = "")
/**
	* Parse a given backtrace array (or try to load one via "debug_backtrace").
	*
	* @param  mixed $f_data Already extracted backtrace as array (otherwise use
	*         current one)
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */protected /* #*/function backtrace_get ($f_data = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -error_functions_class->backtrace_get (+f_data)- (#echo(__LINE__)#)"); }

		$f_return = array ();

		if (is_array ($f_data)) { $f_backtrace_array = $f_data; }
		elseif (function_exists ("debug_backtrace")) { $f_backtrace_array = debug_backtrace (); }

		if (isset ($f_backtrace_array))
		{
			foreach ($f_backtrace_array as $f_backtrace_entry_array)
			{
				$f_backtrace_line = "";

				if (isset ($f_backtrace_entry_array['file'])) { $f_backtrace_line .= $f_backtrace_entry_array['file'].": "; }
				if (isset ($f_backtrace_entry_array['class'])) { $f_backtrace_line .= $f_backtrace_entry_array['class']."->"; }
				if (isset ($f_backtrace_entry_array['function'])) { $f_backtrace_line .= $f_backtrace_entry_array['function']." "; }
				if (isset ($f_backtrace_entry_array['line'])) { $f_backtrace_line .= "({$f_backtrace_entry_array['line']}) "; }

				$f_return[] = $f_backtrace_line;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -error_functions_class->backtrace_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_error_functions->backtrace_get_text ($f_data = "",$f_handling = "text")
/**
	* This operation prints $this->dvar to the browser (and exists) or to
	* $direct_cachedata['core_debug'].
	*
	* @param  mixed $f_data Already extracted backtrace as array (otherwise use
	*         current one)
	* @param  boolean $f_handling Return the string as "text" or "html" formatted
	*         string
	* @uses   direct_debug()
	* @uses   direct_error_functions::backtrace_get()
	* @uses   USE_debug_reporting
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */protected /* #*/function backtrace_get_text ($f_data = "",$f_handling = "text")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -error_functions_class->backtrace_get_text (+f_data,$f_handling)- (#echo(__LINE__)#)"); }

		$f_backtrace_array = $this->backtrace_get ($f_data);

		if (empty ($f_backtrace_array)) { $f_return = ""; }
		else { $f_return = ($f_handling == "html" ? implode ("<br />\n",$f_backtrace_array) : implode ("\n",$f_backtrace_array)); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -error_functions_class->backtrace_get_text ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_error_functions->error_page ($f_type,$f_error,$f_extra_data = "")
/**
	* There are 4 different types of errors. The behavior of error_page
	* ranges from a simple error message (continuing with script) up to a call
	* to emergency_mode or displaying an critical or fatal error message
	* (with the current theme) and interrupting the process.
	*
	* @param  string $f_type Defines the error type that needs to be managed.
    *         The following types are defined: "critical", "fatal", "login" or
    *         "standard". The default error type is "fatal".
	* @param  string $f_error A key for localisation strings or an error message
	* @param  string $f_extra_data More detailed information to track down the problem
	* @uses   direct_basic_functions::require_file()
	* @uses   direct_basic_functions_inline::emergency_mode()
	* @uses   direct_class_function_check()
	* @uses   direct_class_init()
	* @uses   direct_debug()
	* @uses   direct_error_functions::backtrace_get()
	* @uses   direct_kernel_system::service_init()
	* @uses   direct_kernel_system::v_usertype_get_int()
	* @uses   direct_linker()
	* @uses   direct_local_get()
	* @uses   direct_output_inline::header()
	* @uses   direct_output_inline::page_show()
	* @uses   direct_output_control::options_flush()
	* @uses   direct_output_control::oset()
	* @uses   direct_output_related_manager()
	* @uses   USE_debug_reporting
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function error_page ($f_type,$f_error,$f_extra_data = "")
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -error_functions_class->error_page ($f_type,$f_error,+f_extra_data)- (#echo(__LINE__)#)"); }

		$f_return = true;

		if (direct_class_function_check ($direct_classes['kernel'],"service_init")) { $direct_classes['kernel']->service_init (); }
		else { direct_class_init ("basic_functions"); }

		if (function_exists ("direct_output_related_manager")) { direct_output_related_manager ("error_".(preg_replace ("#\W#","",$f_type))."_".(preg_replace ("#\W#","",$f_error)),"pre_module_service_action"); }

		if (!isset ($direct_classes['output']))
		{
			$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_output.php",1);
			direct_class_init ("output");
		}

		if ((!$direct_settings['swg_force_notheme'])&&(!isset ($direct_classes['output_theme'])))
		{
			if (defined ("CLASS_direct_output_control")) { direct_output_theme ($direct_settings['theme']); }
			direct_class_init ("output_theme");
		}

		if (!function_exists ("direct_linker")) { $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_linker.php"); }

		$direct_cachedata['output_error'] = (((!preg_match ("#\W#i",$f_error))&&(function_exists ("direct_local_get"))) ? direct_local_get ("errors_".$f_error) : $f_error);
		$direct_cachedata['output_error_extradata'] = ($f_extra_data ? preg_replace ("#(\/|\&amp;|\&|\?|,)(?!\>|(\w{2,4};))#"," \\1 \\2",$f_extra_data) : "");

		if ((direct_class_function_check ($direct_classes['output'],"oset"))&&(direct_class_function_check ($direct_classes['output_theme'],"theme_page"))&&(function_exists ("direct_linker")))
		{
			$direct_cachedata['output_link_back'] = (((@$direct_cachedata['page_backlink'])&&($direct_cachedata['page_this'] != $direct_cachedata['page_backlink'])) ? direct_linker ("url0",$direct_cachedata['page_backlink']) : "");
			$direct_cachedata['output_link_retry'] = (@$direct_cachedata['page_this'] ? direct_linker ("url0",$direct_cachedata['page_this']) : "");

			$f_subtype = "";

			if (@$direct_settings['theme_subtype'])
			{
				if (file_exists ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swg_default_$direct_settings[theme_subtype].php")) { $f_subtype = "_".$direct_settings['theme_subtype']; }
			}

			if ($f_type == "fatal") { $f_return = $direct_classes['output']->oset ("default".$f_subtype,"error_fatal"); }
			elseif ($f_type == "critical") { $f_return = $direct_classes['output']->oset ("default".$f_subtype,"error_critical"); }
			elseif (($f_type == "login")&&(direct_class_function_check ($direct_classes['kernel'],"v_usertype_get_int")))
			{
				if ($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $direct_cachedata['output_current_user'] = $direct_settings['user']['name_html']; }
				else { $direct_cachedata['output_current_user'] = direct_local_get ("core_guest"); }

				if (@$direct_cachedata['page_this']) { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account&s=status&a=login&dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_this'])))); }
				elseif (@$direct_cachedata['page_backlink']) { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account&s=status&a=login&dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_backlink'])))); }
				else { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account&s=status&a=login"); }

				$f_return = $direct_classes['output']->oset ("default".$f_subtype,"error_login");
			}
			else { $f_return = $direct_classes['output']->oset ("default".$f_subtype,"error_standard"); }
		}
		else { $f_return = false; }

		if (function_exists ("direct_output_related_manager")) { direct_output_related_manager ("error_".(preg_replace ("#\W#","",$f_type))."_".(preg_replace ("#\W#","",$f_error)),"post_module_service_action"); }
		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $this->backtrace_get (); }

		if ($f_return)
		{
			$direct_classes['output']->options_flush ();
			$direct_classes['output']->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show (direct_local_get ("core_error"));
		}
		else { $direct_classes['basic_functions']->emergency_mode ($direct_cachedata['output_error']."<br /><br />$f_extra_data<br /><br />Request terminated"); }

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new Exception ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}
}

//f// direct_error_functions_php_error ($f_level,$f_err_msg,$f_err_file = NULL,$f_err_no = NULL,$f_err_context = NULL)
/**
* Define a error handler for "trigger_error ()" and "E_USER_NOTICE",
* "E_USER_WARNING" as well as "E_USER_ERROR".
*
* @param  string $f_theme Requested theme
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean False on error
* @since  v0.1.09
*/
function direct_error_functions_php_error ($f_level,$f_err_msg,$f_err_file = NULL,$f_err_no = NULL,$f_err_context = NULL)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_error_functions_php_error (+f_level,$f_err_msg,+f_err_file,+f_err_no,+f_err_context)- (#echo(__LINE__)#)"); }

	switch ($f_level & (E_USER_NOTICE | E_USER_WARNING | E_USER_ERROR))
	{
	case (E_USER_NOTICE):
	{
		if (USE_debug_reporting_level > 8) { $direct_cachedata['core_error'][] = $f_err_msg; }
		break 1;
	}
	case (E_USER_WARNING):
	{
		if (USE_debug_reporting_level) { $direct_cachedata['core_error'][] = $f_err_msg; }
		break 1;
	}
	case (E_USER_ERROR):
	{
		$direct_cachedata['core_error'][] = $f_err_msg;
		break 1;
	}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['error_functions'] = "direct_error_functions";
define ("CLASS_direct_error_functions",true);

set_error_handler ("direct_error_functions_php_error"/*#ifndef(PHP4) */,(E_USER_NOTICE | E_USER_WARNING | E_USER_ERROR)/* #*/);
}

//j// EOF
?>