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
* Output handlers parse and convert data in a protocol specific manner.
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
* @subpackage output
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

$g_continue_check = ((defined ("CLASS_direct_oxhtml")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_output"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ohandler.php",1) ? defined ("CLASS_direct_output") : false); }

if ($g_continue_check)
{
//c// direct_oxhtml
/**
* "direct_oxhtml" is responsible for formatting content and displaying
* it.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage output
* @uses       CLASS_direct_output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_oxhtml extends direct_output
{
/**
	* @var string $theme Selected output theme
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $theme;
/**
	* @var string $theme_subtype Output theme subtype
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $theme_subtype;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_oxhtml->__construct () and direct_oxhtml->direct_oxhtml ()
/**
	* Constructor (PHP5) __construct (direct_oxhtml)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->__construct (direct_oxhtml)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['theme_subtype'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		if (!isset ($direct_settings['p3p_cp'])) { $direct_settings['p3p_cp'] = ""; }
		if (!isset ($direct_settings['p3p_url'])) { $direct_settings['p3p_url'] = ""; }
		$f_mobile_check = isset ($_SERVER['HTTP_X_WAP_PROFILE']);
		$this->theme = NULL;

		if (strlen ($direct_settings['theme']))
		{
			if (($f_mobile_check)&&($direct_globals['basic_functions']->include_file ($direct_settings['path_themes']."/{$direct_settings['theme']}_mobile/swg_theme.php",2))) { $this->theme = $direct_settings['theme']."_mobile"; }
			elseif ($direct_globals['basic_functions']->include_file ($direct_settings['path_themes']."/{$direct_settings['theme']}/swg_theme.php",2)) { $this->theme = $direct_settings['theme']; }
		}

		if (!isset ($this->theme))
		{
			if (($f_mobile_check)&&($direct_globals['basic_functions']->include_file ($direct_settings['path_themes']."/{$direct_settings['swg_theme']}_mobile/swg_theme.php",2))) { $this->theme = $direct_settings['swg_theme']."_mobile"; }
			else
			{
				$direct_globals['basic_functions']->include_file ($direct_settings['path_themes']."/{$direct_settings['swg_theme']}/swg_theme.php",2);
				$this->theme = $direct_settings['swg_theme'];
			}
		}

		$direct_globals['basic_functions']->settings_get ($direct_settings['path_themes']."/{$this->theme}/swg_theme_up.xml");
		$direct_settings['theme'] = $this->theme;

		$this->oset = (isset ($direct_settings['theme_oset']) ? $direct_settings['theme_oset'] : $direct_settings['swg_theme_oset']);
		$this->theme_subtype = "";
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_oxhtml (direct_oxhtml)
	*
	* @since v0.1.01
*\/
	function direct_oxhtml () { $this->__construct (); }
:#*/
	//f// direct_oxhtml->backtrace_get ($f_data = NULL,$f_handling = "text")
/**
	* Parse a given backtrace array (or try to load one via "debug_backtrace").
	*
	* @param  array $f_data Already extracted backtrace as array
	* @param  string $f_handling Return the string formatted as "text" or "html"
	* @uses   direct_debug()
	* @uses   direct_basic_functions::backtrace_get()
	* @uses   USE_debug_reporting
	* @return string Formatted backtrace string
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */protected /* #*/function backtrace_get ($f_data = NULL,$f_handling = "text")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->backtrace_get (+f_data,$f_handling)- (#echo(__LINE__)#)"); }

		$f_return = parent::backtrace_get ($f_data);
		if ($f_handling == "html") { $f_return = str_replace ("\n","<br />\n",$f_return); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->backtrace_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_oxhtml->options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode = "asis")
/**
	* Adds an item to a specified menu container
	*
	* @param  integer $f_level Number from 0 (highest) to 9
	* @param  string $f_menu Name of the menu container
	* @param  string $f_url URL for the menu item
	* @param  string $f_title Title for the link
	* @param  string $f_image An image for the item (leave empty for none)
	* @param  string $f_urlmode URL mode ("asis", "url0", "url1")
	* @uses   direct_debug()
	* @uses   direct_linker_dynamic()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode = "asis")
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -output_class->options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode)- (#echo(__LINE__)#)"); }

		$f_image = ((($f_image)&&($direct_settings['swg_options_image'])) ? direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/".$f_image,true,false) : "");
		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -output_class->options_insert ()- (#echo(__LINE__)#)",(:#*/parent::options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode)/*#ifdef(DEBUG):),true):#*/;
	}

	//f// direct_oxhtml->options_generator ($f_type,$f_menu,$f_seperator = "")
/**
	* Creates XHTML 1.0 code for the given menu using the specified type
	*
	* @param  string $f_type Different menutypes (horizontal / vertical; with or
	*         without a notice for no items) are available
	* @param  string $f_menu Name of the menu container
	* @param  string $f_seperator An optional seperator between each item
	* @uses   direct_debug()
	* @uses   direct_local_get()
	* @uses   USE_debug_reporting
	* @return string The resulting XHTML code
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function options_generator ($f_type,$f_menu,$f_seperator = "")
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->options_generator ($f_type,$f_menu)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (isset ($this->menus[$f_menu]))
		{
			ksort ($this->menus[$f_menu]);

			foreach ($this->menus[$f_menu] as $f_menu_array)
			{
				foreach ($f_menu_array as $f_menu_item_array)
				{
					$f_menu_item_array['url'] = str_replace ('"',"",$f_menu_item_array['url']);
					if (($direct_settings['swg_options_image'])&&($f_menu_item_array['image'])) { $f_menu_item_array['image'] = "<img src='{$f_menu_item_array['image']}' alt='' title='' style='vertical-align:middle' />"; }

					if (($f_type == "v")||($f_type == "ve"))
					{
						if ($f_menu_item_array['title'])
						{
							if ($f_return) { $f_return .= ($f_seperator ? $f_seperator : "<span class='pagehide'><br /></span>\n"); }
							$f_return .= $f_menu_item_array['image']."<a href=\"{$f_menu_item_array['url']}\">".$f_menu_item_array['title']."</a>";
						}
						else
						{
							if ($f_return) { $f_return .= ($f_seperator ? $f_seperator : "<br />\n"); }
							$f_return .= "<a href=\"{$f_menu_item_array['url']}\">{$f_menu_item_array['image']}</a>";
						}
					}
					else
					{
						if ($f_menu_item_array['title'])
						{
							if ($f_return) { $f_return .= ($f_seperator ? $f_seperator : ", "); }
							$f_return .= $f_menu_item_array['image']."<a href=\"{$f_menu_item_array['url']}\">".$f_menu_item_array['title']."</a>";
						}
						else
						{
							if ($f_return) { $f_return .= ($f_seperator ? $f_seperator : " "); }
							$f_return .= "<a href=\"{$f_menu_item_array['url']}\">{$f_menu_item_array['image']}</a>";
						}
					}
				}
			}
		}
		elseif ($f_type == "v") { $f_return = direct_local_get ("core_menu_empty"); }
		elseif ($f_type == "h") { $f_return = direct_local_get ("core_menu_empty"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->options_generator ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_oxhtml->output_response ($f_title = "",$f_headers = NULL)
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
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function output_response ($f_title = "",$f_headers = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_response (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		if (!$direct_settings['swg_force_notheme'])
		{
			$this->output_additional_copyright = "";

			if (($direct_cachedata['core_time'] + $direct_settings['timeout_lightmode']) < (time ()))
			{
				$f_subtype = ($this->theme_subtype ? $this->theme_subtype."_light" : "light");
				$this->theme_subtype ($f_subtype);
			}
/* -------------------------------------------------------------------------
Parse additional copyright information for output.
------------------------------------------------------------------------- */

			elseif ((isset ($direct_settings['additional_copyright']))&&(is_array ($direct_settings['additional_copyright']))&&(!empty ($direct_settings['additional_copyright'])))
			{
				foreach ($direct_settings['additional_copyright'] as $f_copyright_array)
				{
					if ($this->output_additional_copyright) { $this->output_additional_copyright .= "<br />\n"; }

					if (count ($f_copyright_array) == 2) { $this->output_additional_copyright .= "<a href='{$f_copyright_array[0]}' target='_blank'>{$f_copyright_array[1]}</a>"; }
					elseif (count ($f_copyright_array) > 2) { $this->output_additional_copyright .= ($f_copyright_array[0]."<a href='{$f_copyright_array[1]}' target='_blank'>{$f_copyright_array[2]}</a>".$f_copyright_array[3]); }
				}
			}
		}

		parent::output_response ($f_title,$f_headers);
	}

	//f// direct_oxhtml->output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
/**
	* There are 4 different types of errors. The behavior of
	* "output_send_error ()" ranges from a simple error message (continuing
	* with script) up to critical or fatal error messages (with the current
	* theme) and interrupting the process.
	*
	* @param string $f_type Defines the error type that needs to be managed.
    *        The following types are defined: "critical", "fatal", "login" or
    *        "standard". The default error type is "fatal".
	* @param string $f_error A key for localisation strings or an error message
	* @param string $f_extra_data More detailed information to track down the
	*        problem
	* @param string $f_error_position Position where the error occurred
	* @uses  direct_basic_functions::require_file()
	* @uses  direct_basic_functions_inline::emergency_mode()
	* @uses  direct_class_function_check()
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_error_functions::backtrace_get()
	* @uses  direct_kernel_system::service_init()
	* @uses  direct_kernel_system::v_usertype_get_int()
	* @uses  direct_linker()
	* @uses  direct_local_get()
	* @uses  direct_output::options_flush()
	* @uses  direct_output::oset()
	* @uses  direct_output_inline::header()
	* @uses  direct_output_inline::output_send()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function output_send_error ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->output_send_error ($f_type,$f_error,+f_extra_data,$f_error_position)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;

		if (!function_exists ("direct_linker")) { $direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_linker.php"); }

		if ((isset ($direct_globals['kernel']))&&(direct_class_function_check ($direct_globals['kernel'],"service_init")))
		{
			$f_service_error = $direct_globals['kernel']->service_init ();

			if (!empty ($f_service_error))
			{
				$f_error = $f_service_error[0];
				$f_extra_data = $f_service_error[1];
			}
		}
		else { direct_class_init ("basic_functions"); }

		$this->related_manager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"pre_module_service_action");

		if (isset ($direct_cachedata['output_error_extradata'])) { $f_continue_check = false; }
		else
		{
			$direct_cachedata['output_error'] = (((!preg_match ("#\W+#i",$f_error))&&(function_exists ("direct_local_get"))) ? direct_local_get ("errors_".$f_error) : $f_error);

			if (strlen ($f_extra_data))
			{
				$direct_cachedata['output_error_extradata'] = preg_replace ("#(\/|\&amp;|\&|\?|,)(?!\>|(\w{2,4};))#"," \\1 \\2",$f_extra_data);
				if ((USE_debug_reporting)&&($f_error_position)) { $direct_cachedata['output_error_extradata'] .= "<br />\n".$f_error_position; }
			}
			elseif ((USE_debug_reporting)&&($f_error_position)) { $direct_cachedata['output_error_extradata'] = $f_error_position; }
			else { $direct_cachedata['output_error_extradata'] = ""; }
		}

		if (($f_continue_check)&&(function_exists ("direct_linker")))
		{
			if (!isset ($direct_cachedata['page_this'])) { $direct_cachedata['page_this'] = ""; }
			$direct_cachedata['output_link_back'] = (((isset ($direct_cachedata['page_backlink']))&&($direct_cachedata['page_backlink'])&&($direct_cachedata['page_this'] != $direct_cachedata['page_backlink'])) ? direct_linker ("url0",$direct_cachedata['page_backlink']) : "");
			$direct_cachedata['output_link_retry'] = ($direct_cachedata['page_this'] ? direct_linker ("url0",$direct_cachedata['page_this']) : "");

			if ($f_type == "fatal") { $f_continue_check = $this->oset ("default".$this->theme_subtype,"error_fatal"); }
			elseif ($f_type == "critical") { $f_continue_check = $this->oset ("default".$this->theme_subtype,"error_critical"); }
			elseif (($f_type == "login")&&(direct_class_function_check ($direct_globals['kernel'],"v_usertype_get_int")))
			{
				if ($direct_globals['kernel']->v_usertype_get_int ($direct_settings['user']['type'])) { $direct_cachedata['output_current_user'] = $direct_settings['user']['name_html']; }
				else { $direct_cachedata['output_current_user'] = direct_local_get ("core_guest"); }

				if ($direct_cachedata['page_this']) { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_this'])))); }
				elseif ($direct_cachedata['page_backlink']) { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account;s=status;a=login;dsd=source+".(urlencode (base64_encode ($direct_cachedata['page_backlink'])))); }
				else { $direct_cachedata['output_link_login'] = direct_linker ("url0","m=account;s=status;a=login"); }

				$f_continue_check = $this->oset ("default".$this->theme_subtype,"error_login");
			}
			else { $f_continue_check = $this->oset ("default".$this->theme_subtype,"error_standard"); }
		}
		else { $f_continue_check = false; }

		$this->related_manager ("error_".(preg_replace ("#\W+#","",$f_type))."_".(preg_replace ("#\W+#","",$f_error)),"post_module_service_action");
		if ((USE_backtrace)||($f_type == "fatal")) { $direct_cachedata['core_debug_backtrace'] = $direct_globals['basic_functions']->backtrace_get (); }

		if ($f_continue_check)
		{
			$this->options_flush ();
			$this->header (false,true,@$direct_settings['p3p_url'],@$direct_settings['p3p_cp']);
			$this->output_send (direct_local_get ("core_error"));
		}
		else { parent::output_send_error ("fatal",$f_error,$f_extra_data."<br /><br />Request terminated",$f_error_position); }

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new RuntimeException ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}

	//f// direct_oxhtml->redirect ($f_url,$f_use_current_url = false)
/**
	* We need some header outputs for redirecting, that's why there exists this
	* function
	*
	* @param  string $f_url The target URL
	* @param  boolean $f_use_current_url True for allowing the redirect to be
	*         cached
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function redirect ($f_url,$f_use_current_url = false)
	{
		global $direct_cachedata;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->redirect ($f_url,+f_use_current_url)- (#echo(__LINE__)#)"); }

		$direct_cachedata['output_pagetarget'] = direct_html_encode_special ($f_url);
		$direct_cachedata['output_redirect'] = (function_exists ("direct_linker") ? direct_linker ("optical",$direct_cachedata['output_pagetarget']) : $direct_cachedata['output_pagetarget']);

		$this->oset ("default","redirect");
		$this->header ($f_use_current_url);
		$this->options_flush (true);
		$this->output_header ("HTTP/1.1","HTTP/1.1 302 Found",true);
		$this->output_header ("Location",$f_url);
		$this->theme_page (direct_local_get ("core_redirect"));
		$this->output_send ();

		$direct_cachedata['core_service_activated'] = true;
	}

	//f// direct_oxhtml->theme_subtype ($f_subtype)
/**
	* Define and try to load a theme subtype
	*
	* @param  string $f_subtype Requested theme subtype
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function theme_subtype ($f_subtype)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->theme_subtype ($f_subtype)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_subtype = preg_replace ("#[\/\\\?:@\=\&\. \+]#i","",$f_subtype);

		if (!$direct_settings['swg_force_notheme'])
		{
			$f_return = $direct_globals['basic_functions']->include_file ($direct_settings['path_themes']."/$direct_settings[theme]/swg_theme_$f_subtype.php",2);

			if (!$f_return)
			{
				if (isset ($direct_settings["swg_theme_supported_subtypes_".$f_subtype])) { $f_return = $direct_globals['basic_functions']->include_file (($direct_globals['basic_functions']->varfilter ($direct_settings["swg_theme_supported_subtypes_".$f_subtype],"settings")),2); }
				elseif ((isset ($direct_settings['swg_theme_supported_subtypes']))&&(isset ($direct_settings['swg_theme_supported_subtypes'][$f_subtype]))) { $f_return = $direct_globals['basic_functions']->include_file (($direct_globals['basic_functions']->varfilter ($direct_settings['swg_theme_supported_subtypes'][$f_subtype],"settings")),2); }
			}

			if ($f_return) { $this->theme_subtype = "_".$f_subtype; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->theme_subtype ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['output'] = "direct_oxhtml";
define ("CLASS_direct_oxhtml",true);

//j// Script specific commands

if (!isset ($direct_settings['swg_force_notheme'])) { $direct_settings['swg_force_notheme'] = false; }
if (!isset ($direct_settings['swg_theme_supported_subtypes'])) { $direct_settings['swg_theme_supported_subtypes'] = array (); }
if (!isset ($direct_settings['theme_lightmode_supported'])) { $direct_settings['theme_lightmode_supported'] = false; }
}

//j// EOF
?>