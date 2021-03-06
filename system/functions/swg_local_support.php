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
* Localisation is an important feature - for international companies and open
* communities. The following functions provide this support.
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
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Functions and classes

/**
* This function is used to provide a localised data.
*
* @param  string $f_string_id String identifier
* @param  string $f_handling Presentation to use ("html" / "text")
* @return string Translated output string or " $f_string_id "
* @since  v0.1.05
*/
function direct_local_get ($f_string_id,$f_handling = "html")
{
	global $direct_local,$direct_settings;

	if ($direct_settings['swg_force_local_handling']) { $f_handling = $direct_settings['swg_force_local_handling']; }
	$f_return = " $f_string_id ";

	if ($f_handling == "html")
	{
		if (isset ($direct_local[$f_string_id."_html"])) { $f_return = $direct_local[$f_string_id."_html"]; }
		elseif (isset ($direct_local[$f_string_id."_universal"])) { $f_return = $direct_local[$f_string_id."_universal"]; }
	}
	else
	{
		if (isset ($direct_local[$f_string_id."_universal"])) { $f_return = $direct_local[$f_string_id."_universal"]; }
		elseif (isset ($direct_local[$f_string_id."_text"])) { $f_return = $direct_local[$f_string_id."_text"]; }

		if ($f_handling == "text_quoted") { $f_return = str_replace ('"','\"',$f_return); }
	}

	return $f_return;
}

/**
* Parses a XML node splitting its content into a "@global" English and
* multiple additional language elements.
*
* @param  array &$f_xml_node_array XML node
* @param  string $f_tag Translation tag identifier
* @param  boolean $f_extract_string Return the result as a string.
* @param  string $f_extract_language Language tag to be extracted - returns
*         only one array element with the translated or "@global" text as
*         "$return[$f_extract_language]".
* @return mixed Array with all extracted languages (plus "@global" for
*         English) or string (if $f_extract_string is true)
* @since  v0.1.07
*/
function direct_local_get_xml_translation (&$f_xml_node_array,$f_tag,$f_extract_string = false,$f_extract_language = "")
{
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_local_get_xml_translation (+f_xml_node_array,$f_tag,+f_extract_string,$f_extract_language)- (#echo(__LINE__)#)"); }
	$f_return = ($f_extract_string ? "" : array ());

	if ((is_array ($f_xml_node_array))&&(is_string ($f_tag)))
	{
		$f_node_array = NULL;

		if (isset ($f_xml_node_array[$f_tag]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array[$f_tag]['xml.item'])) { $f_node_array = $f_xml_node_array[$f_tag]; }
		elseif (isset ($f_xml_node_array['xml.item']))
		{
			foreach ($f_xml_node_array as $f_xml_sub_node_array)
			{
				if ((!isset ($f_node_array))&&(is_string ($f_xml_sub_node_array['tag']))&&($f_xml_sub_node_array['tag'] == $f_tag)) { $f_node_array = array ($f_xml_sub_node_array); }
			}
		}
		elseif (isset ($f_xml_node_array['tag']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['value'])) { $f_node_array = array ($f_xml_node_array); }

		if (is_array ($f_node_array))
		{
			if (isset ($f_node_array['xml.item']))
			{
				if (strlen ($f_node_array['xml.item']['value'])) { $f_return['@global'] = $f_node_array['xml.item']['value']; }
				unset ($f_node_array['xml.item']);
			}

			foreach ($f_node_array as $f_xml_sub_node_array)
			{
				if ((isset ($f_xml_sub_node_array['attributes']['language']))&&(strlen ($f_xml_sub_node_array['value'])))
				{
					if (isset ($f_return[$f_xml_sub_node_array['attributes']['language']])) { $f_return[$f_xml_sub_node_array['attributes']['language']] .= "\n".$f_xml_sub_node_array['value']; }
					else { $f_return[$f_xml_sub_node_array['attributes']['language']] = $f_xml_sub_node_array['value']; }
				}
				elseif ((isset ($f_xml_sub_node_array['value']))&&(strlen ($f_xml_sub_node_array['value'])))
				{
					if (isset ($f_return['@global'])) { $f_return['@global'] .= "\n".$f_xml_sub_node_array['value']; }
					else { $f_return['@global'] = $f_xml_sub_node_array['value']; }
				}
			}

			if (strlen ($f_extract_language))
			{
				if ($f_extract_string) { $f_return = (isset ($f_return[$f_extract_language]) ? $f_return[$f_extract_language] : $f_return['@global']); }
				else { $f_return = (isset ($f_return[$f_extract_language]) ? array ($f_extract_language => $f_return[$f_extract_language]) : array ($f_extract_language => $f_return['@global'])); }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_local_get_xml_translation ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Integrate a translation module into the current program context.
*
* @param  string $f_module Translation module
* @param  string $f_dlang Default language which should always be available
* @param  boolean $f_force True to overwrite already loaded modules
* @return boolean True on successful inclusion
* @since  v0.1.03
*/
function direct_local_integration ($f_module,$f_dlang = "en",$f_force = false,$f_lang_forced = NULL)
{
	global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_local_integration ($f_module,$f_dlang,+f_force,+f_lang_forced)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['core_local_integration_modules'])) { $direct_cachedata['core_local_integration_modules'] = array (); }

	$f_lang = ((isset ($f_lang_forced)) ? $f_lang_forced : $direct_settings['lang']);
	$f_module = preg_replace ("#\W#i","",$f_module);
	$f_return = false;

	if ((!isset ($direct_cachedata['core_local_integration_modules'][$f_module]))||($f_force))
	{
		$direct_cachedata['core_local_integration_modules'][$f_module] = true;

		if (file_exists ($direct_settings['path_lang']."/swg_$f_module.$f_lang.xml")) { $f_xml_array = $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_lang']."/swg_$f_module.$f_lang.xml"); }
		elseif (file_exists ($direct_settings['path_lang']."/swg_$f_module.{$direct_settings['swg_lang']}.xml")) { $f_xml_array = $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_lang']."/swg_$f_module.{$direct_settings['swg_lang']}.xml"); }
		else { $f_xml_array = $direct_globals['basic_functions']->memcacheGetFileMergedXml ($direct_settings['path_lang']."/swg_$f_module.$f_dlang.xml"); }

		if (!empty ($f_xml_array))
		{
			$f_return = true;

			foreach ($f_xml_array as $f_key => $f_xml_node_array)
			{
				$f_key = preg_replace ("#^swg_lang_file_v1_#","",$f_key);
				$direct_local[$f_key] = $f_xml_node_array['value'];
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_local_integration ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>