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
* OOP (Object Oriented Programming) requires an abstract data
* handling. The sWG is OO (where it makes sense).
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
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = ((defined ("CLASS_directActionParser")) ? false : true);
if (!defined ("CLASS_directVirtualClass")) { $g_continue_check = false; }

if ($g_continue_check)
{
/**
* The following class is our namespace for basic (inline) functions.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directActionParser extends directVirtualClass
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directActionParser)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->__construct (directActionParser)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['ilineParse'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directActionParser
	*
	* @since v0.1.01
*\/
	function directActionParser () { $this->__construct (); }
:#*/
/**
	* We are trying to catch all errors - even semi-fatal ones. For that reason
	* we provide the emergency mode function that does not require an active theme
	* or localiation strings to work.
	*
	* @param string $f_iline Input query string with ";" delimiter.
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public static /* #*/function ilineParse ($f_iline = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->ilineParse (+f_line)- (#echo(__LINE__)#)"); }

		if (!isset ($f_iline)) { $f_iline = (isset ($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : ""); }
		$f_iline_array = explode (";",$f_iline);
		$f_return = array ();

		foreach ($f_iline_array as $f_iline)
		{
			$f_value_array = explode ("=",$f_iline,2);

			if (count ($f_value_array) > 1) { $f_return[$f_value_array[0]] = $f_value_array[1]; }
			elseif (!isset ($f_return['ohandler'])) { $f_return['ohandler'] = preg_replace ("#\W#","",$f_iline); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->ilineParse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directActionParser",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['basic_functions'] = 'dNG\sWG\directActionParser';
}

//j// EOF
?>