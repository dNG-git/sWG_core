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
$Id: swg_subkernel.php,v 1.11 2008/11/04 11:08:37 s4u Exp $
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* Subkernel for: default
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

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_subkernel_default"))
{
//c// direct_subkernel_default
/**
* Subkernel for: default
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage default
* @uses       CLASS_direct_virtual_class
* @since      v0.1.05
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_subkernel_default extends direct_virtual_class
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_subkernel_default->__construct () and direct_subkernel_default->direct_subkernel_default ()
/**
	* Constructor (PHP5) __construct (direct_subkernel_default)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->__construct (direct_subkernel_default)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about the available function
------------------------------------------------------------------------- */

		$this->functions['subkernel_init'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_subkernel_default (direct_subkernel_default)
	*
	* @since v0.1.05
*\/
	function direct_subkernel_default () { $this->__construct (); }
:#*/
	//f// direct_subkernel_default->subkernel_init ($f_threshold_id = "")
/**
	* Running subkernel specific checkups.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout).
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return array Returned array contains error details if applicable
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function subkernel_init ($f_threshold_id = "")
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ($f_threshold_id)- (#echo(__LINE__)#)"); }

		if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_output.php",1)) { $f_return = array (); }
		else { $f_return = array ("errors_core_required_object_not_found","FATAL ERROR:<br />&quot;$direct_settings[path_system]/classes/swg_output.php&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)"); }

		$direct_classes['kernel']->v_user_init ($f_threshold_id);
		$direct_classes['kernel']->v_group_init ();

		if (defined ("CLASS_direct_output_control")) { direct_output_theme ($direct_settings['theme']); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['subkernel_default'] = "direct_subkernel_default";
define ("CLASS_direct_subkernel_default",true);

//j// Script specific commands

direct_class_init ("subkernel_default");
$direct_classes['kernel']->v_call_set ("v_subkernel_init",$direct_classes['subkernel_default'],"subkernel_init");
}

//j// EOF
?>