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
* The "input" generic handler specify all get/set functions as well as
* variables for later use.
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

if (!defined ("CLASS_direct_input"))
{
//c// direct_ihttp
/**
* The "direct_ihandler" is mainly an interface specification.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage input
* @uses       CLASS_direct_virtual_class
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_input extends direct_virtual_class
{
/**
	* @var string $method HTTP (like) method
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $auth;
/**
	* @var string $method HTTP (like) method
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $method;
/**
	* @var string $pass Password
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $pass;
/**
	* @var string $user User name
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $user;
/**
	* @var string $uuid UUID
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $uuid;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_input->__construct () and direct_input->direct_input ()
/**
	* Constructor (PHP5) __construct (direct_input)
	*
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -input_class->__construct (direct_input)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['auth_get'] = true;
		$this->functions['pass_get'] = true;
		$this->functions['uuid_get'] = true;
		$this->functions['uuid_set'] = true;
		$this->functions['user_get'] = true;
		$this->functions['user_set'] = true;

/* -------------------------------------------------------------------------
Set protocol specific data
------------------------------------------------------------------------- */

		$direct_settings['dsd'] = $direct_classes['basic_functions']->dsd_parse ($direct_settings['dsd']);
		$direct_settings['swg_clientsupport'] = array ();

		$this->auth = NULL;
		$this->pass = NULL;
		$this->user = "";
		$this->uuid = NULL;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_input (direct_input)
	*
	* @since v0.1.08
*\/
	function direct_input () { $this->__construct (); }
:#*/
	//f// direct_input->auth_get ()
/**
	* Return the authentification protocol identified through protocol specific
	* ways.
	*
	* @return mixed String if identified; NULL if not
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function auth_get () { return $this->auth; }

	//f// direct_input->pass_get ()
/**
	* Return a password identified through protocol specific ways.
	*
	* @return mixed String if identified; NULL if not
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function pass_get () { return $this->pass; }

	//f// direct_input->uuid_get ()
/**
	* Return a UUID identified through protocol specific ways.
	*
	* @return mixed String if identified; NULL if not
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_get () { return $this->uuid; }

	//f// direct_input->uuid_set ($f_uuid)
/**
	* Set the defined UUID.
	*
	* @param string $f_uuid UUID
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function uuid_set ($f_uuid)
	{
		global $direct_settings;
		$direct_settings['uuid'] = $f_uuid;
		$this->uuid = $f_uuid;
	}

	//f// direct_input->user_get ()
/**
	* Return a user name identified through protocol specific ways.
	*
	* @return string User name used by the system or sent by the browser
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function user_get () { return $this->user; }

	//f// direct_input->user_set ($f_user)
/**
	* Set the defined user name.
	*
	* @param string $f_user User name
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function user_set ($f_user)
	{
		global $direct_settings;

		if (isset ($f_user))
		{
			$direct_settings['user']['name'] = $f_user;
			$direct_settings['user']['name_html'] = direct_html_encode_special ($f_user);
			$this->user = $f_user;
		}
		else { $this->user = ""; }
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_direct_input",true);
}

//j// EOF
?>