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
* developer/swg_build_stage2.php
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
* @subpackage developer
* @uses       direct_product_iversion
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Expires: ".(gmdate ("D, d M Y H:i:s",($direct_cachedata['core_time'] - 2419200)))." GMT");
header ("Last-Modified: ".(gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']))." GMT");
header ("Content-Type: text/plain; charset=ISO-8859-1");

/* -------------------------------------------------------------------------
Print out a welcome header
------------------------------------------------------------------------- */

echo ("
----------------------------------------------------------------------------
(C) $direct_settings[swg_title_txt] (Stage 2 Builder)
All rights reserved
----------------------------------------------------------------------------
This tool should be used by sWG basic developers only. If you are not a
developer for basic components, please download a sWG basic package provided
by the direct Netware Group.

Thank you for using the secured WebGine!
----------------------------------------------------------------------------
");

/* -------------------------------------------------------------------------
Check for a developer version of the sWG.
------------------------------------------------------------------------- */

$g_continue_check = ((($direct_settings['ihandler'] == "cmd")&&(file_exists ("_developer"))&&(is_dir ("_developer"))) ? true : false);

if (!$direct_globals['kernel']->service_init_rboolean ()) { $g_continue_check = false; }
if (!file_exists ("swg.php")) { $g_continue_check = false; }
if (!file_exists ("_developer/README")) { $g_continue_check = false; }

if ($g_continue_check)
{
/* -------------------------------------------------------------------------
Test for data/settings/swg_build_targets.php and load the XML tree
------------------------------------------------------------------------- */

	$g_continue_check = false;
	$g_profile = (isset ($GLOBALS['i_profile']) ? "_".($direct_globals['basic_functions']->inputfilter_filepath ($GLOBALS['i_profile'])) : "");

	if (file_exists ($direct_settings['path_data']."/settings/swg_build_targets{$g_profile}.php"))
	{
		$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/settings/swg_build_targets{$g_profile}.php");

		if ($g_file_data)
		{
			$g_xml_node_array = $direct_globals['xml_bridge']->xml2array ($g_file_data,true,false);
			$g_file_data = NULL;

			if (is_array ($g_xml_node_array))
			{
				if (isset ($g_xml_node_array['swg_build_file_v1']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_xml_node_array['swg_build_file_v1']['stage2']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_xml_node_array['swg_build_file_v1']['stage2']['xml.item']['attributes']['source']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$g_xml_node_array['swg_build_file_v1']['stage2']['xml.item']['attributes']['swgversion']))
				{
					$g_xml_node_array = $g_xml_node_array['swg_build_file_v1']['stage2'];

					$g_swg_version = $g_xml_node_array['xml.item']['attributes']['swgversion'];
					$g_swg_iversion = $g_xml_node_array['xml.item']['attributes']['swgiversion'];
					$g_source_path = $g_xml_node_array['xml.item']['attributes']['source'];

					$g_continue_check = true;
				}
			}
		}
	}

/* -------------------------------------------------------------------------
Include all required files for later use
------------------------------------------------------------------------- */

	if (!$direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_dir_functions.php")) { $g_continue_check = false; }
	if (!$direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_developer_builder.php")) { $g_continue_check = false; }
	$g_builder_object = ((($g_continue_check)&&($g_source_path)) ? new direct_developer_builder () : NULL);

/* -------------------------------------------------------------------------
Scans the target definitions and checks for writable directories.
------------------------------------------------------------------------- */

	if (($g_builder_object)&&($g_builder_object->target_check ($g_xml_node_array)))
	{
		$g_xml_node_array = NULL;

/* -------------------------------------------------------------------------
Read, change and save the source code files to the target directories.
Generate a data/settings/swg_packages_installed.php for each target after
completion. 
------------------------------------------------------------------------- */

		$g_builder_object->add_filetype_ascii ("css");
		$g_builder_object->set_exclude_dirs ("_developer,_extras,nbproject");
		$g_builder_object->set_exclude_files ("INSTALL,CHANGELOG,NEWS,FAQ,LICENSE,build.xml,data/settings/nim/swg_nim_runonce.xml");
		$g_builder_object->set_strip_prefix ($g_source_path);
		$g_builder_object->set_target_metadata ("basic","swg_basic",2,$g_swg_version,$g_swg_iversion);

		if ($g_builder_object->set_include ($g_source_path)) { $g_builder_object->make_all (); }
		else { echo "\n> Error: No valid files found for parsing"; }
	}
	elseif ($g_builder_object) { echo "\n> Fatal Error: No suitable targets found"; }
	else { echo "\n> Fatal Error: Unable to open all required modules and files"; }
}
else { echo "\n> Fatal Error: This seems not to be a developer version of the sWG - exiting"; }

echo "\n";
$direct_cachedata['core_service_activated'] = true;

//j// EOF
?>