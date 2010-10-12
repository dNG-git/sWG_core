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
* XML (Extensible Markup Language) is the easiest way to use a descriptive
* language for controlling applications locally and world wide. This file
* contains the "wrapper" for "ext_core/xml_writer.php".
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
* @subpackage xml
* @since      v0.1.05
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

$g_continue_check = ((defined ("CLASS_direct_xml")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_xml_reader"))) { $g_continue_check = ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_core/xml_reader.php",1) ? defined ("CLASS_direct_xml_reader") : false); }
if (($g_continue_check)&&(!defined ("CLASS_direct_xml_writer"))) { $g_continue_check = ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_core/xml_writer.php",1) ? defined ("CLASS_direct_xml_writer") : false); }

if ($g_continue_check)
{
//c// direct_xml
/**
* This class extends the bridge between the sWG and XML to work with XML and
* create valid documents.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage xml
* @uses       CLASS_direct_xml_writer
* @since      v0.1.05
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_xml extends direct_xml_writer
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_xml->__construct () and direct_xml->direct_xml ()
/**
	* Constructor (PHP5) __construct (direct_xml)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_cachedata,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -xml_handler->__construct (direct_xml)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		if (isset ($direct_local['lang_charset'])) { parent::__construct ($direct_local['lang_charset'],$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),$direct_settings['path_system']."/classes/ext_core",USE_debug_reporting); }
		else { parent::__construct ("UTF-8",$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),$direct_settings['path_system']."/classes/ext_core",USE_debug_reporting); }
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_xml (direct_xml)
	*
	* @since v0.1.03
*\/
	function direct_xml () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_xml",true);
}

//j// EOF
?>