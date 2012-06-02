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
* of them (including methods from directOHandler).
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
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = ((defined ("CLASS_directOHandlerBasics")) ? false : true);
if (!defined ("CLASS_directOHandler")) { $g_continue_check = false; }

if ($g_continue_check)
{
/**
* "directOHandlerBasics" is responsible for formatting content and displaying
* it.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directOHandlerBasics extends directOHandler
{
/**
	* @var array $header_elements Cache for additional headers
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $header_elements;
/**
	* @var integer $js_helper_element Javascript element counter
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
	* @var string $oset OSet
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $oset;
/**
	* @var mixed $output_additional_copyright Additional copyrights
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_additional_copyright;
/**
	* @var array $related_manager_data Related Manager cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $related_manager_data;
/**
	* @var array $smiley_data Smiley cache
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $smiley_data;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOHandlerBasics)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->__construct (directOHandlerBasics)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['backtraceGet'] = true;
		$this->functions['cssHeader'] = true;
		$this->functions['headerElements'] = true;
		$this->functions['headerSent'] = true;
		$this->functions['jsHeader'] = true;
		$this->functions['jsHelper'] = true;
		$this->functions['optionsCheck'] = true;
		$this->functions['optionsFlush'] = true;
		$this->functions['optionsFlushUnprotect'] = true;
		$this->functions['optionsGenerator'] = true;
		$this->functions['optionsInsert'] = true;
		$this->functions['oset'] = true;
		$this->functions['osetContent'] = true;
		$this->functions['osetCallable'] = true;
		$this->functions['osetSet'] = true;
		$this->functions['outputSend'] = true;
		$this->functions['pagesGenerator'] = true;
		$this->functions['redirect'] = true;
		$this->functions['relatedManager'] = true;
		$this->functions['servicemenu'] = true;
		$this->functions['smileyCleanup'] = true;
		$this->functions['smileyDecode'] = true;
		$this->functions['smileyEncode'] = true;
		$this->functions['smileyParseXmlTree'] = true;
		$this->functions['warning'] = true;

/* -------------------------------------------------------------------------
Set up some variables
------------------------------------------------------------------------- */

		$this->js_helper_element = 0;
		$this->menus = array ();
		$this->menus_protected = array ();
		$this->oset = "default";
		$this->output_additional_copyright = array ();
		$this->output_additional_header = array ();
		$this->related_manager_data = NULL;
		$this->smiley_data = NULL;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOHandlerBasics
	*
	* @since v0.1.01
*\/
	function directOHandlerBasics () { $this->__construct (); }
:#*/
/**
	* Parse a given backtrace array (or try to load one via "debug_backtrace").
	*
	* @param  array $f_data Already extracted backtrace as array
	* @param  string $f_handling Return the string formatted as "text" or "html"
	* @return string Formatted backtrace string
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */protected /* #*/function backtraceGet ($f_data = NULL,$f_handling = "text")
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->backtraceGet (+f_data,$f_handling)- (#echo(__LINE__)#)"); }

		$f_backtrace_array = $direct_globals['basic_functions']->backtraceGet ($f_data);
		$f_return = (empty ($f_backtrace_array) ? "" : implode ("\n",$f_backtrace_array));

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->backtraceGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Adds standard CSS definitions to the list of output (X)HTML headers
	*
	* @param boolean $f_ajaxloading True to include the
	*        "swg_output_ajaxloading.php.css"
	* @param boolean $f_helper True to include the "swg_output_helper.php.css"
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function cssHeader ($f_ajaxloading = true,$f_helper = true)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->cssHeader (+f_ajaxloading,+f_helper)- (#echo(__LINE__)#)"); }

		if ($f_ajaxloading) { $this->headerElements ("<link href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+data/mmedia/swg_output_ajaxloading.php.css",true,false))."' rel='stylesheet' type='text/css' />","link_stylesheet_output_ajaxloading"); }
		if ($f_helper) { $this->headerElements ("<link href='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+data/mmedia/swg_output_helper.php.css",true,false))."' rel='stylesheet' type='text/css' />","link_stylesheet_output_helper"); }
	}

/**
	* Creates a JavaScript section including all functions required by the sWG.
	*
	* @param  string $f_data Header definition to be added
	* @param  string $f_id Defined ID of the header element
	* @param  boolean $f_unshift Add as the first header element
	* @return mixed Nothing in input mode or the ready to use XHTML string
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function headerElements ($f_data = "",$f_id = "",$f_unshift = False)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->headerElements ($f_data,$f_id,+f_unshift)- (#echo(__LINE__)#)"); }

		if (strlen ($f_data))
		{
			if (!strlen ($f_id)) { $f_id = md5 ($f_data); }

			if ($f_unshift) { $this->output_additional_header = array_merge (array ($f_id => $f_data),$this->output_additional_header); }
			else { $this->output_additional_header[$f_id] = $f_data; }
		}
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->headerElements ()- (#echo(__LINE__)#)",(:#*/implode ("\n",$this->output_additional_header)/*#ifdef(DEBUG):),true):#*/; }
	}

/**
	* Checks if a header ID was added to the output.
	*
	* @param  string $f_id Defined ID of the header element
	* @return boolean True if included
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function headerSent ($f_id = "")
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->headerSent ($f_id)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->headerSent ()- (#echo(__LINE__)#)",(:#*/isset ($this->output_additional_header[$f_id])/*#ifdef(DEBUG):),true):#*/;
	}

/**
	* Adds a JavaScript section including all functions required by the sWG to the
	* list of output (X)HTML headers.
	*
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function jsHeader ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->jsHeader ()- (#echo(__LINE__)#)"); }

		$f_uuid_check = ((($direct_globals['kernel']->vUuidCheckUsage ())&&(!$direct_globals['kernel']->vUuidIsCookied ())) ? true : false);
		$this->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_AJAX.php.js++dbid+".$direct_settings['product_buildid'],true,$f_uuid_check))."' type='text/javascript'></script><!-- // Asynchronous JavaScript and XML // -->","script_ajax");
		$this->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_DOM.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // jQuery based DOM // -->","script_dom");
		$this->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_basic_functions.php.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // Basic javascript helper functions // -->","script_basic_functions",true);

$this->headerElements ("<script src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/ext_jquery/jquery-1.7.2.min.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'></script><!-- // jQuery library // -->
<script type='text/javascript'><![CDATA[
if (typeof (djs_var) == 'undefined') { var djs_var = [ ]; }
]]></script>","script_jquery",true);
	}

/**
	* Returns valid XHTML 1.0 code for a dynamic helper box (using JavaScript to
	* open / close it)
	*
	* @param  string $f_text Content string for the Helper Box
	* @param  string $f_url A optional link for the content of the box
	* @param  boolean $f_close_onload True to close the box after loading the page
	* @return string XHTML Code for required JavaScript functions
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function jsHelper ($f_text,$f_url = "",$f_close_onload = true)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->jsHelper (+f_text,$f_url,$f_close_onload)- (#echo(__LINE__)#)"); }

$this->headerElements ("<script type='text/javascript'><![CDATA[
jQuery (function () { djs_load_functions ({ file:'swg_output_helper.php.js' }); });
]]></script>","script_output_helper");

		$f_js_helper_id = ("swghelp".$this->js_helper_element);
		$this->js_helper_element++;
		if (strlen ($f_url)) { $f_text = "<a href=\"$f_url\" target='_blank'>$f_text</a>"; }

		$f_embedded_code = "<div id='$f_js_helper_id' class='pagehelperbg' style='position:relative;width:75%;margin:auto;text-align:justify'><div class='pagehelpericon'><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_mmedia]/swg_output_helper.png",true,false))."' width='32' height='32' alt=\"".(direct_local_get ("core_detailed_information"))."\" title=\"".(direct_local_get ("core_detailed_information"))."\" /></div><span class='pagehelpercontent'>$f_text</span></div>";

		if ((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))&&($f_close_onload))
		{
$f_return = ("<div id='$f_js_helper_id'><a href=\"javascript:djs_core_helper_show('$f_js_helper_id')\">".(direct_local_get ("core_detailed_information_show"))."</a></div><script type='text/javascript'><![CDATA[
jQuery (function () { djs_var.core_output_helper_cache['$f_js_helper_id'] = jQuery (\"".(str_replace ('"','\"',$f_embedded_code))."\"); });
]]></script>");
		}
		else
		{
			$f_close_onload = ($f_close_onload ? "true" : "false");

$f_return = ($f_embedded_code."<script type='text/javascript'><![CDATA[
jQuery (function () { djs_core_helper_init ({ id:'$f_js_helper_id',hide:$f_close_onload }); });
]]></script>");
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->jsHelper ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Checks if a menu container has content
	*
	* @param  string $f_menu Name of the menu container
	* @return boolean True if the menu container is not empty
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function optionsCheck ($f_menu)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->optionsCheck ($f_menu)- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->optionsCheck ()- (#echo(__LINE__)#)",(:#*/isset ($this->menus[$f_menu])/*#ifdef(DEBUG):),true):#*/;
	}

/**
	* Flushs the content of menu containers
	*
	* @param  boolean $f_all True for removing even protected menus
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function optionsFlush ($f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->optionsFlush (+f_all)- (#echo(__LINE__)#)"); }

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

/**
	* Removes the protection of a menu container
	*
	* @param  string $f_menu Name of the menu container
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function optionsFlushUnprotect ($f_menu)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->optionsFlushUnprotect ($f_menu)- (#echo(__LINE__)#)"); }
		$this->menus_protected[$f_menu] = false;
	}

/**
	* Creates XHTML 1.0 code for the given menu using the specified type
	*
	* @param  string $f_type Different menutypes (horizontal / vertical; with or
	*         without a notice for no items) are available
	* @param  string $f_menu Name of the menu container
	* @param  string $f_seperator An optional seperator between each item
	* @return string The resulting XHTML code
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function optionsGenerator ($f_type,$f_menu,$f_seperator = "") { }

/**
	* Adds an item to a specified menu container
	*
	* @param  integer $f_level Number from 0 (highest) to 9
	* @param  string $f_menu Name of the menu container
	* @param  string $f_url URL for the menu item
	* @param  string $f_title Title for the link
	* @param  string $f_image An image for the item (leave empty for none)
	* @param  string $f_urlmode URL mode ("asis", "url0", "url1")
	* @return boolean False on error
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function optionsInsert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode = "asis")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->optionsInsert ($f_level,$f_menu,$f_url,$f_title,$f_image,$f_urlmode)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if (!isset ($this->menus)) { $this->menus = array (); }
		$f_menu = preg_replace ("#[;\/\\\?:@\=\&\. \+]#i","",$f_menu);

		if (($f_url)&&(($f_title)||($f_image)))
		{
			if (!isset ($this->menus[$f_menu])) { $this->menus[$f_menu] = array (); }
			if (!isset ($this->menus[$f_menu][$f_level])) { $this->menus[$f_menu][$f_level] = array (); }
			$f_image = ((($f_image)&&($direct_settings['swg_options_image'])) ? $f_image : "");
			if (strpos ($f_url,"[source]") !== false) { $f_url = str_replace ("[source]",(((isset ($direct_cachedata['page_this']))&&($direct_cachedata['page_this'])) ? urlencode (base64_encode ($direct_cachedata['page_this'])) : ""),$f_url); }

			if ($f_urlmode == "javascript") { $f_url = "javascript:".$f_url; }
			elseif ($f_urlmode != "asis") { $f_url = direct_linker ($f_urlmode,$f_url); }

$this->menus[$f_menu][$f_level][] = array (
"url" => $f_url,
"title" => $f_title,
"type" => (($f_urlmode == "javascript") ? "javascript" : "link"),
"image" => $f_image
);

			if (!isset ($this->menus_protected[$f_menu])) { $this->menus_protected[$f_menu] = true; }
			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->optionsInsert ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Load an OSet element for output (output_content)
	*
	* @param  string $f_module The OSet module
	* @param  string $f_obj The target OSet object
	* @return boolean False on error
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function oset ($f_module,$f_obj)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->oset ($f_module,$f_obj)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$this->output_content = $this->osetContent ($f_module,$f_obj);

		if (strlen ($this->output_content))
		{
			$f_return = true;
			$this->output_content = $this->smileyDecode ($this->output_content);
		}
		else { $this->outputSendError ("critical","core_required_object_not_found","FATAL ERROR:<br />&quot;$f_obj&quot; of &quot;$f_module&quot; has reported an error while initiating the OSet","sWG/#echo(__FILEPATH__)# -oHandler->oset ()- (#echo(__LINE__)#)"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->oset ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Return the OSet callable.
	*
	* @param  string $f_module The OSet module
	* @param  string $f_obj The target OSet object
	* @param  boolean $f_include True if it is a include OSet module
	* @return string Output data
	* @since  v0.1.07
*/
	/*#ifndef(PHP4) */public /* #*/function osetCallable ($f_module,$f_obj,$f_include = false)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->osetCallable ($f_module,$f_obj)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
We are supporting subdirectories. Split it and get relevant module data!
------------------------------------------------------------------------- */

		if (strpos ($f_module,"/") === false) { $f_oset_file = ($f_include ? "swgi_$f_module.php" : "swg_$f_module.php"); }
		else
		{
			$f_oset_file = substr (strrchr ($f_module,"/"),1);
			$f_oset_file = preg_replace ("#[;\/\\\?:@\=\&\.\+]#i","",$f_oset_file);

			$f_oset_path = preg_quote ($f_oset_file);
			$f_oset_path = preg_replace ("#\/$f_oset_path$#","",$f_module);
			$f_oset_path = preg_replace ("#[;\?:@\=\&\.\+]#i","",$f_oset_path);

			$f_oset_file = ($f_include ? $f_oset_path."/swgi_{$f_oset_file}.php" : $f_oset_path."/swg_{$f_oset_file}.php");
			$f_module = str_replace ("/","_",$f_module);
		}

		$f_oset = ($f_include ? "direct_{$f_module}_oset_".$f_obj : "direct_output_oset_{$f_module}_".$f_obj);
		$f_return = "";

		if (!function_exists ($f_oset))
		{
/* -------------------------------------------------------------------------
The next step is to get the file if available ... otherwise try to catch the
file of the default OSet
------------------------------------------------------------------------- */

			if ((!$direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/osets/{$this->oset}/".$f_oset_file))&&($direct_settings['swg_theme_oset'])) { $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/{$direct_settings['swg_theme_oset']}/".$f_oset_file); }
			$direct_globals['basic_functions']->settingsGet ($direct_settings['path_system']."/osets/{$this->oset}/swg_oset_up.xml");
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->osetCallable ()- (#echo(__LINE__)#)",:#*/(function_exists ($f_oset) ? $f_oset : NULL)/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Load an OSet element and return it.
	*
	* @param  string $f_module The OSet module
	* @param  string $f_obj The target OSet object
	* @return string Output data
	* @since  v0.1.07
*/
	/*#ifndef(PHP4) */public /* #*/function osetContent ($f_module,$f_obj)
	{
		if (USE_debug_reporting) { direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->osetContent ($f_module,$f_obj)- (#echo(__LINE__)#)"); }

		$f_oset = $this->osetCallable ($f_module,$f_obj);
		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -oHandler->osetContent ()- (#echo(__LINE__)#)",:#*/(is_callable ($f_oset) ? $f_oset () : "")/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Set an alternative OSet.
	*
	* @param string $f_oset OSet name
	* @since v0.1.09
*/
	/*#ifndef(PHP4) */public /* #*/function osetSet ($f_oset)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->osetSet ($f_oset)- (#echo(__LINE__)#)"); }
		$this->oset = $f_oset;
	}

/**
	* This function is used for later multi-level delivery. Only the final
	* node actually sends data to the requesting client.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function outputSend ($f_title = "",$f_headers = NULL)
	{
		global $direct_settings;

		if ((isset ($direct_settings['user_ip_proxy']))&&((!isset ($_SERVER['HTTPS']))||(!$_SERVER['HTTPS']))) { $this->warning (direct_local_get ("core_user_warning","text"),(direct_local_get ("core_user_warning_proxy","text"))); }
		parent::outputSend ($f_title,$f_headers);
	}

/**
	* Return a complete page list (XHTML) using the given paramters
	*
	* @param  string $f_uri URI where the DSD page variable should be added
	*         (should include ;dsd= or ;dsd=some+thing++)
	* @param  integer $f_pages Amount of pages
	* @param  integer $f_cpage Currently selected page
	* @param  boolean $f_with_lastnext_keys True to include links for the last and
	*         next page
	* @param  string $f_uri_type Linking mode: "url0" for internal links, "url1"
	*         for external ones, "form" to create hidden fields or "optical" to
	*         remove parts of a very long string.
	* @return string Resulting XHMTL code
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function pagesGenerator ($f_uri,$f_pages,$f_cpage = "",$f_with_lastnext_keys = true,$f_uri_type = "url0")
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->pagesGenerator ($f_uri,$f_pages,$f_cpage,+f_with_lastnext_keys,+f_uri_as_is)- (#echo(__LINE__)#)"); }

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

				if ($f_page_last < $f_pages) { $f_return .= ", ... (<a href=\"".(($f_uri_type == "asis") ? str_replace ("[page]",$f_pages,$f_uri) : direct_linker ($f_uri_type,$f_uri."page+$f_pages"))."\">$f_pages</a>)"; }
			}

			if ($f_return != "")
			{
				if (($f_with_lastnext_keys)&&($f_cpage > 1)) { $f_return = "<a href=\"".(($f_uri_type == "asis") ? str_replace ("[page]",($f_cpage - 1),$f_uri) : direct_linker ($f_uri_type,$f_uri."page+".($f_cpage - 1)))."\">$direct_settings[swg_pages_key_last]</a> ".$f_return; }
				if (($f_with_lastnext_keys)&&($f_pages > 1)&&($f_cpage != $f_pages)) { $f_return .= " <a href=\"".(($f_uri_type == "asis") ? str_replace ("[page]",($f_cpage + 1),$f_uri) : direct_linker ($f_uri_type,$f_uri."page+".($f_cpage + 1)))."\">$direct_settings[swg_pages_key_next]</a>"; }
				$f_return = "<strong>".(direct_local_get ("core_pages")).":</strong> ".$f_return;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->pagesGenerator ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* We need some header outputs for redirecting, that's why there exists this
	* function
	*
	* @param string $f_url The target URL
	* @param boolean $f_use_current_url True for allowing the redirect to be
	*        cached
	* @since v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function redirect ($f_url,$f_use_current_url = true) { }

/**
	* Find and execute content related materials in a defined mode for a defined
	* ID.
	*
	* @param  string $f_rid The related ID
	* @param  string $f_exec_mode Mode when the related content will be executed
	* @param  boolean $f_no_traverse True to not load ascending related IDs
	* @return boolean True on success
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function relatedManager ($f_rid,$f_exec_mode = "post_module_service_action",$f_no_traverse = false)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->relatedManager ($f_rid,$f_exec_mode,+f_no_traverse)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((($direct_cachedata['core_time'] + $direct_settings['timeout']) > (time ()))&&($f_rid))
		{
			$f_data_id = "swg_".$f_rid;
			$f_related_path = $direct_globals['basic_functions']->varfilter ($direct_settings['swg_path_related_data'],"settings");
			$f_related_tree_array = array ();

			$f_id_array = ($f_no_traverse ? array ($f_data_id) : explode ("_",$f_rid));
			$f_return = true;
			array_unshift ($f_id_array,"swg");

			if ($f_id_array)
			{
				while (!empty ($f_id_array))
				{
					$f_id = array_pop ($f_id_array);

					if (strlen ($f_id))
					{
						if (isset ($this->related_manager_data[$f_data_id])) { $f_related_tree_array[] = $this->related_manager_data[$f_data_id]; }
						elseif (file_exists ($f_related_path.$f_data_id.".xml"))
						{
							$f_xml_array = $direct_globals['basic_functions']->memcacheGetFileMergedXml ($f_related_path.$f_data_id.".xml");

							if ($f_xml_array)
							{
								$this->related_manager_data[$f_data_id] = $f_xml_array;
								$f_related_tree_array[] = $f_xml_array;
							}
							else { $f_return = false; }
						}
					}

					$f_data_id = implode ("_",$f_id_array);
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

							if (isset ($this->related_manager_data[$f_related_id."_".$f_exec_mode])) { $f_continue_check = false; }
							elseif (isset ($f_related_item_array['attributes']['related_mode']))
							{
								if ($f_exec_mode == $f_related_item_array['attributes']['related_mode']) { $f_continue_check = true; }
							}
							else { $f_continue_check = $f_default_check; }

							if ($f_continue_check)
							{
								$this->related_manager_data[$f_related_id."_".$f_exec_mode] = true;
								$f_related_id = preg_replace ("#swg_settings_file_v(\d+)_#i","",$f_related_id);

								if (isset ($f_related_item_array['attributes']['related_controller']))
								{
									$f_continue_check = isset ($f_related_item_array['attributes']['module']);

									if ($f_continue_check)
									{
										$f_related_item_array['attributes']['module'] = $direct_globals['basic_functions']->inputfilterFilePath ($f_related_item_array['attributes']['module']);
										$f_continue_check = isset ($f_related_item_array['attributes']['function']);
									}

									if (($f_continue_check)&&(!strlen ($f_related_item_array['attributes']['module']))) { $f_continue_check = false; }

									if (($f_continue_check)&&($direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/mods/".$f_related_item_array['attributes']['module'],2)))
									{
										$f_function = "direct_mods_related_".$f_related_item_array['attributes']['function'];
										if (function_exists ($f_function)) { $f_function ($f_rid,$f_related_item_array['value']); }
									}
								}
								elseif (!isset ($direct_settings[$f_related_id])) { $direct_settings[$f_related_id] = $direct_globals['basic_functions']->varfilter ($f_related_item_array['value'],"settings"); }
							}
						}
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->relatedManager ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads a service menu from a file and adds it to the cache
	*
	* @param  string $f_menu The service menu
	* @param  integer $f_level Number from 0 (highest) to 9
	* @return boolean False on error
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function servicemenu ($f_menu,$f_level = 6)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->servicemenu ($f_menu,$f_level)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_menu_array = (file_exists ($direct_settings['path_data']."/settings/swg_{$f_menu}.servicemenu.xml") ? $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_{$f_menu}.servicemenu.xml") : array ());

		if ((is_array ($f_menu_array))&&(!empty ($f_menu_array)))
		{
			foreach ($f_menu_array as $f_menu_id => $f_menu_item_array)
			{
				if ((isset ($f_menu_item_array['attributes']['active']))&&($f_menu_item_array['attributes']['active']))
				{
					$f_continue_check = true;

					if (($f_menu_item_array['attributes']['lang'])&&($f_menu_item_array['attributes']['lang'] != $direct_settings['lang'])) { $f_continue_check = false; }

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
					if (($f_menu_array[$f_menu_id."_members"])&&($f_menu_array[$f_menu_id."_members"]['value'])&&(direct_class_function_check ($direct_globals['kernel'],"vUsertypeGetInt"))&&($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']))) { $f_right_check = true; }

					if ((!$f_right_check)&&($f_menu_array[$f_menu_id."_group_right"])&&(direct_class_function_check ($direct_globals['kernel'],"vGroupUserCheckRight")))
					{
						if (isset ($f_menu_array[$f_menu_id."_group_right"]['value']))
						{
							if ($f_menu_array[$f_menu_id."_group_right"]['value']) { $f_right_check = $direct_globals['kernel']->vGroupUserCheckRight ($f_menu_array[$f_menu_id."_group_right"]['value']); }
						}
						elseif (is_array ($f_menu_array[$f_menu_id."_group_right"]))
						{
							$f_group_rights_array = array ();

							foreach ($f_menu_array[$f_menu_id."_group_right"] as $f_group_right_array)
							{
								if (strlen ($f_group_right_array['value'])) { $f_group_rights_array[] = $f_group_right_array['value']; }
							}

							$f_right_check = $direct_globals['kernel']->vGroupUserCheckRight ($f_group_rights_array);
						}
					}

					if (($f_continue_check)&&($f_right_check))
					{
						if ($f_menu_item_array['attributes']['level']) { $this->optionsInsert ($f_menu_item_array['attributes']['level'],"servicemenu",$f_menu_item_array['attributes']['link']['value'],$f_menu_item_array['value'],$f_menu_item_array['attributes']['image'],$f_menu_item_array['attributes']['link']['type']); }
						else { $this->optionsInsert ($f_level,"servicemenu",$f_menu_item_array['attributes']['link']['value'],$f_menu_item_array['value'],$f_menu_item_array['attributes']['image'],$f_menu_item_array['attributes']['link']['type']); }
					}
				}

				$f_return = true;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->servicemenu ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Converts smiley codes of the given string to plain text
	*
	* @param  string $f_data Input string
	* @return string Filtered string
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function smileyCleanup ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->smileyCleanup (+f_data)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;

		if (!isset ($this->smilies_data))
		{
			$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
			if ($f_data_array) { $f_data_array = $this->smileyParseXmlTree ($f_data_array); }
			if ($f_data_array) { $this->smilies_data = $f_data_array; }
		}

		if ((!empty ($f_data))&&(!empty ($this->smilies_data)))
		{
			foreach ($this->smilies_data as $f_smiley_array)
			{
				foreach ($f_smiley_array['codes'] as $f_smiley) { $f_data = str_replace ("|{$f_smiley}|",$f_smiley,$f_data); }
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->smileyCleanup ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Smiley codes are rewritten using XHTML "img" tags
	*
	* @param  string $f_data Input string
	* @return string Filtered string
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function smileyDecode ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->smileyDecode (+f_data)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;

		if (!isset ($this->smilies_data))
		{
			$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
			if ($f_data_array) { $f_data_array = $this->smileyParseXmlTree ($f_data_array); }
			if ($f_data_array) { $this->smilies_data = $f_data_array; }
		}

		if ((!empty ($f_data))&&(!empty ($this->smilies_data)))
		{
			$f_smilies_path = $direct_globals['basic_functions']->varfilter ($direct_settings['swg_path_smilies'],"settings");

			foreach ($this->smilies_data as $f_smiley_array)
			{
				foreach ($f_smiley_array['codes'] as $f_smiley)
				{
					$f_smiley = str_replace ("&amp;","&",(direct_html_encode_special ($f_smiley)));
					if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"|{$f_smiley}|") !== false) { $f_data = str_replace ("|{$f_smiley}|",("<img src='".(direct_linker_dynamic ("url1","s=cache;dsd=dfile+".$f_smilies_path.$f_smiley_array['file'],true,false))."' alt=\"{$f_smiley}\" title=\"{$f_smiley}\" style='vertical-align:middle' />"),$f_data); }
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->smileyDecode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Converts smilies to recognisable codes
	*
	* @param  string $f_data Input string
	* @return string Filtered string
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function smileyEncode ($f_data)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->smileyEncode (+f_data)- (#echo(__LINE__)#)"); }

		$f_return =& $f_data;

		if (!isset ($this->smilies_data))
		{
			$f_data_array = (file_exists ($direct_settings['path_data']."/settings/swg_smilies.xml") ? $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_smilies.xml") : NULL);
			if ($f_data_array) { $f_data_array = $this->smileyParseXmlTree ($f_data_array); }
			if ($f_data_array) { $this->smilies_data = $f_data_array; }
		}

		if ((!empty ($f_return))&&(!empty ($this->smilies_data)))
		{
			foreach ($this->smilies_data as $f_smiley_array)
			{
				foreach ($f_smiley_array['codes'] as $f_smiley)
				{
					$f_smiley_preg = preg_quote ($f_smiley);
					$f_return = preg_replace ("#( |\(|\)|\]|^)$f_smiley_preg( |\(|\)|\[|,|.|$)#m","\\1|{$f_smiley}|\\2",$f_return);
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->smileyEncode ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Converts an XML array tree into a smiley code array
	*
	* @param  array $f_xml_array Input XML array tree
	* @return string Filtered string
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */protected /* #*/function smileyParseXmlTree ($f_xml_array)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->smileyParseXmlTree (+f_xml_array)- (#echo(__LINE__)#)"); }
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

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -oHandler->smileyParseXmlTree ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Use this function to generate a warning to be displayed later on.
	*
	* @param  string $f_title Title
	* @param  string $f_text Short description
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function warning ($f_title,$f_text)
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->warning ($f_title,+f_text)- (#echo(__LINE__)#)"); }

		if ($direct_settings['swg_header_warnings']) { $this->outputHeader ("Warning","Warning: 199 sWG \"".(str_replace ('"','\"',$f_text))."\"",true,true); }
		else
		{
			$f_text = direct_html_encode_special (preg_replace ("#\[url:(.+?)\](.+?)[/url]#i","<a href=\"\\1\" target='_self'>\\2</a>",$f_text));
			$direct_cachedata['output_warning'][] = array ("title" => direct_html_encode_special ($f_title),"text" => $f_text);
		}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directOHandlerBasics",true);

//j// Script specific commands

global $direct_settings;
if (!isset ($direct_settings['swg_header_warnings'])) { $direct_settings['swg_header_warnings'] = true; }
if (!isset ($direct_settings['swg_pages_key_last'])) { $direct_settings['swg_pages_key_last'] = "&#0171;"; }
if (!isset ($direct_settings['swg_pages_key_next'])) { $direct_settings['swg_pages_key_next'] = "&#0187;"; }
if (!isset ($direct_settings['swg_pages_per_list'])) { $direct_settings['swg_pages_per_list'] = 6; }
if (!isset ($direct_settings['swg_path_related_data'])) { $direct_settings['swg_path_related_data'] = $direct_settings['path_data']."/related/"; }
if (!isset ($direct_settings['swg_options_image'])) { $direct_settings['swg_options_image'] = false; }
}

//j// EOF
?>