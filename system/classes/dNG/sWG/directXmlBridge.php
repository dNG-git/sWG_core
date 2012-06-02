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
* contains the "wrapper" for "ext_core/xml_reader.php".
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
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\directXmlReader;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directXmlBridge"))
{
/**
* This class provides a bridge between the sWG and XML to read XML on the fly.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage xml
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directXmlBridge extends directXmlReader
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directXmlBridge)
	*
	* @param boolean $f_parse_only Parse data only
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ($f_parse_only = true)
	{
		global $direct_cachedata,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -xml->__construct (directXmlBridge)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		if (isset ($direct_local['lang_charset'])) { parent::__construct ($direct_local['lang_charset'],$f_parse_only,$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),$direct_settings['path_system']."/classes/dNG",USE_debug_reporting); }
		else { parent::__construct ("UTF-8",$f_parse_only,$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),$direct_settings['path_system']."/classes/dNG",USE_debug_reporting); }
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directXmlBridge
	*
	* @param boolean $f_parse_only Parse data only
	* @since v0.1.03
*\/
	function directXmlBridge ($f_parse_only = true) { $this->__construct ($f_parse_only); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

global $direct_globals;
$direct_globals['@names']['xml_bridge'] = 'dNG\sWG\directXmlBridge';

define ("CLASS_directXmlBridge",true);
}

//j// EOF
?>