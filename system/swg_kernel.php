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
* The sWG uses a model which is a little bit similar to Linux (the Kernel).
* Security related methods for calling sWG modules, checking user rights or
* identifying them are included into a (relative simple) kernel system.
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
* @subpackage kernel
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

/**
* Now we will introduce the default kernel not including user specific
* identifications (but we are trying to get the real IP address).
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage kernel
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directKernel extends directVirtualClass
{
/**
	* @var array $prekernel_error Prekernel error array
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $prekernel_error;
/**
	* @var boolean $subkernel_initialized True if the system is ready
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $subkernel_initialized;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directKernel)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->__construct (directKernel)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['basekernelInit'] = true;
		$this->functions['kernelModulesLoad'] = true;
		$this->functions['serviceHttps'] = true;
		$this->functions['serviceInit'] = true;
		$this->functions['serviceInitDefault'] = true;
		$this->functions['serviceInitRBoolean'] = true;
		$this->functions['serviceLoad'] = true;
		$this->functions['subkernelLoad'] = true;
		$this->functions['vGroupInit'] = array ();
		$this->functions['vGroupRightCheck'] = array ();
		$this->functions['vGroupRightWrite'] = array ();
		$this->functions['vGroupRightsGet'] = array ();
		$this->functions['vGroupUserCheckGroup'] = array ();
		$this->functions['vGroupUserCheckRight'] = array ();
		$this->functions['vGroupUserGetGroups'] = array ();
		$this->functions['vGroupUserGetRights'] = array ();
		$this->functions['vSubkernelInit'] = array ();
		$this->functions['vUserCheck'] = array ();
		$this->functions['vUserCheckPassword'] = array ();
		$this->functions['vUserGet'] = array ();
		$this->functions['vUserInit'] = array ();
		$this->functions['vUserInsert'] = array ();
		$this->functions['vUserParse'] = array ();
		$this->functions['vUserSetPassword'] = array ();
		$this->functions['vUserUpdate'] = array ();
		$this->functions['vUserWriteKernel'] = array ();
		$this->functions['vUsertypeGetInt'] = array ();
		$this->functions['vUuidCheckUsage'] = array ();
		$this->functions['vUuidCookieLoad'] = array ();
		$this->functions['vUuidCookieSave'] = array ();
		$this->functions['vUuidGet'] = array ();
		$this->functions['vUuidInit'] = array ();
		$this->functions['vUuidIsCookied'] = array ();
		$this->functions['vUuidWrite'] = array ();

/* -------------------------------------------------------------------------
Set up kernel variables
------------------------------------------------------------------------- */

		$this->prekernel_error = array ();
		$this->subkernel_initialized = false;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directKernel (directKernel)
	*
	* @since v0.1.01
*\/
	function directKernel () { $this->__construct (); }
:#*/
/**
	* Receiving basic data about the user and starting up the system.
	*
	* @return boolean True if the basic functions are loaded successfully
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function basekernelInit ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->basekernelInit ()- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Now get up our basic functions to play with them
------------------------------------------------------------------------- */

		@include_once ($direct_settings['path_system']."/classes/dNG/sWG/directBasicFunctions.php");
		$f_return = direct_class_init ("basic_functions");

/* -------------------------------------------------------------------------
Activate our XML support and receive the core settings - website name,
standard URL, ...
------------------------------------------------------------------------- */

		if ($f_return) { $f_return = $direct_globals['basic_functions']->requireClass ('dNG\sWG\directXmlBridge',1); }
		if ((!direct_class_init ("xml_bridge"))||(!direct_class_function_check ($direct_globals['xml_bridge'],"xml2array"))) { $f_return = false; }

		if ($f_return)
		{
			$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_file_functions.php",1);
			$f_return = $direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_core.php",true);
		}

/* -------------------------------------------------------------------------
evars (Extended variables), files and backward compatibility will be
available right now
------------------------------------------------------------------------- */

		if ($f_return) { $f_return = $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_evars.php",1); }
		if ($f_return) { $f_return = $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_linker.php",1); }
		if ($f_return) { $f_return = $direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_string_translator.php",1); }

		if ($f_return)
		{
			$direct_settings['user']['timezone'] = (int)(date ("Z") / 3600);
			$this->functions['serviceHttps'] = true;
		}
		elseif (direct_class_init ("output")) { $direct_globals['output']->outputSendError ("fatal","Dear Sir or Madam<br /><br />This is the &quot;secured WebGine&quot; program at &quot;$direct_settings[swg_server]&quot;.<br /><br />An error occured while activating required program modules. This is a permanent error.<br /><br />Request terminated<br /><br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->basekernelInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* The kernel is extentible via kernel modules. A settings file containing a
	* list of subkernels that should be loaded before initiating the kernel is
	* located in "data/settings". This function must be called before initiating
	* the kernel.
	*
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function kernelModulesLoad ()
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->kernelModulesLoad ()- (#echo(__LINE__)#)"); }

		$f_ihandler = ucfirst ($direct_settings['ihandler']);

		if (preg_match_all ("#_(\w)#",$f_ihandler,$f_result_array,PREG_PATTERN_ORDER))
		{
			foreach ($f_result_array[1] as $f_rewrite_char) { $f_ihandler = str_replace ("_".$f_rewrite_char,(strtoupper ($f_rewrite_char)),$f_ihandler); }
		}

		if ($direct_globals['basic_functions']->includeClass ('dNG\sWG\directIHandler'.$f_ihandler))
		{
			$f_return = direct_class_init ("input");

/* -------------------------------------------------------------------------
This is an international tool - check the requested language string
------------------------------------------------------------------------- */

			if (!file_exists ($direct_settings['path_lang']."/swg_core.{$direct_settings['lang']}.xml"))
			{
/* -------------------------------------------------------------------------
Try to identify the language using ACCEPT_LANGUAGE
------------------------------------------------------------------------- */

				if (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE'])) { $f_lang_iso = strtolower (str_replace ("-","_",$_SERVER['HTTP_ACCEPT_LANGUAGE'])); }
				elseif (isset ($_SERVER['LANG'])) { $f_lang_iso = strtolower (str_replace ("-","_",$_SERVER['LANG'])); }
				else { $f_lang_iso = "en_US"; }

				$f_lang_iso = preg_replace ("#\W#","",$f_lang_iso);
				$f_lang_domain = substr ($f_lang_iso,0,2);
				if (isset ($direct_settings["swg_lang_".$f_lang_iso])) { $f_lang_iso = $direct_settings["swg_lang_".$f_lang_iso]; }
				if (isset ($direct_settings["swg_lang_".$f_lang_domain])) { $f_lang_domain = $direct_settings["swg_lang_".$f_lang_domain]; }

				if (file_exists ($direct_settings['path_lang']."/swg_core.$f_lang_iso.xml")) { $direct_settings['lang'] = $f_lang_iso; }
				elseif (file_exists ($direct_settings['path_lang']."/swg_core.$f_lang_domain.xml")) { $direct_settings['lang'] = $f_lang_domain; }
				else { $direct_settings['lang'] = $direct_settings['swg_lang']; }
			}

/* -------------------------------------------------------------------------
This is still an international tool - give me the basic language files as
well as everything else that is required to be able to use the
"error_page ()" function.
------------------------------------------------------------------------- */

			$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_local_support.php",1);
			direct_local_integration ("core");
			if (isset ($direct_local['lang_charset'])) { mb_internal_encoding ($direct_local['lang_charset']); }
		}
		else { $f_return = false; }

		if (($f_return)&&(direct_class_init ("input")))
		{
			$f_ohandler = ucfirst ($direct_settings['ohandler']);

			if (preg_match_all ("#_(\w)#",$f_ohandler,$f_result_array,PREG_PATTERN_ORDER))
			{
				foreach ($f_result_array[1] as $f_rewrite_char) { $f_ohandler = str_replace ("_".$f_rewrite_char,(strtoupper ($f_rewrite_char)),$f_ohandler); }
			}

			if (!$direct_globals['basic_functions']->includeClass ('dNG\sWG\directOHandler'.$f_ohandler)) { $f_return = false; }
		}

		if (file_exists ($direct_settings['path_data']."/settings/swg_kernel_modules.php"))
		{
			$f_data = $direct_globals['basic_functions']->memcacheGetFile ($direct_settings['path_data']."/settings/swg_kernel_modules.php");

			if ($f_data)
			{
				$f_data = $direct_globals['xml_bridge']->xml2array ($f_data,true,false);

				if (isset ($f_data['swg_kernel_modules_file_v1']))
				{
					foreach ($f_data['swg_kernel_modules_file_v1'] as $f_module)
					{
						if (isset ($f_module['attributes']['class']))
						{
							$f_class = $direct_globals['basic_functions']->inputfilterBasic ($f_module['attributes']['class']);
							$direct_globals['basic_functions']->includeClass ($f_class,1);
						}
					}
				}
			}
		}

		direct_class_init ("kernel_uuids");
		direct_class_init ("kernel_user");

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG Group Class has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		direct_class_init ("kernel_group");

		if (!direct_class_init ("output")) { $f_return = false; }
		$this->functions['serviceInit'] = $f_return;

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->kernelModulesLoad ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Check and redirect the user if a https connection is required for the
	* requested service.
	*
	* @param  boolean $f_https_required True if a https connection is required
	* @param  string $f_url The URL back to the current request
	* @return boolean False on error
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function serviceHttps ($f_https_required,$f_url)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->serviceHttps (+f_https_required,$f_url)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((!$f_https_required)||(($f_https_required)&&(isset ($_SERVER['HTTPS']))&&($_SERVER['HTTPS']))) { $f_return = true; }
		else
		{
			if ($direct_settings['dsd']['https_redirect'])
			{
				if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->outputSendError ("fatal","core_https_redirect_failed","FATAL ERROR:<br />Request terminated","sWG/#echo(__FILEPATH__)# -kernel->serviceHttps ()- (#echo(__LINE__)#)"); }
				else { $direct_globals['output']->outputSendError ("fatal","The system is unable to perform the required redirection to a secure https connection.","sWG/#echo(__FILEPATH__)# -kernel->serviceHttps ()- (#echo(__LINE__)#)"); }
			}
			else
			{
				$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_linker.php");

				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_url,";dsd=") === false)
				{
					if (strpos ($f_url,"#") === false) { $f_url .= ";dsd=https_redirect+1"; }
					else { $f_url = str_replace ("#",";dsd=https_redirect+1#",$f_url); }
				}
				else { $f_url = str_replace (";dsd=",";dsd=https_redirect+1++",$f_url); }

				if ((!isset ($direct_settings['https_base_url']))||(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($direct_settings['https_base_url'],"https://") === false))
				{
					$f_url = direct_linker ("url1",$f_url,false);
					$f_url = str_replace ("http://","https://",$f_url);
				}
				else
				{
					$direct_settings['iscript_req'] = $direct_settings['https_base_url'];
					$f_url = direct_linker ("url1",$f_url,false);
				}

				$direct_globals['output']->redirect ($f_url);
			}

			exit ();
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->serviceHttps ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Initiates a service and returns an array containing error details if
	* applicable.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @return array Empty array on success
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function serviceInit ($f_threshold_id = "")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel->serviceInit ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = array ();
		$this->vSubkernelInit ($f_threshold_id);

		if (empty ($this->prekernel_error))
		{
			if (($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']) < (time ())) { $f_return = array ("core_unknown_error","FATAL ERROR: The system is experiencing a high load and is therefore unable to service your request at this time.<br /><br />We apologize for this inconvenience.","sWG/#echo(__FILEPATH__)# -kernel->serviceInit ()- (#echo(__LINE__)#)"); }
		}
		else { $f_return = $this->prekernel_error; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel->serviceInit ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Initiates a service and returns a boolean for the status. If an error
	* occured it automatically shows it calling direct_error_functions methods.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function serviceInitDefault ($f_threshold_id = "")
	{
		global $direct_globals,$direct_local;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->serviceInitDefault ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_error_data = $this->serviceInit ($f_threshold_id);

		if (empty ($f_error_data)) { $f_return = true; }
		elseif (direct_class_init ("output"))
		{
			if ($direct_local['lang_charset'])
			{
				if (count ($f_error_data[2]) < 3) { $f_error_data[2] = ""; }

				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_error_data[0],"access_denied") === false) { $direct_globals['output']->outputSendError ("fatal",$f_error_data[0],$f_error_data[1],$f_error_data[2]); }
				else { $direct_globals['output']->outputSendError ("login",$f_error_data[0],$f_error_data[1],$f_error_data[2]); }
			}
			else { $direct_globals['output']->outputSendError ("fatal","An unknown error occurred while initiating the requested resource.","","sWG/#echo(__FILEPATH__)# -kernel->serviceInitDefault ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -kernel->serviceInitDefault ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Initiates a service and returns a boolean for the status.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function serviceInitRBoolean ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->serviceInitRBoolean ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_error_data = $this->serviceInit ($f_threshold_id);
		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -kernel->serviceInitRBoolean ()- (#echo(__LINE__)#)",:#*/(empty ($f_error_data) ? true : false)/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Loads the required files to start a service or redirect the user.
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function serviceLoad ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->serviceLoad ()- (#echo(__LINE__)#)"); }

		$f_redirected = false;
		$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']);

		if (($direct_settings['m'] == "default")&&($direct_settings['s'] == "index")&&($direct_settings['a'] == "index"))
		{
			if (!isset ($direct_globals['basic_functions'])) { direct_class_init ("basic_functions"); }

			if (isset ($direct_settings["swg_service_lang_{$direct_settings['lang']}_module"]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$direct_settings["swg_service_lang_{$direct_settings['lang']}_service"]/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$direct_settings["swg_service_lang_{$direct_settings['lang']}_action"]))
			{
				if (isset ($direct_settings["swg_service_lang_$direct_settings[lang]_dsd"])) { $f_redirect_dsds = $direct_settings["swg_service_lang_$direct_settings[lang]_dsd"]; }
				$direct_settings['a'] = $direct_settings["swg_service_lang_$direct_settings[lang]_action"];
				$direct_settings['s'] = $direct_settings["swg_service_lang_$direct_settings[lang]_service"];
				$direct_settings['m'] = $direct_settings["swg_service_lang_$direct_settings[lang]_module"];
				$f_redirected = true;
			}
			elseif (isset ($direct_settings['swg_service_module']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$direct_settings['swg_service_service']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$direct_settings['swg_service_action']))
			{
				if (isset ($direct_settings['swg_service_dsd'])) { $f_redirect_dsds = $direct_settings['swg_service_dsd']; }
				$direct_settings['a'] = $direct_settings['swg_service_action'];
				$direct_settings['s'] = $direct_settings['swg_service_service'];
				$direct_settings['m'] = $direct_settings['swg_service_module'];
				$f_redirected = true;
			}
		}

		if ($f_timeout_time < (time ())) { $direct_globals['output']->outputSendError ("fatal","core_unknown_error","FATAL ERROR: The system is experiencing a high load and is therefore unable to service your request at this time.<br /><br />We apologize for this inconvenience.","sWG/#echo(__FILEPATH__)# -kernel->serviceLoad ()- (#echo(__LINE__)#)"); }
		elseif ($f_redirected)
		{
			$f_redirected = direct_class_function_check ($direct_globals['basic_functions'],"includeFile");
			if ($f_redirected) { $f_redirected = $direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/functions/swg_linker.php"); }

			if ($f_redirected)
			{
				$f_redirect_url = "";
				if (!$direct_settings['lang']) { $f_redirect_url .= ";lang="; }
				if (!$direct_settings['theme']) { $f_redirect_url .= ";theme="; }
				$f_redirect_url .= ";dsd=".($direct_globals['basic_functions']->varfilter ($f_redirect_dsds,"settings"));

				$f_redirect_url = direct_linker ("url1","m=$direct_settings[m];s=$direct_settings[s];a=".$direct_settings['a'].$f_redirect_url,false);
				$direct_globals['output']->redirect ($f_redirect_url);
			}
			else { $direct_globals['output']->outputSendError ("fatal","core_required_object_not_found","The system could not load a required component.<br /><br />Error accessing basic functions to initiate redirection","sWG/#echo(__FILEPATH__)# -kernel->serviceLoad ()- (#echo(__LINE__)#)"); }
		}
		else
		{
			$f_module = trim (str_replace ("/"," ",$direct_settings['s']));
			$f_module_data = explode (" ",$f_module);
			$f_module = ((count ($f_module_data)) - 1);
			$f_module_data[$f_module] = ("swg_".$f_module_data[$f_module].".php");
			$f_module = implode ("/",$f_module_data);

			if (file_exists ($direct_settings['path_system']."/modules/$direct_settings[m]/".$f_module)) { $direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/modules/$direct_settings[m]/".$f_module,4); }
			else { $direct_globals['output']->outputSendError ("fatal","core_required_object_not_found","FATAL ERROR: &quot;system/modules/$direct_settings[m]/$f_module&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel->serviceLoad ()- (#echo(__LINE__)#)"); }
		}
	}

/**
	* Loads the required file(s) to integrate a module subkernel into the sWG
	* kernel system.
	*
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function subkernelLoad ()
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel->subkernelLoad ()- (#echo(__LINE__)#)"); }

		$this->subkernel_initialized = false;

		if (($direct_settings['m'])&&(file_exists ($direct_settings['path_system']."/modules/$direct_settings[m]/swg_subkernel.php"))) { include_once ($direct_settings['path_system']."/modules/$direct_settings[m]/swg_subkernel.php"); }
		else
		{
			$direct_settings['m'] = "default";
			$direct_settings['s'] = "sysm";
			$direct_settings['a'] = "merror";

			if (!$direct_globals['basic_functions']->includeFile ($direct_settings['path_system']."/modules/default/swg_subkernel.php",4)) { $this->prekernel_error = array ("core_required_object_not_found","FATAL ERROR: &quot;system/modules/default/swg_subkernel.php&quot; was not found","sWG/#echo(__FILEPATH__)# -kernel->subkernelLoad ()- (#echo(__LINE__)#)"); }
		}
	}

/**
	* "Virtual Binding" for "groupInit ()"
	*
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupInit ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupInit ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupInit");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* "Virtual Binding" for "groupRightCheck ()"
	*
	* @param  string $f_gid Group ID
	* @param  mixed $f_rights One (string) or more (array) right name(s)
	* @param  boolean $f_explicit True if all defined rights must be true
	* @return boolean True if the check was successful
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupRightCheck ($f_gid,$f_rights,$f_explicit = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupRightCheck ($f_gid,+f_rights,+f_explicit)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupRightCheck");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid,$f_rights,$f_explicit) : false);
	}

/**
	* "Virtual Binding" for "groupRightWrite ()"
	*
	* @param  string $f_objid Object ID for a right
	* @param  string $f_rid Right IDs
	* @param  string $f_right Right name
	* @param  boolean $f_setup True to grant the right
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupRightWrite ($f_objid,$f_rid,$f_right,$f_setup)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupRightWrite ($f_objid,$f_rid,$f_right,+f_setup)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupRightWrite");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_objid,$f_rid,$f_right,$f_setup) : false);
	}

/**
	* "Virtual Binding" for "groupRightsGet ()"
	*
	* @param  string $f_gid Group ID
	* @return array Rights for the given group
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupRightsGet ($f_gid)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupRightsGet ($f_gid)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupRightsGet");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid) : array ());
	}

/**
	* "Virtual Binding" for "groupUserCheckGroup ()"
	*
	* @param  mixed $f_gid One (string) or more (array) group ID(s)
	* @param  boolean $f_all True if the user has to be in all given groups
	* @return boolean True if the user is in the defined group(s)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupUserCheckGroup ($f_gid,$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupUserCheckGroup (+f_gid,+f_all)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupUserCheckGroup");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid,$f_all) : false);
	}

/**
	* "Virtual Binding" for "groupUserCheckRight ()"
	*
	* @param  mixed $f_rights One (string) or more (array) right IDs
	* @param  boolean $f_explicit True if all defined rights must be true
	* @return boolean True if the check was successful
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupUserCheckRight ($f_rights,$f_explicit = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupUserCheckRight (+f_rights,+f_explicit)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupUserCheckRight");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_rights,$f_explicit) : false);
	}

/**
	* "Virtual Binding" for "groupUserGetGroups ()"
	*
	* @return array Group IDs for $direct_settings['user']['id']
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupUserGetGroups ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupUserGetGroups ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupUserGetGroups");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : array ());
	}

/**
	* "Virtual Binding" for "groupUserGetRights ()"
	*
	* @return array Rights for $direct_settings['user']['id']
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vGroupUserGetRights ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vGroupUserGetRights ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vGroupUserGetRights");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : array ());
	}

/**
	* "Virtual Binding" for "subkernelInit ()"
	*
	* @param string $f_threshold_id This parameter is used to determine if
	*        a request to write data is below the threshold (timeout). Multiple
	*        thresholds may exist.
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vSubkernelInit ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vSubkernelInit ($f_threshold_id)- (#echo(__LINE__)#)"); }

		if (!$this->subkernel_initialized)
		{
			$f_call = $this->vCallGet ("vSubkernelInit");
			$this->subkernel_initialized = true;

			if ($f_call) { $this->prekernel_error = $f_call[0]->{$f_call[1]} ($f_threshold_id); }
			else { $this->prekernel_error = array ("core_unknown_error","FATAL ERROR: The kernel is not linked to a subkernel.","sWG/#echo(__FILEPATH__)# -kernel->serviceLoad ()- (#echo(__LINE__)#)"); }
		}
	}

/**
	* "Virtual Binding" for "userCheck ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @return boolean True if the user exists and no error occurred
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserCheck ($f_userid,$f_username = "",$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserCheck ($f_userid,$f_username,+f_all)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserCheck");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_username,$f_all) : false);
	}

/**
	* "Virtual Binding" for "userCheckPassword ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_password Supplied password
	* @return boolean True if the supplied password is correct
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserCheckPassword ($f_userid,$f_password)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserCheckPassword ($f_userid,+f_password)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserCheckPassword");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_password) : false);
	}

/**
	* "Virtual Binding" for "userGet ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @param  boolean $f_overwrite Overwrite already read data
	* @return mixed User data array on success; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserGet ($f_userid,$f_username = "",$f_all = false,$f_overwrite = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserGet ($f_userid,$f_username,+f_all,+f_overwrite)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserGet");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_username,$f_all,$f_overwrite) : false);
	}

/**
	* "Virtual Binding" for "userInit ()"
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserInit ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserInit ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserInit");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_threshold_id) : false);
	}

/**
	* "Virtual Binding" for "userInsert ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserInsert ($f_userid = "",$f_data = "",$f_use_current_data = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserInsert ($f_userid,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserInsert");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_use_current_data) : false);
	}

/**
	* "Virtual Binding" for "userParse ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  string $f_prefix Key prefix
	* @return mixed Parsed (X)HTML data array; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserParse ($f_userid = "",$f_data = "",$f_prefix = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserParse ($f_userid,+f_data,$f_prefix)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserParse");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_prefix) : false);
	}

/**
	* "Virtual Binding" for "userSetPassword ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_password Supplied password
	* @return boolean True if the supplied password has been set
	* @since  v0.1.10
*/
	/*#ifndef(PHP4) */public /* #*/function vUserSetPassword ($f_userid,$f_password)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserSetPassword ($f_userid,+f_password)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserSetPassword");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_password) : false);
	}

/**
	* "Virtual Binding" for "userUpdate ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserUpdate ($f_userid = "",$f_data = "",$f_use_current_data = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserUpdate ($f_userid,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserUpdate");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_use_current_data) : false);
	}

/**
	* "Virtual Binding" for "userWriteKernel ()"
	*
	* @param  string $f_userid User ID
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUserWriteKernel ($f_userid)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUserWriteKernel ($f_userid)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUserWriteKernel");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid) : false);
	}

/**
	* "Virtual Binding" for "usertypeGetInt ()"
	*
	* @param  string $f_data String value for a group type
	* @return integer Integer value for a group type
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUsertypeGetInt ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUsertypeGetInt ($f_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUsertypeGetInt");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data) : 0);
	}

/**
	* "Virtual Binding" for "uuidCheckUsage ()"
	*
	* @return boolean True if uuID is valid and used
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidCheckUsage ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidCheckUsage ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidCheckUsage");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* "Virtual Binding" for "uuidCookieLoad ()"
	*
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidCookieLoad ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidCookieLoad ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidCookieLoad");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* "Virtual Binding" for "uuidCookieSave ()"
	*
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidCookieSave ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidCookieSave ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidCookieSave");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* "Virtual Binding" for "uuidGet ()"
	*
	* @param  string $f_type Return type (a = array; s = string)
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @return mixed Array or string on success; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidGet ($f_type,$f_cookie_mode = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidGet ($f_type,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidGet");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_type,$f_cookie_mode) : false);
	}

/**
	* "Virtual Binding" for "uuidInit ()"
	*
	* @param  string $f_uuid uuID of the current session
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidInit ($f_uuid = NULL)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidInit (+f_uuid)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidInit");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_uuid) : false);
	}

/**
	* "Virtual Binding" for "uuidIsCookied ()"
	*
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidIsCookied ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidIsCookied ()- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidIsCookied");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

/**
	* "Virtual Binding" for "uuidWrite ()"
	*
	* @param  mixed $f_data uuID data array or string
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function vUuidWrite ($f_data,$f_cookie_mode = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel->vUuidWrite (+f_data,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_call = $this->vCallGet ("vUuidWrite");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data,$f_cookie_mode) : false);
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_globals['@names']['kernel'] = "directKernel";
define ("CLASS_directKernel",true);

//j// Script specific commands

if (!isset ($direct_settings['swg_kernel_hostname'])) { $direct_settings['swg_kernel_hostname'] = false; }
if (!isset ($direct_settings['swg_phpback_secure_functions_only'])) { $direct_settings['swg_phpback_secure_functions_only'] = true; }
$direct_settings['swg_force_local_handling'] = "";

if (file_exists ($direct_settings['path_data']."/settings/swg_lock.chk"))
{
	if ((direct_class_init ("kernel"))&&($direct_globals['kernel'])&&($direct_globals['kernel']->basekernelInit ())&&($direct_globals['kernel']->kernelModulesLoad ()))
	{
		$direct_globals['kernel']->subkernelLoad ();
		$direct_globals['kernel']->serviceLoad ();
	}
}
elseif (direct_class_init ("output")) { $direct_globals['output']->outputSendError ("critical","Dear Sir or Madam<br /><br />This is the &quot;secured WebGine&quot; program at &quot;$direct_settings[swg_server]&quot;.<br /><br />I'm afraid I wasn't able to deliver the requested resource because an &quot;Emergency lock&quot; has been activated.<br />Please feel free to contact the administration or simply try to reach your resource again later.<br /><br />Request terminated","sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

//j// EOF
?>