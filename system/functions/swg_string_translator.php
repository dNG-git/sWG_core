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

/**
* Translates a given string into the user language or default one if possible.
*
* @param  string $f_module Module for available translation data
* @param  string $f_string String to translate
* @param  boolean $f_string_is_en True if given string is the English translation
* @return string Translated or original string
* @since  v0.1.01
*/
function direct_string_translation ($f_module,$f_string,$f_string_is_en = true,$f_lang = NULL)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_string_translation ($f_module,+f_string,+f_string_is_en,+f_lang)- (#echo(__LINE__)#)"); }

	if (!isset ($f_lang)) { $f_lang = $direct_settings['lang']; }
	$f_return = ((($f_string_is_en)&&($f_lang == "en")) ? $f_string : direct_string_id_translation ($f_module,(md5 ($f_string)),$f_lang));
	if (!$f_return) { $f_return = $f_string; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_string_translation ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Returns a translation in the user or default language for the given ID.
*
* @param  string $f_module Module for available translation data
* @param  string $f_tid Translation identifier
* @return mixed Translated string or false if it is not translatable
* @since  v0.1.03
*/
function direct_string_id_translation ($f_module,$f_tid,$f_lang = NULL)
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_string_id_translation ($f_module,+f_tid,+f_lang)- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['core_string_translator_files']))
	{
		$direct_cachedata['core_string_translator_data'] = array ();
		$direct_cachedata['core_string_translator_files'] = array ();
	}

	if (!isset ($f_lang)) { $f_lang = $direct_settings['lang']; }
	$f_module = preg_replace ("#[;\/\\\?:@\=\&\. \+]#i","",$f_module);
	$f_return = false;

	if (!isset ($direct_cachedata['core_string_translator_files'][$f_module]))
	{
		$direct_cachedata['core_string_translator_files'][$f_module] = true;

		if (file_exists ($direct_settings['path_data']."/lang/swg_{$f_module}.xml"))
		{
			$f_file_data = $direct_globals['basic_functions']->memcacheGetFile ($direct_settings['path_data']."/lang/swg_{$f_module}.xml");
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
					if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$f_lang}_") !== false) { $f_lang_result = $f_xml_node_array[1]['attributes']['translation']; }
					if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$direct_settings['swg_lang']}_") !== false) { $f_result_swg_lang = $f_xml_node_array[1]['attributes']['translation']; }
				}
			}
			elseif (isset ($f_xml_node_array[1][0]['tag']))
			{
				foreach ($f_xml_node_array[1] as $f_xml_sub_node_array)
				{
					if ((isset ($f_xml_sub_node_array['attributes']['tid']))&&($f_xml_sub_node_array['attributes']['tid'] == $f_tid))
					{
						if (strpos ($f_xml_node_array[0],"swg_lang_file_v1_{$f_lang}_") !== false) { $f_lang_result = $f_xml_sub_node_array['attributes']['translation']; }
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