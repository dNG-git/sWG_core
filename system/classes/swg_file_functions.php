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
* This is a "wrapper" file including "ext_core/file.php" automatically.
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

$g_continue_check = ((defined ("CLASS_direct_file_functions")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_file"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/ext_core/file.php",1) ? defined ("CLASS_direct_file") : false); }

if ($g_continue_check)
{
/**
* This wrapper class extends "ext_core/file.php" and sets our default
* parameters.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @uses       CLASS_direct_file
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_file_functions extends direct_file
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (direct_file_functions)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -file_functions_class->__construct (direct_file_functions)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ($direct_settings['swg_umask_change'],$direct_settings['swg_chmod_files_change'],$direct_cachedata['core_time'],($direct_settings['timeout'] + $direct_settings['timeout_core']),USE_debug_reporting);
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_file_functions (direct_file_functions)
	*
	* @since v0.1.03
*\/
	function direct_file_functions () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_file_functions",true);
}

//j// EOF
?>