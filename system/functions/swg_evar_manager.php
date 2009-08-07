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
* evars (Extended variables) are our answer for dynamic data in (for example)
* SQL log tables.
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
* @since      v0.1.02
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

//f// direct_evars_get ($f_data)
/**
* To receive all data (key-value pairs) from evars, use "direct_evars_get ()".
* This function needs for its recursive job a helper function.
*
* @param  string $f_data Internally evars are XML strings containing
*         base64-encoded data if chosen (for binary content).
* @uses   direct_debug()
* @uses   direct_evars_get_walker()
* @uses   direct_xml_bridge::xml2array()
* @uses   USE_debug_reporting
* @return array Key-value pair array
* @since  v0.1.01
*/
function direct_evars_get ($f_data)
{
	global $direct_classes;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evars_get (+f_data)- (#echo(__LINE__)#)"); }

	$f_data = trim ($f_data);
	$f_return = array ();

	if (preg_match ("#<evars>(.+?)</evars>#si",$f_data,$f_result_array))
	{
		$f_result_array = $direct_classes['xml_bridge']->xml2array ($f_result_array[0],true,false);

		if (isset ($f_result_array['evars']))
		{
			$f_result_array = direct_evars_get_walker ($f_result_array['evars']);
			if (!empty ($f_result_array)) { $f_return = $f_result_array; }
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_evars_get_walker ($f_xml_array)
/**
* This is a helper function for "direct_evars_get ()" to convert an XML array
* recursively.
*
* @param  array $f_xml_array XML nodes in a specific level.
* @uses   direct_debug()
* @uses   direct_evars_get_walker()
* @uses   USE_debug_reporting
* @return array Key-value pair array
* @since  v0.1.03
*/
function direct_evars_get_walker ($f_xml_array)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_evars_get_walker (+f_xml_array)- (#echo(__LINE__)#)"); }

	$f_return = array ();

	if (is_array ($f_xml_array))
	{
		if (isset ($f_xml_array['xml.item'])) { unset ($f_xml_array['xml.item']); }

		if (!empty ($f_xml_array))
		{
			foreach ($f_xml_array as $f_key => $f_xml_node_array)
			{
				if (isset ($f_xml_node_array['xml.item'])) { $f_return[$f_key] = direct_evars_get_walker ($f_xml_node_array); }
				elseif (strlen ($f_xml_node_array['tag'])) { $f_return[$f_xml_node_array['tag']] = (isset ($f_xml_node_array['attributes']['base64']) ? base64_decode ($f_xml_node_array['value']) : $f_xml_node_array['value']); }
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_get_walker ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_evars_write ($f_data,$f_binary_safe = false)
/**
* To save all data from $f_data as an evars-string, call
* "direct_evars_write ()". The helper function will encode relevant data with
* base64_encode if applicable.
*
* @param  array $f_data Input array
* @param  boolean $f_binary_safe True to encode values with base64.
* @uses   direct_debug()
* @uses   direct_evars_write_base64_walker()
* @uses   direct_xml_bridge::array2xml()
* @uses   direct_xml_bridge::array_import()
* @uses   direct_xml_bridge::cache_export()
* @uses   direct_xml_bridge::get()
* @uses   USE_debug_reporting
* @return string XML string
* @since  v0.1.01
*/
function direct_evars_write ($f_data,$f_binary_safe = false)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evars_write (+f_data,+f_binary_safe)- (#echo(__LINE__)#)"); }

	$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_xml.php",2);
	$f_return = "";

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		$f_data = array ("evars" => $f_data);

		$f_xml_object = new direct_xml ();
		$f_xml_object->array_import ($f_data,true);

		if ($f_binary_safe)
		{
			$f_data = direct_evars_write_base64_walker ($f_xml_object->get ());
			$f_return = $f_xml_object->array2xml ($f_data,false);
		}
		else { $f_return = $f_xml_object->cache_export (true); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_evars_write_base64_walker ($f_data)
/**
* This recursive function is used to protect binary data in a system optimized
* for strings.
*
* @param  array $f_data Input array
* @uses   direct_debug()
* @uses   direct_evars_write_base64_walker()
* @uses   USE_debug_reporting
* @return array Output array (base64-encoded values if required)
* @since  v0.1.03
*/
function direct_evars_write_base64_walker ($f_data)
{
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_evars_write_base64_walker (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = array ();

	if ((is_array ($f_data))&&(!empty ($f_data)))
	{
		foreach ($f_data as $f_key => $f_node_array)
		{
			if (isset ($f_node_array['xml.item'])) { $f_return[$f_key] = direct_evars_write_base64_walker ($f_node_array); }
			elseif (strlen ($f_node_array['tag']))
			{
				if (preg_match ("#\W#",$f_node_array['value']))
				{
					$f_node_array['attributes'] = array ("base64" => 1);
					$f_node_array['value'] = base64_encode ($f_node_array['value']);
				}

				$f_return[$f_key] = $f_node_array;
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_write_base64_walker ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// EOF
?>