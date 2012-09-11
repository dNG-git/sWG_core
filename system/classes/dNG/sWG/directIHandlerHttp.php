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
* Input handlers fetch data based in a protocol specific manner.
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

if (!defined ("CLASS_directIHandlerHttp"))
{
/**
* "directIHandlerHttp" fetches and provides input related data for a HTTP
* conenction.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage input
* @since      v0.1.08
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directIHandlerHttp extends directIHandlerBasics
{
/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directIHandlerHttp)
	*
	* @param string $f_iline Input query string with ";" delimiter.
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ($f_iline = NULL)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -iHandler->__construct (directIHandlerHttp)- (#echo(__LINE__)#)"); }

		if (count ($_POST))
		{
			if (((!isset ($_SERVER['QUERY_STRING']))||(!$_SERVER['QUERY_STRING']))&&(isset ($_POST['ohandler']))) { $direct_settings['ohandler'] = preg_replace ("#\W#","",$_POST['ohandler']); }

			if (isset ($_POST['a'])) { $direct_settings['a'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",(urldecode ($_POST['a']))); }
			if (isset ($_POST['dsd'])) { $direct_settings['dsd'] = $_POST['dsd']; }
			if (isset ($_POST['lang'])) { $direct_settings['lang'] = preg_replace ("#\W+#","",$_POST['lang']); }
			if (isset ($_POST['m'])) { $direct_settings['m'] = preg_replace ("#[;\/\\\?:@\=\&\. \+]+#","",$_POST['m']); }

			if (isset ($_POST['s']))
			{
				$direct_settings['s'] = ((strpos ($_POST['s']," ") === false) ? $_POST['s'] : urlencode ($_POST['s']));
				$direct_settings['s'] = preg_replace (array ("#[\+]+#i","#^\W*#","#[\/\\\?:@\=\&\.]+#","#\W*$#","#\\x20+#"),(array (" ","","","","/")),$direct_settings['s']);
			}

			if (isset ($_POST['theme'])) { $direct_settings['theme'] = preg_replace ("#\s+#","",$_POST['theme']); }
			if (isset ($_POST['uuid'])) { $direct_settings['uuid'] = preg_replace ("#\s+#","",$_POST['uuid']); }
		}
		elseif (isset ($_SERVER['QUERY_STRING']))
		{
			if (isset ($f_iline)) { $f_variables = directBasicFunctions::ilineParse ($f_iline); }
			else { $f_variables = directBasicFunctions::ilineParse ($_SERVER['QUERY_STRING']); }

			if ((isset ($f_iline))&&(isset ($f_variables['dsd']))) { $direct_settings['dsd'] = $f_variables['dsd']; }
			if (isset ($f_variables['lang'])) { $direct_settings['lang'] = preg_replace ("#\W+#","",$f_variables['lang']); }
			if (isset ($f_variables['theme'])) { $direct_settings['theme'] = preg_replace ("#\s+#","",$f_variables['theme']); }
			if (isset ($f_variables['uuid'])) { $direct_settings['uuid'] = preg_replace ("#\s+#","",$f_variables['uuid']); }
		}

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Set protocol specific data
------------------------------------------------------------------------- */

		if (empty ($direct_settings['swg_server']))
		{
			if (defined ("OW_PHP_SELF"))
			{
				$f_swg_path = preg_quote (basename (str_replace ("?".$_SERVER['QUERY_STRING'],"",$_SERVER['PHP_SELF'])),"#");
				$f_swg_path = preg_replace ("#$f_swg_path$#i",OW_PHP_SELF,$_SERVER['PHP_SELF']);
			}
			else { $f_swg_path = $_SERVER['PHP_SELF']; }

			if (defined ("OW_SERVER_NAME")) { $direct_settings['swg_server'] = OW_SERVER_NAME.$f_swg_path; }
			else
			{
				if ((isset ($_SERVER['HTTPS']))&&($_SERVER['HTTPS'])&&($_SERVER['SERVER_PORT'] != "443")) { $f_swg_path = ":{$_SERVER['SERVER_PORT']}".$f_swg_path; }
				elseif ($_SERVER['SERVER_PORT'] != "80") { $f_swg_path = ":{$_SERVER['SERVER_PORT']}".$f_swg_path; }

				$direct_settings['swg_server'] = ((strpos ($_SERVER['SERVER_NAME'],":") === false) ? $_SERVER['SERVER_NAME'].$f_swg_path : "[{$_SERVER['SERVER_NAME']}]".$f_swg_path);
			}
		}

		$direct_settings['iscript_req'] = (((isset ($_SERVER['HTTPS']))&&($_SERVER['HTTPS'])) ? "https://".$direct_settings['swg_server'] : "http://".$direct_settings['swg_server']);
		if ((defined ("USE_cookies"))&&(isset ($_COOKIE['BrowserSupport']))) { $direct_settings['swg_clientsupport'] = array_flip (explode (" ",$_COOKIE['BrowserSupport'])); }

/* -------------------------------------------------------------------------
Now filter out the IP and hostname of the visitor - I want to know it
------------------------------------------------------------------------- */

		$f_proxy_ip = (isset ($_SERVER['HTTP_FORWARDED_FOR']) ? $_SERVER['HTTP_FORWARDED_FOR'] : "");
		if ((isset ($_SERVER['HTTP_X_FORWARDED_FOR']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
		if ((isset ($_SERVER['HTTP_CLIENT_IP']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_CLIENT_IP']; }
		if ((isset ($_SERVER['HTTP_X_CLIENT_IP']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_X_CLIENT_IP']; }
		if ((isset ($_SERVER['HTTP_COMING_FROM']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_COMING_FROM']; }
		if ((isset ($_SERVER['HTTP_X_COMING_FROM']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_X_COMING_FROM']; }
		if ((isset ($_SERVER['HTTP_FORWARDED']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_FORWARDED']; }
		if ((isset ($_SERVER['HTTP_X_FORWARDED']))&&(!$f_proxy_ip)) { $f_proxy_ip = $_SERVER['HTTP_X_FORWARDED']; }

/* -------------------------------------------------------------------------
The custom IP code should be used for individual IP identifications - it's
the last chance to get it, otherwise it's $_SERVER['REMOTE_ADDR']
WARNING! Using "swg_ip_customcode" may be a security risk.
------------------------------------------------------------------------- */

		if ((empty ($direct_settings['swg_ip_customcode']))||($direct_settings['swg_phpback_secure_functions_only'])) { $direct_settings['user_ip'] = $_SERVER['REMOTE_ADDR']; }
		else
		{
			$swg_ip = "";
			@eval ($direct_settings['swg_ip_customcode']);
			$direct_settings['user_ip'] = $swg_ip;
		}

/* -------------------------------------------------------------------------
We were unable to find the IP ... writing "unknown"
------------------------------------------------------------------------- */

		if ((!$direct_settings['user_ip'])||($direct_settings['user_ip'] == "127.0.0.1")||($direct_settings['user_ip'] == "::1"))
		{
			$direct_settings['user_ip'] = "unknown";
			$direct_settings['user_ip_name'] = "unknown";
		}
		else { $direct_settings['user_ip_name'] = ""; }

		if (strlen ($f_proxy_ip))
		{
/* -------------------------------------------------------------------------
Looks like the user is using a visible proxy - save whole IP information
------------------------------------------------------------------------- */

			$direct_settings['user_ip_name'] = $direct_settings['user_ip'];

			$f_proxy_ip = str_replace (array (" ",","),(array ("",": ")),$f_proxy_ip);
			$direct_settings['user_ip'] = substr ($f_proxy_ip.": ".$direct_settings['user_ip'],-100);
			$direct_settings['user_ip_proxy'] = $f_proxy_ip;
		}
		else
		{
/* -------------------------------------------------------------------------
The standard result: One IP is enough
------------------------------------------------------------------------- */

			if ($direct_settings['swg_kernel_hostname'])
			{
				if (preg_match ("#^([0123456789\.\:]+)$#",$direct_settings['user_ip'])) { $direct_settings['user_ip_name'] = @gethostbyaddr ($direct_settings['user_ip']); }
				if (!strlen ($direct_settings['user_ip_name'])) { $direct_settings['user_ip_name'] = $direct_settings['user_ip']; }
			}
		}

		$this->method = strtoupper ($_SERVER['REQUEST_METHOD']);

		if ((isset ($_SERVER['PHP_AUTH_DIGEST']))&&(preg_match ("#opaque=\"(\w{32})\"#",$_SERVER['PHP_AUTH_DIGEST'],$f_result_array)))
		{
			$this->auth = "digest";
			$this->uuid = $f_result_array[1];
		}
		elseif (isset ($_SERVER['PHP_AUTH_USER']))
		{
			$this->auth = "basic";
			$this->pass = (isset ($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : NULL);
			$this->user = $_SERVER['PHP_AUTH_USER'];
		}
		else { $this->uuid = (isset ($direct_settings['uuid']) ? $direct_settings['uuid'] : NULL); }
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directIHandlerHttp
	*
	* @since v0.1.08
*\/
	function directIHandlerHttp () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directIHandlerHttp",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['input'] = 'dNG\sWG\directIHandlerHttp';
}

//j// EOF
?>