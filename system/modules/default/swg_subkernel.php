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
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directVirtualClass;
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

if (!defined ("CLASS_directSubkernelDefault"))
{
/**
* Subkernel for: default
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage default
* @since      v0.1.05
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directSubkernelDefault extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directSubkernelDefault)
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directSubkernelDefault)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about the available function
------------------------------------------------------------------------- */

		$this->functions['subkernelInit'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directSubkernelDefault
	*
	* @since v0.1.05
*\/
	function directSubkernelDefault () { $this->__construct (); }
:#*/
/**
	* Running subkernel specific checkups.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout).
	* @return array Returned array contains error details if applicable
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function subkernelInit ($f_threshold_id = "")
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (2,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$direct_globals['kernel']->vUserInit ($f_threshold_id);
		$direct_globals['kernel']->vGroupInit ();

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->subkernelInit ()- (#echo(__LINE__)#)",(:#*/array ()/*#ifdef(DEBUG):),true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directSubkernelDefault",true);

//j// Script specific commands

$direct_globals['@names']['subkernel_default'] = 'directSubkernelDefault';

direct_class_init ("subkernel_default");
$direct_globals['kernel']->vCallSet ("vSubkernelInit",$direct_globals['subkernel_default'],"subkernelInit");
}

//j// EOF
?>