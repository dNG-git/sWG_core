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

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

if (!defined ("CLASS_direct_data_handler"))
{
//c// direct_data_handler
/**
* This is an abstract data holder doing nothing.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @uses       CLASS_direct_virtual_class
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_data_handler extends direct_virtual_class
{
/**
	* @var mixed $data Container for class-wide usable data
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $data;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_data_handler->__construct () and direct_data_handler->direct_data_handler ()
/**
	* Constructor (PHP5) __construct (direct_data_handler)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -data_handler->__construct (direct_data_handler)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['get'] = true;
		$this->functions['set'] = true;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_data_handler (direct_data_handler)
	*
	* @since v0.1.03
*\/
	function direct_data_handler () { $this->__construct (); }
:#\n*/
	//f// direct_data_handler->__destruct ()
/**
	* Destructor (PHP5) __destruct (direct_data_handler)
	*
	* @since v0.1.07
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { $this->data = NULL; }

	//f// direct_data_handler->get ()
/**
	* This operation just gives back the content of $this->data.
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return mixed Returns the saved data
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function get ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -data_handler->get ()- (#echo(__LINE__)#)"); }
		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -data_handler->get ()- (#echo(__LINE__)#)",:#*/(isset ($this->data) ? $this->data : false)/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_data_handler->get ()
/**
	* This operation fills $this->data with $f_data.
	*
	* @param mixed $f_data Data to be saved
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function set ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -data_handler->set (+f_data)- (#echo(__LINE__)#)"); }
		$this->data = $f_data;
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_data_handler",true);
}

//j// EOF
?>