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

$g_continue_check = ((defined ("CLASS_direct_icmd")) ? false : true);
if (($g_continue_check)&&(!defined ("CLASS_direct_input"))) { $g_continue_check = ($direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ihandler.php",1) ? defined ("CLASS_direct_input") : false); }

if ($g_continue_check)
{
//c// direct_icmd
/**
* "direct_icmd" fetches and provides input related data.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage input
* @uses       CLASS_direct_input
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_icmd extends direct_input
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_icmd->__construct () and direct_icmd->direct_icmd ()
/**
	* Constructor (PHP5) __construct (direct_icmd)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -input_class->__construct (direct_icmd)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Parse input line again but this time consider all $_SERVER['argv'] entries.
------------------------------------------------------------------------- */

		if ((isset ($_SERVER['argc']))&&($_SERVER['argc'] > 1))
		{
			$f_argv = $_SERVER['argv'];
			$f_iline = "";
			unset ($f_argv[0]);

			foreach ($f_argv as $f_argv_entry)
			{
				if (($f_argv_entry)&&($f_argv_entry != "-"))
				{
					if ($f_iline) { $f_iline .= ";"; }
					$f_iline .= $f_argv_entry;
				}
			}

			$f_variables = direct_basic_functions::iline_parse ($f_iline);
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
	* Constructor (PHP4) direct_icmd (direct_icmd)
	*
	* @since v0.1.08
*\/
	function direct_icmd () { $this->__construct (); }
:#*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['input'] = "direct_icmd";
define ("CLASS_direct_icmd",true);
}

//j// EOF
?>