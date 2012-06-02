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
* This file contains some inline functions required for further processing of
* an sWG request.
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
* @subpackage basic_functions
* @since      v0.1.10
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/**
* PHP's "PSR-0" compliant autoload function will be used to load additional,
* missing classes.
*
* @param string $f_class Requested but missing class name
* @since v0.1.10
*/
function direct_autoload ($f_class,$f_extension = "php")
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_autoload ($f_class)- (#echo(__LINE__)#)"); }

	$f_return = NULL;

	if ((isset ($direct_settings['swg_classes_predefined']))&&(in_array ($f_class,$direct_settings['swg_classes_predefined'])))
	{
		$f_file_pathname = $direct_settings['path_system']."/classes/".$direct_settings['swg_classes_predefined'][$f_class];
		if (file_exists ($f_file_pathname)) { $f_return = $f_class; }
	}
/*#ifndef(PHP5n):
	elseif (in_array ($f_class,$direct_cachedata['@names']))
	{
		$f_file_pathname = $direct_cachedata['@names'][$f_class];
		if (file_exists ($f_file_pathname)) { $f_return = $f_class; }
	}
:#\n*/
	else
	{
		$f_class_array = direct_class_pathname ($f_class);

		if (is_array ($f_class_array))
		{
			$f_file_pathname = $f_class_array[0];
			$f_return = $f_class;
		}
	}

/* -------------------------------------------------------------------------
Search for the requested class ...
------------------------------------------------------------------------- */

	if (($f_return !== NULL)&&(!class_exists ($f_class)))
	{
		/*#ifndef(PHP4) */include_once/* #*//*#ifdef(PHP4):require_once:#*/ ($f_file_pathname);
		if (!class_exists ($f_class)) { $f_return = NULL; }
	}
/*#ifndef(PHP4) */

	if ($f_return === NULL) { throw new /*#ifdef(PHP5n) */\RuntimeException/* #*//*#ifndef(PHP5n):RuntimeException:#*/ ("&quot;$f_class&quot; not found"); }
/* #*/
	return $f_return;
}

/**
* Check for a specific function of a specific class.
*
* @param  object $f_class Object where the function should exist
* @param  string $f_function Name of the function
* @return boolean True if the function exists
* @since  v0.1.01
*/
function direct_class_function_check (&$f_class,$f_function)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_class_function_check (+f_class,$f_function)- (#echo(__LINE__)#)"); }

	if ((is_object ($f_class))&&($f_class != NULL)) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_function_check ()- (#echo(__LINE__)#)",:#*/(is_subclass_of ($f_class,/*#ifdef(PHP5n) */"dNG\sWG\directVirtualClass"/* #*//*#ifndef(PHP5n):"directVirtualClass":#*/) ? $f_class->vCallCheck ($f_function) : method_exists ($f_class,$f_function))/*#ifdef(DEBUG):,true):#*/; }
	else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_function_check ()- (#echo(__LINE__)#)",:#*/false/*#ifdef(DEBUG):,true):#*/; }
}

/**
* Initiate a specified class.
*
* @param  string $f_class Class to initialize
* @param  boolean $f_force_reinit Delete the current instance and reinitiate it
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

	if ((!$f_return)&&(isset ($direct_globals['@names'][$f_class])))
	{
		$f_classname = ((strpos ($direct_globals['@names'][$f_class],"\\") !== false) ? substr ($direct_globals['@names'][$f_class],(strrpos ($direct_globals['@names'][$f_class],"\\") + 1)) : $direct_globals['@names'][$f_class]);

		if (defined ("CLASS_".$f_classname))
		{
			$direct_globals[$f_class] = new /*#ifdef(PHP5n) */$direct_globals['@names'][$f_class]/* #*//*#ifndef(PHP5n):$f_classname:#*/ ();
			if (is_object ($direct_globals[$f_class])) { $f_return = true; }
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Return the file path and name for a specified class.
*
* @param  string $f_class Class to initialize
* @param  boolean $f_force_reinit Delete the current instance and reinitiate it
* @return mixed Array containing the path and name on success; false if not
*         found
* @since  v0.1.01
*/
function direct_class_pathname ($f_class,$f_extension = "php")
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_class_pathname ($f_class,$f_extension)- (#echo(__LINE__)#)"); }

	$f_return = false;

/* -------------------------------------------------------------------------
PSR-0 rules
------------------------------------------------------------------------- */

	$f_class_array = explode ("\\",$f_class);
	$f_file_pathname = NULL;

	if ((count ($f_class_array))&&(strlen ($f_class_array[0])))
	{
		$f_classname = array_pop ($f_class_array);
		$f_file_pathname = (empty ($f_class_array) ? "" : (implode ("/",$f_class_array)."/"));

		if (strpos ($f_classname,"_") === false) { $f_file_pathname .= $f_classname; }
		else
		{
			$f_class_array = explode ("_",$f_classname);

			if ((count ($f_class_array))&&(strlen ($f_class_array[0])))
			{
				$f_classname = array_pop ($f_class_array);
				$f_file_pathname .= implode ("/",$f_class_array);
			}
			else { $f_file_pathname = NULL; }
		}
	}

	if (isset ($f_file_pathname))
	{
		$f_file_pathname = ($f_extension ? $direct_settings['path_system']."/classes/".$f_file_pathname.".".$f_extension : $direct_settings['path_system']."/classes/".$f_file_pathname);
		$f_memcache_check = false;

		if (isset ($direct_globals['basic_functions']))
		{
			$f_memcache_pathname = $direct_globals['basic_functions']->memcacheGetFilePathName ($f_file_pathname,1);

			if (isset ($f_memcache_pathname))
			{
				$f_file_pathname = $f_memcache_pathname;
				$f_memcache_check = true;
			}
		}

		if (($f_memcache_check)||(file_exists ($f_file_pathname))) { $f_return = array ($f_file_pathname,$f_classname); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_class_pathname ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
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
/*#ifndef(PHP5n):

/**
* PHP's "PSR-0" compliant cache to add PHP <5.3 as compatible version.
*
* @param string $f_class Requested but missing class name
* @since v0.1.10
*\/
function direct_use ($f_class,$f_extension = "php")
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_use ($f_class)- (#echo(__LINE__)#)"); }

/*#ifndef(PHP4) *\/
	if ((!isset ($direct_settings['swg_classes_predefined']))||(!in_array ($f_class,$direct_settings['swg_classes_predefined'])))
	{
		$f_class_array = direct_class_pathname ($f_class);
		if (is_array ($f_class_array)) { $direct_cachedata['@names'][$f_class_array[1]] = $f_class_array[0]; }
	}
/* #*\//*#ifdef(PHP4):
	direct_autoload ($f_class,$f_extension);
:#\n*\/
}
:#*/
/**
* Runs htmlspecialchars with or without a specified system charset.
*
* @param  string $f_data Input string
* @return string Converted output string
* @since  v0.1.03
*/
function direct_html_encode_special ($f_data)
{
	global $direct_local,$direct_settings;

	if ((!isset ($direct_settings['swg_force_local_handling']))||($direct_settings['swg_force_local_handling'] != "text"))
/*#ifndef(PHP4) */
	{
		if ((USE_charset_html_filtering)&&(isset ($direct_local['lang_charset']))) { return htmlspecialchars ($f_data,ENT_COMPAT,$direct_local['lang_charset']); }
		elseif (USE_html_charset) { return htmlspecialchars ($f_data,ENT_COMPAT,USE_html_charset); }
		else/* #*/ { return htmlspecialchars ($f_data); }
/*#ifndef(PHP4) */
	}
/* #\n*/
}

/**
* If the theme is not compatible with XHTML, we need to convert the
* <script>-content of sWG provided JavaScript functions.
*
* @param string &$f_data Reference to the output content
* @param string $f_content_type Content type for $f_data
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

//j// EOF
?>