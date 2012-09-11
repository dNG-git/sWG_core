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
* @since      v0.1.02
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directXml;

/* #\n*/
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
* To receive all data (key-value pairs) from evars, use "direct_evars_get ()".
* This function needs for its recursive job a helper function.
*
* @param  string $f_data Internally evars are XML strings containing
*         base64-encoded data if chosen (for binary content).
* @return array Key-value pair array
* @since  v0.1.01
*/
function direct_evars_get ($f_data)
{
	global $direct_globals;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evars_get (+f_data)- (#echo(__LINE__)#)"); }

	$f_return = array ();

	$f_data = $direct_globals['xml_bridge']->xml2array (trim ($f_data),true,false);

	if (($f_data)&&(isset ($f_data['evars'])))
	{
		$f_data = direct_evars_get_walker ($f_data['evars']);
		if (!empty ($f_data)) { $f_return = $f_data; }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_get ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* This is a helper function for "direct_evars_get ()" to convert an XML array
* recursively.
*
* @param  array $f_xml_array XML nodes in a specific level.
* @return array Key-value pair array
* @since  v0.1.03
*/
function direct_evars_get_walker ($f_xml_array)
{
	$f_return = array ();

	if (is_array ($f_xml_array))
	{
		if (isset ($f_xml_array['xml.item'])) { unset ($f_xml_array['xml.item']); }
		$f_mtree = isset ($f_xml_array['xml.mtree']);
		if ($f_mtree) { unset ($f_xml_array['xml.mtree']); }

		if (!empty ($f_xml_array))
		{
			foreach ($f_xml_array as $f_key => $f_xml_node_array)
			{
				if ((isset ($f_xml_node_array['xml.item']))||(isset ($f_xml_node_array['xml.mtree']))) { $f_return[$f_key] = direct_evars_get_walker ($f_xml_node_array); }
				elseif (strlen ($f_xml_node_array['tag']))
				{
					if ($f_mtree) { $f_return[] = (isset ($f_xml_node_array['attributes'],$f_xml_node_array['attributes']['base64']) ? base64_decode ($f_xml_node_array['value']) : $f_xml_node_array['value']); }
					else { $f_return[$f_xml_node_array['tag']] = (isset ($f_xml_node_array['attributes'],$f_xml_node_array['attributes']['base64']) ? base64_decode ($f_xml_node_array['value']) : $f_xml_node_array['value']); }
				}
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_get_walker ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* To save all data from $f_data as an evars-string, call
* "direct_evars_write ()". The helper function will encode relevant data with
* base64_encode if applicable.
*
* @param  array $f_data Input array
* @param  boolean $f_binary_safe True to encode values with base64.
* @return string XML string
* @since  v0.1.01
*/
function direct_evars_write ($f_data_array,$f_binary_safe = false)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_evars_write (+f_data,+f_binary_safe)- (#echo(__LINE__)#)"); }

	$f_return = "";

	if ((is_array ($f_data_array))&&(!empty ($f_data_array)))
	{
		$f_data_array = array ("evars" => $f_data_array);

		$f_xml_object = new directXml ();
		$f_xml_object->arrayImport ($f_data_array,true);

		if ($f_binary_safe)
		{
			$f_data_array = direct_evars_write_base64_walker ($f_xml_object->get ());
			$f_return = $f_xml_object->array2xml ($f_data_array,false);
		}
		else { $f_return = $f_xml_object->cacheExport (true); }
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_evars_write ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* This recursive function is used to protect binary data in a system optimized
* for strings.
*
* @param  array $f_data_array Input array
* @return array Output array (base64-encoded values if required)
* @since  v0.1.03
*/
function direct_evars_write_base64_walker ($f_data_array)
{
	$f_return = array ();

	if ((is_array ($f_data_array))&&(!empty ($f_data_array)))
	{
		foreach ($f_data_array as $f_key => $f_node_array)
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