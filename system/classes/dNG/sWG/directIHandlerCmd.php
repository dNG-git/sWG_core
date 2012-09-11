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
* There are several tools to create new output easily. Here you will find most
* of them (including methods from direct_output_inline).
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
* @subpackage input
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #*/
/*#use(direct_use) */
use dNG\sWG\directIHandlerBasics;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directIHandlerCmd"))
{
/**
* "directIHandlerCmd" fetches and provides input related data.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage input
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directIHandlerCmd extends directIHandlerBasics
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directIHandlerCmd)
	*
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -iHandler->__construct (directIHandlerCmd)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Parse input line again but this time consider all $_SERVER['argv'] entries.
------------------------------------------------------------------------- */

		if ((isset ($_SERVER['argc']))&&($_SERVER['argc'] > 1))
		{
			$f_argv = $_SERVER['argv'];
			$f_iline = "";

			$direct_settings['iscript_req'] = $f_argv[0];
			unset ($f_argv[0]);

			foreach ($f_argv as $f_argv_entry)
			{
				if (($f_argv_entry)&&($f_argv_entry != "-"))
				{
					if ($f_iline) { $f_iline .= ";"; }
					$f_iline .= $f_argv_entry;
				}
			}

			$f_variables = directBasicfunctions::ilineParse ($f_iline);
			$direct_settings['dsd'] = (isset ($f_variables['dsd']) ? $f_variables['dsd'] : "");
		}
		else
		{
			$direct_settings['dsd'] = "";
			$f_variables = array ();
		}

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Set protocol specific data
------------------------------------------------------------------------- */

		$direct_settings['user_ip'] = "unknown";
		$direct_settings['user_ip_name'] = "unknown";

		$this->method = "GET";
		$this->pass = (isset ($f_variables['pass']) ? $f_variables['pass'] : NULL);
		$this->uuid = (isset ($f_variables['uuid']) ? $f_variables['uuid'] : NULL);
		$this->user = (isset ($f_variables['user']) ? $f_variables['user'] : NULL);
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directIHandlerCmd
	*
	* @since v0.1.08
*\/
	function directIHandlerCmd () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directIHandlerCmd",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['input'] = 'dNG\sWG\directIHandlerCmd';
}

//j// EOF
?>