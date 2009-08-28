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
* There are several tools to create new output easily. Here you will find most
* of them (including methods from direct_output_inline).
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

$g_continue_check = ((defined ("CLASS_direct_output_control")) ? false : true);
if (!defined ("CLASS_direct_output_inline")) { $g_continue_check = false; }

if ($g_continue_check)
{
//c// direct_output_control
/**
* "direct_output_control" is responsible for formatting content and displaying
* it.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage output
* @uses       CLASS_direct_output_inline
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_output_control extends direct_output_inline
{
/**
	* @var integer $js_helper_element Counter for the JS helper
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $js_helper_element;
/**
	* @var array $menus Menus for the current page
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $menus;
/**
	* @var array $menus_protected Flush protected menus
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $menus_protected;
/**
	* @var string $output_additional_copyright Additional copyrights
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_additional_copyright;
/**
	* @var array $header_elements Cache for additional headers
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $header_elements;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_basic_functions->__construct () and direct_basic_functions->direct_basic_functions ()
/**
	* Constructor (PHP5) __construct (direct_output_control)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->__construct (direct_output_control)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['css_header'] = true;
		$this->functions['js_header'] = true;
		$this->functions['js_helper'] = true;
		$this->functions['header_elements'] = true;
		$this->functions['options_check'] = true;
		$this->functions['options_flush'] = true;
		$this->functions['options_flush_unprotect'] = true;
		$this->functions['options_insert'] = true;
		$this->functions['options_generator'] = true;
		$this->functions['oset'] = true;
		$this->functions['redirect'] = true;
		$this->functions['servicemenu'] = true;
		$this->functions['warning'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->js_helper_element = 0;
		$this->menus = array ();
		$this->menus_protected = array ();
		$this->output_additional_copyright = array ();
		$this->output_additional_header = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_output_control (direct_output_control)
	*
	* @since v0.1.01
*\/
	function direct_output_control () { $this->__construct (); }
:#*/
	//f// direct_output_control->css_header ()
/**
	* Adds standard CSS definitions to the list of output (X)HTML headers
	*
	* @uses   direct_debug()
	* @uses   direct_output_control::header_elements()
	* @uses   USE_debug_reporting
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function css_header ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->css_header ()- (#echo(__LINE__)#)"); }

		$this->header_elements ("<link rel='stylesheet' type='text/css' href='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+data/mmedia/swg_output_ajaxloading.css",true,false))."' />");
		$this->header_elements ("<link rel='stylesheet' type='text/css' href='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+data/mmedia/swg_output_helper.css",true,false))."' />");
	}

	//f// direct_output_control->js_header ()
/**
	* Adds a JavaScript section including all functions required by the sWG to the
	* list of output (X)HTML headers.
	*
	* @uses   direct_debug()
	* @uses   direct_output_control::header_elements()
	* @uses   USE_debug_reporting
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function js_header ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->js_header ()- (#echo(__LINE__)#)"); }

$this->header_elements ("<script language='JavaScript' type='text/javascript'><![CDATA[
var djs_swgDOM = false;
var djs_swgAJAX = false;
if (typeof (djs_var) == 'undefined') { var djs_var = new Array (); }
]]></script>");

		$this->header_elements ("<script language='JavaScript1.5' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_DOM.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // Document Object Model check and functions // --></script>");
		$this->header_elements ("<script language='JavaScript1.5' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_AJAX.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // Asynchronous JavaScript and XML // --></script>");
		$this->header_elements ("<script language='JavaScript' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_basic_functions.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // These are basic javascript functions // --></script>");
	}

	//f// direct_output_control->js_helper ($f_text,$f_url = "",$f_close_onload = true)
/**
	* Returns valid XHTML 1.0 code for a dynamic helper box (using JavaScript to
	* open / close it)
	*
	* @param  string $f_text Content string for the Helper Box
	* @param  string $f_url A optional link for the content of the box
	* @param  boolean $f_close_onload True to close the box after loading the page
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string XHTML Code for required JavaScript functions
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function js_helper ($f_text,$f_url = "",$f_close_onload = true)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->js_helper (+f_text,$f_url,$f_close_onload)- (#echo(__LINE__)#)"); }

		$f_js_helper_id = ("swghelp".$this->js_helper_element);
		$this->js_helper_element++;
		$f_js_helper_open = ($f_close_onload ? 0 : 1);
		if (strlen ($f_url)) { $f_text = "<a href=\"$f_url\" target='_blank'>$f_text</a>"; }

$f_return = ("<div class='pagehelperbg' style='position:relative;width:75%;text-align:center'><div class='pagehelpericon'><a href=\"javascript:djs_diblock_switch('$f_js_helper_id');\"><img src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_helper.png",true,false))."' width='32' height='32' alt=\"".(direct_local_get ("core_detailed_information"))."\" title=\"".(direct_local_get ("core_detailed_information"))."\" /></a></div><span class='pagehelpercontentlink'><a href=\"javascript:djs_diblock_switch('$f_js_helper_id');\" id='{$f_js_helper_id}_title'>".(direct_local_get ("core_detailed_information"))."</a></span><div id='$f_js_helper_id'><div class='pagehelpercontent' style='text-align:justify'><br />
$f_text</div></div></div><script language='JavaScript' type='text/javascript'><![CDATA[
if (djs_swgDOM_elements_editable) { djs_diblock_init ('$f_js_helper_id',$f_js_helper_open); }
else { djs_var['core_run_onload'].push (\"djs_diblock_init ('$f_js_helper_id',$f_js_helper_open)\"); }
djs_load_functions ('swg_basic_functions.php.js','djs_diblock_switch');
]]></script>");

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->js_helper ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_output_control->header_elements ($f_data = "",$f_id = "")
/**
	* Creates a JavaScript section including all functions required by the sWG.
	*
	* @param  string $f_data Header definition to be added
	* @param  string $f_id Defined ID of the header element
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Nothing in input mode or the ready to use XHTML string
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function header_elements ($f_data = "",$f_id = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->header_elements ($f_data,$f_id)- (#echo(__LINE__)#)"); }

		if (strlen ($f_data))
		{
			if (!strlen ($f_id)) { $f_id = md5 ($f_data); }
			$this->output_additional_header[$f_id] = $f_data;
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->header_elements ()- (#echo(__LINE__)#)",(:#*/implode ("\n",$this->output_additional_header)/*#ifdef(DEBUG):),true):#*/; }
	}

	//f// direct_output_control->header_sent ($f_id)
/**
	* Checks if a header ID was added to the output.
	*
	* @param  string $f_id Defined ID of the header element
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if included
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function header_sent ($f_id = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->header_sent ($f_id)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->header_sent ()- (#echo(__LINE__)#)",(:#*/isset ($this->output_additional_header[$f_id])/*#ifdef(DEBUG):),true):#*/;
	}

	//f// direct_output_control->options_check ($f_menu)
/**
	* Checks if a menu container has content
	*
	* @param  string $f_menu Name of the menu container
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean True if the menu container is not empty
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function options_check ($f_menu)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->options_check ($f_menu)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->options_check ()- (#echo(__LINE__)#)",(:#*/isset ($this->menus[$f_menu])/*#ifdef(DEBUG):),true):#*/;
	}

	//f// direct_output_control->options_flush ($f_all = false)
/**
	* Flushs the content of menu containers
	*
	* @param  boolean $f_all True for removing even protected menus
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function options_flush ($f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->options_flush (+f_all)- (#echo(__LINE__)#)"); }

		if ($f_all) { $this->menus = array (); }
		else
		{
			if (!empty ($this->menus))
			{
				if (!isset ($this->menus_protected)) { $this->menus_protected = array (); }

				foreach ($this->menus as $f_menu_id => $f_menu_array)
				{
					if (!$this->menus_protected[$f_menu_id]) { unset ($this->menus[$f_menu_id]); }
				}
			}
		}
	}

	//f// direct_output_control->options_flush_unprotect ($f_menu)
/**
	* Removes the protection of a menu container
	*
	* @param  string $f_menu Name of the menu container
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function options_flush_unprotect ($f_menu)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->options_flush_unprotect ($f_menu)- (#echo(__LINE__)#)"); }
		$this->menus_protected[$f_menu] = false;
	}

	//f// direct_output_control->options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode = "asis")
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
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -output_class->options_insert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (!isset ($this->menus)) { $this->menus = array (); }
		$f_menu = preg_replace ("#[;\/\\\?:@\=\&\. \+]#i","",$f_menu);

		if (($f_url)&&(($f_title)||($f_image)))
		{
			if (!isset ($this->menus[$f_menu])) { $this->menus[$f_menu] = array (); }
			if (!isset ($this->menus[$f_menu][$f_level])) { $this->menus[$f_menu][$f_level] = array (); }
			$f_image = ((($f_image)&&($direct_settings['swg_options_image'])) ? direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/".$f_image,true,false) : "");
			if ($f_urlmode != "asis") { $f_url = direct_linker ($f_urlmode,$f_url); }

$this->menus[$f_menu][$f_level][] = array (
"url" => $f_url,
"title" => $f_title,
"image" => $f_image
);

			if (!isset ($this->menus_protected[$f_menu])) { $this->menus_protected[$f_menu] = true; }
			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->options_insert ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_output_control->options_generator ($f_type,$f_menu,$f_seperator = "")
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

	//f// direct_output_control->oset ($f_module,$f_obj)
/**
	* Load an OSet element for output (page_content)
	*
	* @param  string $f_module The OSet module
	* @param  string $f_obj The target OSet object
	* @uses   direct_class_init()
	* @uses   direct_debug()
	* @uses   direct_error_functions::error_page()
	* @uses   direct_output_control::oset_content()
	* @uses   direct_output_smiley_decode()
	* @uses   direct_output_theme_subtype()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function oset ($f_module,$f_obj)
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->oset ($f_module,$f_obj)- (#echo(__LINE__)#)"); }

		$f_return = false;

/* -------------------------------------------------------------------------
Check and activate light mode if required.
------------------------------------------------------------------------- */

		if (!$direct_settings['swg_force_notheme'])
		{
			if (($direct_cachedata['core_time'] + $direct_settings['timeout_lightmode']) < (time ()))
			{
				$f_subtype = ($direct_settings['theme_subtype'] ? $direct_settings['theme_subtype']."_light" : "light");
				if (direct_output_theme_subtype ($f_subtype)) { direct_class_init ("output_theme",true); }
			}

			if (!isset ($direct_classes['output_theme'])) { direct_class_init ("output_theme"); }
		}

/* -------------------------------------------------------------------------
Parse additional copyright information for output.
------------------------------------------------------------------------- */

		if ((is_array (@$direct_settings['additional_copyright']))&&(!empty ($direct_settings['additional_copyright'])))
		{
			$this->output_additional_copyright = "";

			foreach ($direct_settings['additional_copyright'] as $f_copyright_array)
			{
				if ($this->output_additional_copyright) { $this->output_additional_copyright .= "<br />\n"; }

				if (count ($f_copyright_array) == 2) { $this->output_additional_copyright .= "<a href='{$f_copyright_array[0]}' target='_blank'>{$f_copyright_array[1]}</a>"; }
				elseif (count ($f_copyright_array) > 2) { $this->output_additional_copyright .= ($f_copyright_array[0]."<a href='{$f_copyright_array[1]}' target='_blank'>{$f_copyright_array[2]}</a>".$f_copyright_array[3]); }
			}
		}
		else { $this->output_additional_copyright = ""; }

		$this->page_content = $this->oset_content ($f_module,$f_obj);

		if (strlen ($this->page_content))
		{
			$f_return = true;
			$this->page_content = direct_output_smiley_decode ($this->page_content);
		}
		else { $direct_classes['error_functions']->error_page ("critical","core_required_object_not_found","FATAL ERROR:<br />&quot;$f_obj&quot; of &quot;$f_module&quot; has reported an error while initiating the OSet<br />sWG/#echo(__FILEPATH__)# -output_class->oset ()- (#echo(__LINE__)#)"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->oset ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_output_control->oset_get_content ($f_module,$f_obj)
/**
	* Load an OSet element
	*
	* @param  string $f_module The OSet module
	* @param  string $f_obj The target OSet object
	* @uses   direct_basic_functions::include_file()
	* @uses   direct_basic_functions::settings_get()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Output data
	* @since  v0.1.07
*/
	/*#ifndef(PHP4) */public /* #*/function oset_content ($f_module,$f_obj)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->oset_content ($f_module,$f_obj)- (#echo(__LINE__)#)"); }

		$f_return = "";

		if (!function_exists ("direct_output_oset_".$f_obj))
		{
/* -------------------------------------------------------------------------
We are supporting subdirectories. Split it and get relevant module data!
------------------------------------------------------------------------- */

			if (strpos ($f_module,"/") === false) { $f_oset = "swg_$f_module.php"; }
			else
			{
				$f_oset = substr (strrchr ($f_module,"/"),1);
				$f_oset = preg_replace ("#[;\/\\\?:@\=\&\.\+]#i","",$f_oset);

				$f_oset_path = preg_quote ($f_oset);
				$f_oset_path = preg_replace ("#\/$f_oset_path$#","",$f_module);
				$f_oset_path = preg_replace ("#[;\?:@\=\&\.\+]#i","",$f_oset_path);

				$f_oset = $f_oset_path."/swg_{$f_oset}.php";
				$f_module = str_replace ("/","_",$f_module);
			}

/* -------------------------------------------------------------------------
The next step is to get the file if available ... otherwise try to catch the
file of the default OSet
------------------------------------------------------------------------- */

			if (file_exists ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/".$f_oset)) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/".$f_oset); }
			else
			{
				if ($direct_settings['swg_theme_oset']) { $direct_settings['theme_oset'] = $direct_settings['swg_theme_oset']; }
				$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/".$f_oset);
			}

			$direct_classes['basic_functions']->settings_get ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swg_oset_up.xml");
		}

		$f_oset = "direct_output_oset_{$f_module}_".$f_obj;
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->oset_content ()- (#echo(__LINE__)#)",:#*/(function_exists ($f_oset) ? $f_oset () : "")/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_output_control->redirect ($f_url,$f_use_current_url = false)
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

		$direct_cachedata['output_pagetarget'] = str_replace ("&","&amp;",$f_url);
		$direct_cachedata['output_redirect'] = (function_exists ("direct_linker") ? direct_linker ("optical",$direct_cachedata['output_scripttarget']) : direct_html_encode_special ($direct_cachedata['output_scripttarget']));
		$direct_cachedata['output_scripttarget'] = $f_url;

		$this->oset ("default","redirect");
		header ("HTTP/1.1 302 Found",true);
		$this->header ($f_use_current_url);
		header ("Location: $f_url");
		$this->options_flush (true);
		$this->theme_page (direct_local_get ("core_redirect"));
		$this->page_show ();

		$direct_cachedata['core_service_activated'] = true;
	}

	//f// direct_output_control->servicemenu ($f_menu,$f_level = 6)
/**
	* Reads a service menu from a file and adds it to the cache
	*
	* @param  string $f_menu The service menu
	* @param  integer $f_level Number from 0 (highest) to 9
	* @uses   direct_debug()
	* @uses   direct_output_control->options_insert()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function servicemenu ($f_menu,$f_level = 6)
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -output_class->servicemenu ($f_menu,$f_level)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_menu_array = (file_exists ($direct_settings['path_data']."/settings/swg_{$f_menu}.servicemenu.xml") ? $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_{$f_menu}.servicemenu.xml") : array ());

		if ((is_array ($f_menu_array))&&(!empty ($f_menu_array)))
		{
			foreach ($f_menu_array as $f_menu_id => $f_menu_item_array)
			{
				if ((isset ($f_menu_item_array['attributes']['active']))&&($f_menu_item_array['attributes']['active']))
				{
					$f_continue_check = true;

					if ($f_menu_item_array['attributes']['lang'])
					{
						if ($f_menu_item_array['attributes']['lang'] != $direct_settings['lang']) { $f_continue_check = false; }
					}

					if ($f_menu_array[$f_menu_id."_title"]) { $f_menu_item_array['value'] = $f_menu_array[$f_menu_id."_title"]['value']; }
					else { $f_continue_check = false; }

					$f_menu_item_array['attributes']['image'] = (isset ($f_menu_array[$f_menu_id."_image"]) ? $f_menu_array[$f_menu_id."_image"]['value'] : "");

					if ($f_menu_array[$f_menu_id."_link"])
					{
						$f_menu_item_array['attributes']['link'] = $f_menu_array[$f_menu_id."_link"];
						$f_menu_item_array['attributes']['link']['type'] = (isset ($f_menu_array[$f_menu_id."_link"]['attributes']['type']) ? $f_menu_array[$f_menu_id."_link"]['attributes']['type'] : "");
					}
					else { $f_continue_check = false; }

					$f_right_check = false;
					if (($f_menu_array[$f_menu_id."_guests"])&&($f_menu_array[$f_menu_id."_guests"]['value'])&&($direct_settings['user']['type'] == "gt")) { $f_right_check = true; }
					if (($f_menu_array[$f_menu_id."_members"])&&($f_menu_array[$f_menu_id."_members"]['value'])&&(direct_class_function_check ($direct_classes['kernel'],"v_usertype_get_int"))&&($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']))) { $f_right_check = true; }

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

					if ((!$f_right_check)&&($f_menu_array[$f_menu_id."_group_right"])&&(direct_class_function_check ($direct_classes['kernel'],"v_group_user_check_right")))
					{
						if (isset ($f_menu_array[$f_menu_id."_group_right"]['value']))
						{
							if ($f_menu_array[$f_menu_id."_group_right"]['value']) { $f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_menu_array[$f_menu_id."_group_right"]['value']); }
						}
						elseif (is_array ($f_menu_array[$f_menu_id."_group_right"]))
						{
							$f_group_rights_array = array ();

							foreach ($f_menu_array[$f_menu_id."_group_right"] as $f_group_right_array)
							{
								if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
							}

							$f_right_check = $direct_classes['kernel']->v_group_user_check_right ($f_group_rights_array);
						}
					}

					if (($f_continue_check)&&($f_right_check))
					{
						if ($f_menu_item_array['attributes']['level']) { $direct_classes['output']->options_insert ($f_menu_item_array['attributes']['level'],"servicemenu",$f_menu_item_array['attributes']['link']['value'],$f_menu_item_array['value'],$f_menu_item_array['attributes']['image'],$f_menu_item_array['attributes']['link']['type']); }
						else { $direct_classes['output']->options_insert ($f_level,"servicemenu",$f_menu_item_array['attributes']['link']['value'],$f_menu_item_array['value'],$f_menu_item_array['attributes']['image'],$f_menu_item_array['attributes']['link']['type']); }
					}
				}

				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -output_class->servicemenu ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

//f// direct_output_pages_generator ($f_uri,$f_pages,$f_cpage = "",$f_with_lastnext_keys = true)
/**
* Return a complete page list (XHTML) using the given paramters
*
* @param  string $f_uri URI where the DSD page variable should be added
*         (should include &dsd= or &dsd=some+thing++)
* @param  integer $f_pages Amount of pages
* @param  integer $f_cpage Currently selected page
* @param  boolean $f_with_lastnext_keys True to include links for the last and
*         next page
* @param  string $f_uri_type Linking mode: "url0" for internal links, "url1"
*         for external ones, "form" to create hidden fields or "optical" to
*         remove parts of a very long string.
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Resulting XHMTL code
* @since  v0.1.01
*/
function direct_output_pages_generator ($f_uri,$f_pages,$f_cpage = "",$f_with_lastnext_keys = true,$f_uri_type = "url0")
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_output_pages_generator ($f_uri,$f_pages,$f_cpage,+f_with_lastnext_keys,+f_uri_as_is)- (#echo(__LINE__)#)"); }

	$f_return = "";
	if (($f_uri_type != "asis")&&(strpos ($f_uri,"javascript:") === 0)) { $f_uri_type = "asis"; }

	if ($f_uri)
	{
		if (!$f_pages) { $f_pages = 1; }

		if ($f_pages < ($direct_settings['swg_pages_per_list'] + 2))
		{
			for ($f_i = 1;$f_i <= $f_pages;$f_i++)
			{
				if ($f_return != "") { $f_return .= ", "; }

				if ($f_i == $f_cpage) { $f_return .= $f_i; }
				elseif ($f_uri_type == "asis") { $f_return .= "<a href=\"".(str_replace ("[page]",$f_i,$f_uri))."\">$f_i</a>"; }
				else { $f_return .= "<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".$f_i))."\">$f_i</a>"; }
			}
		}
		elseif ((!$f_cpage)||($f_cpage < ($direct_settings['swg_pages_per_list'] - 2)))
		{
			for ($f_i = 1;$f_i <= $direct_settings['swg_pages_per_list'];$f_i++)
			{
				if ($f_return != "") { $f_return .= ", "; }

				if ($f_i == $f_cpage) { $f_return .= $f_i; }
				elseif ($f_uri_type == "asis") { $f_return .= "<a href=\"".(str_replace ("[page]",$f_i,$f_uri))."\">$f_i</a>"; }
				else { $f_return .= "<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".$f_i))."\">$f_i</a>"; }
			}

			$f_return .= (($f_uri_type == "asis") ? ", ... (<a href=\"".(str_replace ("[page]",$f_pages,$f_uri))."\">$f_pages</a>)" : ", ... (<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+$f_pages"))."\">$f_pages</a>)");
		}
		elseif ((($f_cpage + $direct_settings['swg_pages_per_list']) - 3) > $f_pages)
		{
			$f_return .= (($f_uri_type == "asis") ? "<a href=\"".(str_replace ("[page]",1,$f_uri))."\">1</a>, ..." : "<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+1"))."\">1</a>, ...");

			$f_page_first = (($f_pages - $direct_settings['swg_pages_per_list']) + 3);

			for ($f_i = $f_page_first;$f_i <= $f_pages;$f_i++)
			{
				if ($f_i == $f_cpage) { $f_return .= ", ".$f_i; }
				elseif ($f_uri_type == "asis") { $f_return .= ", <a href=\"".(str_replace ("[page]",$f_i,$f_uri))."\">$f_i</a>"; }
				else { $f_return .= ", <a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".$f_i))."\">$f_i</a>"; }
			}
		}
		else
		{
			$f_page_first = ($f_pages - ($f_pages - $f_cpage) - (floor ($direct_settings['swg_pages_per_list'] / 2)) + 2);
			$f_page_last = ($f_page_first + ($direct_settings['swg_pages_per_list'] - 4));
			$f_return .= (($f_uri_type == "asis") ? "<a href=\"".(str_replace ("[page]",1,$f_uri))."\">1</a>, ..." : "<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+1"))."\">1</a>, ...");

			for ($f_i = $f_page_first;$f_i <= $f_page_last;$f_i++)
			{
				if ($f_i == $f_cpage) { $f_return .= ", ".$f_i; }
				elseif ($f_uri_type == "asis") { $f_return .= ", <a href=\"".(str_replace ("[page]",$f_i,$f_uri))."\">$f_i</a>"; }
				else { $f_return .= ", <a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".$f_i))."\">$f_i</a>"; }
			}

			if ($f_page_last < $f_pages) { $f_return .= (($f_uri_type == "asis") ? ", ... (<a href=\"".(str_replace ("[page]",$f_pages,$f_uri))."\">$f_pages</a>)" : ", ... (<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+$f_pages"))."\">$f_pages</a>)"); }
		}

		if ($f_return != "")
		{
			if (($f_with_lastnext_keys)&&($f_cpage > 1)) { $f_return = (($f_uri_type == "asis") ? "<a href=\"".(str_replace ("[page]",($f_cpage - 1),$f_uri))."\">$direct_settings[swg_pages_key_last]</a> ".$f_return : "<a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".($f_cpage - 1)))."\">$direct_settings[swg_pages_key_last]</a> ".$f_return); }
			if (($f_with_lastnext_keys)&&($f_pages > 1)&&($f_cpage != $f_pages)) { $f_return .= (($f_uri_type == "asis") ? " <a href=\"".(str_replace ("[page]",($f_cpage + 1),$f_uri))."\">$direct_settings[swg_pages_key_next]</a>" : " <a href=\"".(direct_linker ($f_uri_type,$f_uri."page+".($f_cpage + 1)))."\">$direct_settings[swg_pages_key_next]</a>"); }
			$f_return = "<span style='font-weight:bold'>".(direct_local_get ("core_pages")).":</span> ".$f_return;
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_pages_generator ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_related_manager ($f_rid,$f_exec_mode = "post_module_service_action",$f_no_traverse = false)
/**
* Find and execute content related materials in a defined mode for a defined
* ID.
*
* @param  string $f_rid The related ID
* @param  string $f_exec_mode Mode when the related content will be executed
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.03
*/
function direct_output_related_manager ($f_rid,$f_exec_mode = "post_module_service_action",$f_no_traverse = false)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_output_related_manager ($f_rid,$f_exec_mode,+f_no_traverse)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if ((($direct_cachedata['core_time'] + $direct_settings['timeout']) > (time ()))&&($f_rid))
	{
		if (!isset ($direct_cachedata['output_related_manager_data'])) { $direct_cachedata['output_related_manager_data'] = array (); }

		$f_data_id = "swg_".$f_rid;
		$f_related_path = $direct_classes['basic_functions']->varfilter ($direct_settings['swg_path_related_data'],"settings");
		$f_related_tree_array = array ();

		if ($f_no_traverse)
		{
			if (isset ($direct_cachedata['output_related_manager_data'][$f_data_id])) { $f_related_tree_array[] = $direct_cachedata['output_related_manager_data'][$f_data_id]; }
			else
			{
				if (file_exists ($f_related_path.$f_data_id.".xml"))
				{
					$f_xml_array = $direct_classes['basic_functions']->memcache_get_file_merged_xml ($f_related_path.$f_data_id.".xml");

					if ($f_xml_array)
					{
						$direct_cachedata['output_related_manager_data'][$f_data_id] = $f_xml_array;
						$f_related_tree_array[] = $f_xml_array;
						$f_return = true;
					}
				}
			}
		}
		else
		{
			$f_id_array = explode ("_",$f_rid);
			$f_return = true;
			array_unshift ($f_id_array,"swg");

			if ($f_id_array)
			{
				while (!empty ($f_id_array))
				{
					$f_id = array_pop ($f_id_array);

					if (strlen ($f_id))
					{
						if (isset ($direct_cachedata['output_related_manager_data'][$f_data_id])) { $f_related_tree_array[] = $direct_cachedata['output_related_manager_data'][$f_data_id]; }
						else
						{
							if (file_exists ($f_related_path.$f_data_id.".xml"))
							{
								$f_xml_array = $direct_classes['basic_functions']->memcache_get_file_merged_xml ($f_related_path.$f_data_id.".xml");

								if ($f_xml_array)
								{
									$direct_cachedata['output_related_manager_data'][$f_data_id] = $f_xml_array;
									$f_related_tree_array[] = $f_xml_array;
								}
								else { $f_return = false; }
							}
						}
					}

					$f_data_id = implode ("_",$f_id_array);
				}
			}
		}


		if (!empty ($f_related_tree_array))
		{
			$f_default_check = (($f_exec_mode == "post_module_service_action") ? true : false);

			foreach ($f_related_tree_array as $f_related_array)
			{
				if (!empty ($f_related_array))
				{
					foreach ($f_related_array as $f_related_id => $f_related_item_array)
					{
						$f_continue_check = false;

						if (isset ($f_related_item_array['attributes']['related_mode']))
						{
							if ($f_exec_mode == $f_related_item_array['attributes']['related_mode']) { $f_continue_check = true; }
						}
						else { $f_continue_check = $f_default_check; }

						if ($f_continue_check)
						{
							$f_related_id = preg_replace ("#swg_settings_file_v(\d+)_#i","",$f_related_id);

							if (isset ($f_related_item_array['attributes']['related_controller']))
							{
								$f_continue_check = isset ($f_related_item_array['attributes']['module']);

								if ($f_continue_check)
								{
									$f_related_item_array['attributes']['module'] = $direct_classes['basic_functions']->inputfilter_filepath ($f_related_item_array['attributes']['module']);
									$f_continue_check = isset ($f_related_item_array['attributes']['function']);
								}

								if (($f_continue_check)&&(!strlen ($f_related_item_array['attributes']['module']))) { $f_continue_check = false; }

								if (($f_continue_check)&&($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/mods/".$f_related_item_array['attributes']['module'],2)))
								{
									$f_function = "direct_mods_related_".$f_related_item_array['attributes']['function'];
									if (function_exists ($f_function)) { $f_function ($f_rid,$f_related_item_array['value']); }
								}
							}
							elseif (!isset ($direct_settings[$f_related_id])) { $direct_settings[$f_related_id] = $f_related_item_array['value']; }
						}
					}
				}
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_related_manager ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_smiley_cleanup ($f_data)
/**
* Converts smiley codes of the given string to plain text
*
* @param  string $f_data Input string
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Filtered string
* @since  v0.1.01
*/
function direct_output_smiley_cleanup ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_cleanup (+f_data)- (#echo(__LINE__)#)"); }

	$f_return =& $f_data;

	if (!isset ($direct_cachedata['output_smilies_data']))
	{
		$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
		if ($f_data_array) { $f_data_array = direct_output_smiley_parse_xmltree ($f_data_array); }
		if ($f_data_array) { $direct_cachedata['output_smilies_data'] = $f_data_array; }
	}

	if ((!empty ($f_data))&&(!empty ($direct_cachedata['output_smilies_data'])))
	{
		foreach ($direct_cachedata['output_smilies_data'] as $f_smiley_array)
		{
			foreach ($f_smiley_array['codes'] as $f_smiley) { $f_data = str_replace ("|{$f_smiley}|",$f_smiley,$f_data); }
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_cleanup ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_smiley_decode ($f_data)
/**
* Smiley codes are rewritten using XHTML "img" tags
*
* @param  string $f_data Input string
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Filtered string
* @since  v0.1.01
*/
function direct_output_smiley_decode ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_decode (+f_data)- (#echo(__LINE__)#)"); }

	$f_return =& $f_data;

	if (!isset ($direct_cachedata['output_smilies_data']))
	{
		$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
		if ($f_data_array) { $f_data_array = direct_output_smiley_parse_xmltree ($f_data_array); }
		if ($f_data_array) { $direct_cachedata['output_smilies_data'] = $f_data_array; }
	}

	if ((!empty ($f_data))&&(!empty ($direct_cachedata['output_smilies_data'])))
	{
		$f_smilies_path = $direct_classes['basic_functions']->varfilter ($direct_settings['swg_path_smilies'],"settings");

		foreach ($direct_cachedata['output_smilies_data'] as $f_smiley_array)
		{
			foreach ($f_smiley_array['codes'] as $f_smiley)
			{
				$f_smiley = str_replace ("&amp;","&",(direct_html_encode_special ($f_smiley)));
				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"|{$f_smiley}|") !== false) { $f_data = str_replace ("|{$f_smiley}|",("<img src='".(direct_linker_dynamic ("url1","s=cache&dsd=dfile+".$f_smilies_path.$f_smiley_array['file'],true,false))."' alt=\"{$f_smiley}\" title=\"{$f_smiley}\" style='vertical-align:middle' />"),$f_data); }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_decode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_smiley_encode ($f_data)
/**
* Converts smilies to recognisable codes
*
* @param  string $f_data Input string
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Filtered string
* @since  v0.1.01
*/
function direct_output_smiley_encode ($f_data)
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_encode (+f_data)- (#echo(__LINE__)#)"); }

	$f_return =& $f_data;

	if (!isset ($direct_cachedata['output_smilies_data']))
	{
		$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_classes['basic_functions']->memcache_get_file_merged_xml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
		if ($f_data_array) { $f_data_array = direct_output_smiley_parse_xmltree ($f_data_array); }
		if ($f_data_array) { $direct_cachedata['output_smilies_data'] = $f_data_array; }
	}

	if ((!empty ($f_return))&&(!empty ($direct_cachedata['output_smilies_data'])))
	{
		foreach ($direct_cachedata['output_smilies_data'] as $f_smiley_array)
		{
			foreach ($f_smiley_array['codes'] as $f_smiley)
			{
				$f_smiley_preg = preg_quote ($f_smiley);
				$f_return = preg_replace ("#( |\(|\)|\]|^)$f_smiley_preg( |\(|\)|\[|,|.|$)#im","\\1|{$f_smiley}|\\2",$f_return);
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_encode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_smiley_parse_xmltree ($f_data)
/**
* Converts an XML array tree into a smiley code array
*
* @param  array $f_data Input XML array tree
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Filtered string
* @since  v0.1.03
*/
function direct_output_smiley_parse_xmltree ($f_xml_array)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_parse_xmltree (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = array ();

	if ((is_array ($f_xml_array))&&(!empty ($f_xml_array)))
	{
		foreach ($f_xml_array as $f_key => $f_xml_node_array)
		{
			if ((isset ($f_xml_node_array['tag']))&&($f_key == "swg_smilies_file_v1_".$f_xml_node_array['tag']))
			{
				$f_smiley_array = array ("file" => $f_xml_node_array['value'], "codes" => array ());

				if (isset ($f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"]['tag']))
				{
					if (($f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"]['tag'] == "smileycode")&&(strlen ($f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"]['value']))) { $f_smiley_array['codes'][] = $f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"]['value']; }
				}
				elseif (is_array ($f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"]))
				{
					foreach ($f_xml_array["swg_smilies_file_v1_{$f_xml_node_array['tag']}_smileycode"] as $f_xml_sub_node_array)
					{
						if (($f_xml_sub_node_array['tag'] == "smileycode")&&(strlen ($f_xml_sub_node_array['value']))) { $f_smiley_array['codes'][] = $f_xml_sub_node_array['value']; }
					}
				}

				if (!empty ($f_smiley_array['codes'])) { $f_return[] = $f_smiley_array; }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_smiley_parse_xmltree ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_theme ($f_theme)
/**
* Load up a theme
*
* @param  string $f_theme Requested theme
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean False on error
* @since  v0.1.01
*/
function direct_output_theme ($f_theme)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_output_theme ($f_theme)- (#echo(__LINE__)#)"); }

	$f_return = true;

	if (!isset ($direct_classes['basic_functions'])) { direct_class_init ("basic_functions"); }

	if ($direct_classes['basic_functions']->include_file ($direct_settings['path_themes']."/$f_theme/swg_theme.php",2))
	{
		$direct_settings['theme'] = $f_theme;
		if (!isset ($direct_settings['theme_subtype'])) { $direct_settings['theme_subtype'] = ""; }
	}
	else
	{
		$direct_settings['theme'] = $direct_settings['swg_theme'];
		if (!isset ($direct_settings['theme_subtype'])) { $direct_settings['theme_subtype'] = ""; }
		$f_return = $direct_classes['basic_functions']->include_file ($direct_settings['path_themes']."/$direct_settings[theme]/swg_theme.php",2);
	}

	$direct_classes['basic_functions']->settings_get ($direct_settings['path_themes']."/$direct_settings[theme]/swg_theme_up.xml");

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_theme ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_theme_subtype ($f_theme)
/**
* Define and try to load a theme subtype
*
* @param  string $f_theme Requested theme
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return boolean False on error
* @since  v0.1.03
*/
function direct_output_theme_subtype ($f_subtype)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_output_theme_subtype ($f_subtype)- (#echo(__LINE__)#)"); }

	$f_return = false;
	$f_subtype = preg_replace ("#[\/\\\?:@\=\&\. \+]#i","",$f_subtype);

	if (!$direct_settings['swg_force_notheme'])
	{
		$f_return = $direct_classes['basic_functions']->include_file ($direct_settings['path_themes']."/$direct_settings[theme]/swg_theme_$f_subtype.php",2);

		if (!$f_return)
		{
			if (isset ($direct_settings["swg_theme_supported_subtypes_".$f_subtype])) { $f_return = $direct_classes['basic_functions']->include_file (($direct_classes['basic_functions']->varfilter ($direct_settings["swg_theme_supported_subtypes_".$f_subtype],"settings")),2); }
			elseif (isset ($direct_settings['swg_theme_supported_subtypes']))
			{
				if (isset ($direct_settings['swg_theme_supported_subtypes'][$f_subtype])) { $f_return = $direct_classes['basic_functions']->include_file (($direct_classes['basic_functions']->varfilter ($direct_settings['swg_theme_supported_subtypes'][$f_subtype],"settings")),2); }
			}
		}

		if ($f_return) { $direct_settings['theme_subtype'] = $f_subtype; }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_output_theme_subtype ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_output_warning ($f_title,$f_text)
/**
* Use this function to generate a warning to be displayed later on.
*
* @param  string $f_title Title
* @param  string $f_text Short description
* @uses   direct_debug()
* @uses   direct_html_encode_special()
* @uses   USE_debug_reporting
* @since  v0.1.08
*/
function direct_output_warning ($f_title,$f_text)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_output_warning ($f_title,+f_text)- (#echo(__LINE__)#)"); }

	$f_text = direct_html_encode_special (preg_replace ("#\[url:(.+?)\](.+?)[/url]#i","<a href=\"\\1\" target='_self'>\\2</a>",$f_text));
	$direct_cachedata['output_warning'][] = array ("title" => direct_html_encode_special ($f_title),"text" => $f_text);
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['output'] = "direct_output_control";
define ("CLASS_direct_output_control",true);

//j// Script specific commands

if (!isset ($direct_settings['formbuilder_jfield_supported'])) { $direct_settings['formbuilder_jfield_supported'] = false; }
if (!isset ($direct_settings['swg_pages_key_last'])) { $direct_settings['swg_pages_key_last'] = "&#0171;"; }
if (!isset ($direct_settings['swg_pages_key_next'])) { $direct_settings['swg_pages_key_next'] = "&#0187;"; }
if (!isset ($direct_settings['swg_pages_per_list'])) { $direct_settings['swg_pages_per_list'] = 6; }
if (!isset ($direct_settings['swg_path_related_data'])) { $direct_settings['swg_path_related_data'] = $direct_settings['path_data']."/related/"; }
if (!isset ($direct_settings['swg_options_image'])) { $direct_settings['swg_options_image'] = false; }
if (!isset ($direct_settings['swg_theme_supported_subtypes'])) { $direct_settings['swg_theme_supported_subtypes'] = array (); }
if (!isset ($direct_settings['theme_lightmode_supported'])) { $direct_settings['theme_lightmode_supported'] = false; }
}

//j// EOF
?>