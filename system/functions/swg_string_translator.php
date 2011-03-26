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
* Translation tools for dynamic elements. 
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
* @uses       direct_product_iversion
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
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

//f// direct_string_translation ($f_module,$f_string)
/**
* Translates a given string into the user language or default one if possible.
*
* @param  string $f_module Module for available translation data
* @param  string $f_string String to translate
* @uses   direct_debug()
* @uses   direct_string_id_translation()
* @uses   USE_debug_reporting
* @return string Translated or original string
* @since  v0.1.01
*/
function direct_string_translation ($f_module,$f_string)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_string_translation ($f_module,+f_string)- (#echo(__LINE__)#)"); }

	$f_return = (($direct_settings['lang'] == "en") ? $f_string : direct_string_id_translation ($f_module,(md5 ($f_string))));
	if (!$f_return) { $f_return = $f_string; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_string_translation ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_string_id_translation ($f_module,$f_tid)
/**
* Returns a translation in the user or default language for the given ID.
*
* @param  string $f_module Module for available translation data
* @param  string $f_tid Translation identifier
* @uses   direct_basic_functions::memcache_get_file()
* @uses   direct_debug()
* @uses   direct_xml_bridge::xml2array()
* @uses   USE_debug_reporting
* @return mixed Translated string or false if it is not translatable
* @since  v0.1.03
*/
function direct_string_id_translation ($f_module,$f_tid)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_string_id_translation ($f_module,+f_tid)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['core_string_translator_files']))
	{
		$direct_cachedata['core_string_translator_data'] = array ();
		$direct_cachedata['core_string_translator_files'] = array ();
	}

	$f_module = preg_replace ("#[;\/\\\?:@\=\&\. \+]#i","",$f_module);
	$f_return = false;

	if (!isset ($direct_cachedata['core_string_translator_files'][$f_module]))
	{
		$direct_cachedata['core_string_translator_files'][$f_module] = true;

		if (file_exists ($direct_settings['path_data']."/lang/swg_{$f_module}.xml"))
		{
			$f_file_data = $direct_globals['basic_functions']->memcache_get_file ($direct_settings['path_data']."/lang/swg_{$f_module}.xml");
			if ($f_file_data) { $direct_cachedata['core_string_translator_data'][$f_module] = $direct_globals['xml_bridge']->xml2array ($f_file_data,false); }
		}
		else { $direct_cachedata['core_string_translator_data'][$f_module] = ""; }
	}

	if (!empty ($direct_cachedata['core_string_translator_data'][$f_module]))
	{
		reset ($direct_cachedata['core_string_translator_data'][$f_module]);
		$f_xml_node_array = each ($direct_cachedata['core_string_translator_data'][$f_module]);

		while ((!isset ($f_lang_result))&&($f_xml_node_array))
		{
			if (isset ($f_xml_node_array[1]['tag']))
			{
				if ((isset ($f_xml_node_array[1]['attributes']['tid']))&&($f_xml_node_array[1]['attributes']['tid'] == $f_tid))
				{
					if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$direct_settings['lang']}_") !== false) { $f_lang_result = $f_xml_node_array[1]['attributes']['translation']; }
					if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$direct_settings['swg_lang']}_") !== false) { $f_result_swg_lang = $f_xml_node_array[1]['attributes']['translation']; }
				}
			}
			elseif (isset ($f_xml_node_array[1][0]['tag']))
			{
				foreach ($f_xml_node_array[1] as $f_xml_sub_node_array)
				{
					if ((isset ($f_xml_sub_node_array['attributes']['tid']))&&($f_xml_sub_node_array['attributes']['tid'] == $f_tid))
					{
						if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$direct_settings['lang']}_") !== false) { $f_lang_result = $f_xml_sub_node_array['attributes']['translation']; }
						if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$direct_settings['swg_lang']}_") !== false) { $f_result_swg_lang = $f_xml_sub_node_array['attributes']['translation']; }
					}
				}
			}

			$f_xml_node_array = each ($direct_cachedata['core_string_translator_data'][$f_module]);
		}

		if (isset ($f_lang_result)) { $f_return = $f_lang_result; }
		elseif (isset ($f_result_swg_lang)) { $f_return = $f_result_swg_lang; }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_string_id_translation ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>