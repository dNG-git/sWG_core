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
sWGcoreVersion
sWG/system/modules/default/swg_sysm.php
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* default/swg_sysm.php
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
* @subpackage default
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

//j// Script specific commands

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "unknown"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "merror"
case "merror":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/system/modules/default/swg_sysm.php _a=merror_ (63)"); }

	$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/modules/default/swgi_custom_merror.php");
	break 1;
}
//j// $direct_settings['a'] == "munconfigured"
case "munconfigured":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/system/modules/default/swg_sysm.php _a=munconfigured_ (71)"); }

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "m=cp";
	$direct_cachedata['page_homelink'] = "m=cp";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['output']->output_send_error ("login","core_unconfigured","sWG/system/modules/default/swg_sysm.php _a=munconfigured_ (80)");
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// $direct_settings['a'] == "unknown"
case "unknown":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/system/modules/default/swg_sysm.php _a=unknown_ (90)"); }

	$direct_cachedata['page_this'] = "";
	$direct_cachedata['page_backlink'] = "";
	$direct_cachedata['page_homelink'] = "";

	if ($direct_classes['kernel']->service_init_default ())
	{
	//j// BOA
	$direct_classes['output']->output_send_error ("standard","core_unknown_error","FATAL ERROR:<br />Request terminated<br />sWG/system/modules/default/swg_sysm.php _a=unknown_ (99)");
	//j// EOA
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>