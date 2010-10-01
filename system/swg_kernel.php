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

//c// direct_kernel_system
/**
* Now we will introduce the default kernel not including user specific
* identifications (but we are trying to get the real IP address).
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage kernel
* @uses       CLASS_direct_virtual_class
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class direct_kernel_system extends direct_virtual_class
{
/**
	* @var array $prekernel_error Prekernel error array
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $prekernel_error;
/**
	* @var array $prekernel_error Prekernel error array
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $subkernel_initialized;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

	//f// direct_kernel_system->__construct () and direct_kernel_system->direct_kernel_system ()
/**
	* Constructor (PHP5) __construct (direct_kernel_system)
	*
	* @uses  USE_debug_reporting
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->__construct (direct_kernel_system)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions 
------------------------------------------------------------------------- */

		$this->functions['basekernel_init'] = true;
		$this->functions['kernel_modules_load'] = true;
		$this->functions['service_https'] = true;
		$this->functions['service_init'] = true;
		$this->functions['service_init_default'] = true;
		$this->functions['service_init_rboolean'] = true;
		$this->functions['service_load'] = true;
		$this->functions['subkernel_load'] = true;
		$this->functions['v_group_init'] = array ();
		$this->functions['v_group_right_check'] = array ();
		$this->functions['v_group_right_write'] = array ();
		$this->functions['v_group_rights_get'] = array ();
		$this->functions['v_group_user_add_group'] = array ();
		$this->functions['v_group_user_del_group'] = array ();
		$this->functions['v_group_user_get_groups'] = array ();
		$this->functions['v_group_user_get_rights'] = array ();
		$this->functions['v_group_user_check_group'] = array ();
		$this->functions['v_group_user_check_right'] = array ();
		$this->functions['v_subkernel_init'] = array ();
		$this->functions['v_user_check'] = array ();
		$this->functions['v_user_get'] = array ();
		$this->functions['v_user_init'] = array ();
		$this->functions['v_user_insert'] = array ();
		$this->functions['v_user_parse'] = array ();
		$this->functions['v_user_update'] = array ();
		$this->functions['v_user_write_kernel'] = array ();
		$this->functions['v_usertype_get_int'] = array ();
		$this->functions['v_uuid_check_usage'] = array ();
		$this->functions['v_uuid_cookie_load'] = array ();
		$this->functions['v_uuid_cookie_save'] = array ();
		$this->functions['v_uuid_get'] = array ();
		$this->functions['v_uuid_init'] = array ();
		$this->functions['v_uuid_is_cookied'] = array ();
		$this->functions['v_uuid_write'] = array ();

/* -------------------------------------------------------------------------
Set up kernel variables
------------------------------------------------------------------------- */

		$this->prekernel_error = array ();
		$this->subkernel_initialized = false;
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) direct_kernel_system (direct_kernel_system)
	*
	* @since v0.1.01
*\/
	function direct_kernel_system () { $this->__construct (); }
:#*/
	//f// direct_kernel_system->basekernel_init ()
/**
	* Receiving basic data about the user and starting up the system.
	*
	* @uses   direct_basic_functions::require_file()
	* @uses   direct_basic_functions::settings_get()
	* @uses   direct_basic_functions_inline::emergency_mode()
	* @uses   direct_class_init()
	* @uses   direct_debug()
	* @uses   direct_local_integration()
	* @uses   USE_debug_reporting
	* @return boolean True if the basic functions are loaded successfully
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function basekernel_init ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel_class->basekernel_init ()- (#echo(__LINE__)#)"); }

		$f_return = false;

/* -------------------------------------------------------------------------
Now get up our basic functions to play with them
------------------------------------------------------------------------- */

		@include_once ($direct_settings['path_system']."/classes/swg_basic_functions.php");

		if (defined ("CLASS_direct_basic_functions"))
		{
/* -------------------------------------------------------------------------
Success! Let's continue to load all basic classes.
------------------------------------------------------------------------- */

			if (!direct_class_init ("basic_functions")) { $direct_classes['basic_functions']->emergency_mode ("Dear Sir or Madam<br /><br />This is the &quot;secured WebGine&quot; program at &quot;$direct_settings[swg_server]&quot;.<br /><br />An error occured while activating required program modules. This is a permanent error.<br /><br />Request terminated<br /><br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
Activate our XML support and receive the core settings - website name,
standard URL, ...
------------------------------------------------------------------------- */

			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_data_handler.php",1,false);
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_xml_bridge.php",1,false);
			if ((!direct_class_init ("xml_bridge"))||(!direct_class_function_check ($direct_classes['xml_bridge'],"xml2array"))) { $direct_classes['basic_functions']->emergency_mode ("Dear Sir or Madam<br /><br />This is the &quot;secured WebGine&quot; program at &quot;$direct_settings[swg_server]&quot;.<br /><br />An error occured while prepairing the system to read required configuration files. This is a permanent error.<br /><br />Request terminated<br /><br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)"); }

			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_file_functions.php",1);
			$direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_core.php",true);
			$direct_settings['user']['timezone'] = (int)(date ("Z") / 3600);

/* -------------------------------------------------------------------------
evars (Extended variables), files and backward compatibility will be
available right now
------------------------------------------------------------------------- */

			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_evar_manager.php",1);
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_linker.php",1);
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_string_translator.php",1);

			$this->functions['service_https'] = true;
			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->basekernel_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->kernel_modules_load ()
/**
	* The kernel is extentible via kernel modules. A settings file containing a
	* list of subkernels that should be loaded before initiating the kernel is
	* located in "data/settings". This function must be called before initiating
	* the kernel.
	*
	* @uses   direct_basic_functions::include_file()
	* @uses   direct_basic_functions::inputfilter_filepath()
	* @uses   direct_debug()
	* @uses   direct_file_get()
	* @uses   direct_xml_bridge::xml2array()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function kernel_modules_load ()
	{
		global $direct_classes,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->kernel_modules_load ()- (#echo(__LINE__)#)"); }

		if ($direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ihandler_{$direct_settings['ihandler']}.php",1))
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

			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_local_support.php",1);
			direct_local_integration ("core");
			if (isset ($direct_local['lang_charset'])) { mb_internal_encoding ($direct_local['lang_charset']); }
		}
		else { $f_return = false; }

		if (($f_return)&&(direct_class_init ("input"))) { $f_return = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/swg_ohandler_{$direct_settings['ohandler']}.php",1); }

		if (file_exists ($direct_settings['path_data']."/settings/swg_kernel_modules.php"))
		{
			$f_data = $direct_classes['basic_functions']->memcache_get_file ($direct_settings['path_data']."/settings/swg_kernel_modules.php");

			if ($f_data)
			{
				$f_data = $direct_classes['xml_bridge']->xml2array ($f_data,true,false);

				if (isset ($f_data['swg_kernel_modules_file_v1']))
				{
					foreach ($f_data['swg_kernel_modules_file_v1'] as $f_module)
					{
						if (isset ($f_module['attributes']['file']))
						{
							$f_module = $direct_classes['basic_functions']->inputfilter_filepath ($f_module['attributes']['file']);
							$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/classes/".$f_module,1);
						}
					}
				}
			}
		}

		if (!direct_class_init ("output")) { $f_return = false; }
		$this->functions['service_init'] = $f_return;

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->kernel_modules_load ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->service_https ($f_https_required,$f_url)
/**
	* Check and redirect the user if a https connection is required for the
	* requested service.
	*
	* @param  boolean $f_https_required True if a https connection is required
	* @param  string $f_url The URL back to the current request
	* @uses   direct_basic_functions::require_file()
	* @uses   direct_basic_functions_inline::emergency_mode()
	* @uses   direct_class_function_check()
	* @uses   direct_debug()
	* @uses   direct_error_functions::error_page()
	* @uses   direct_linker()
	* @uses   direct_output_control::redirect()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function service_https ($f_https_required,$f_url)
	{
		global $direct_classes,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->service_https (+f_https_required,$f_url)- (#echo(__LINE__)#)"); }

		$f_return = false;

		if ((!$f_https_required)||(($f_https_required)&&(isset ($_SERVER['HTTPS']))&&($_SERVER['HTTPS']))) { $f_return = true; }
		else
		{
			direct_class_init ("output");

			if ($direct_settings['dsd']['https_redirect'])
			{
				if (isset ($direct_local['lang_charset'])) { $direct_classes['output']->output_send_error ("fatal","core_https_redirect_failed","FATAL ERROR:<br />Request terminated<br />sWG/#echo(__FILEPATH__)# -kernel_class->service_https ()- (#echo(__LINE__)#)"); }
				else { $direct_classes['output']->output_send_error ("fatal","The system is unable to perform the required redirection to a secure https connection.<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_https ()- (#echo(__LINE__)#)"); }
			}
			else
			{
				$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_linker.php");

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

				$direct_classes['output']->redirect ($f_url);
			}

			exit ();
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->service_https ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->service_init ($f_threshold_id = "")
/**
	* Initiates a service and returns an array containing error details if
	* applicable.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @uses   direct_kernel_system::v_subkernel_init()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return array Empty array on success
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function service_init ($f_threshold_id = "")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = array ();
		$this->v_subkernel_init ($f_threshold_id);

		if (empty ($this->prekernel_error))
		{
			if (($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']) < (time ())) { $f_return = array ("core_unknown_error","FATAL ERROR:<br />The system is experiencing a high load and is therefore unable to service your request at this time.<br /><br />We apologize for this inconvenience.<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_init ()- (#echo(__LINE__)#)"); }
		}
		else { $f_return = $this->prekernel_error; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->service_init_default ($f_threshold_id = "")
/**
	* Initiates a service and returns a boolean for the status. If an error
	* occured it automatically shows it calling direct_error_functions methods.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @uses   direct_debug()
	* @uses   direct_error_functions::error_page()
	* @uses   direct_kernel_system::service_init()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function service_init_default ($f_threshold_id = "")
	{
		global $direct_classes,$direct_local;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init_default ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_return = false;
		$f_error_data = $this->service_init ($f_threshold_id);

		if (empty ($f_error_data)) { $f_return = true; }
		elseif (direct_class_init ("output"))
		{
			if ($direct_local['lang_charset'])
			{
				if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_error_data[0],"access_denied") === false) { $direct_classes['output']->output_send_error ("fatal",$f_error_data[0],$f_error_data[1]); }
				else { $direct_classes['output']->output_send_error ("login",$f_error_data[0],$f_error_data[1]); }
			}
			else { $direct_classes['output']->output_send_error ("fatal","An unknown error occurred while initiating the requested resource.<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_init_default ()- (#echo(__LINE__)#)"); }
		}

		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init_default ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->service_init_rboolean ($f_threshold_id = "")
/**
	* Initiates a service and returns a boolean for the status.
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @uses   direct_kernel_system::service_init()
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function service_init_rboolean ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init_rboolean ($f_threshold_id)- (#echo(__LINE__)#)"); }

		$f_error_data = $this->service_init ($f_threshold_id);
		return /*#ifdef(DEBUG):direct_debug (9,"sWG/#echo(__FILEPATH__)# -kernel_class->service_init_rboolean ()- (#echo(__LINE__)#)",:#*/(empty ($f_error_data) ? true : false)/*#ifdef(DEBUG):,true):#*/;
	}

	//f// direct_kernel_system->service_load ()
/**
	* Loads the required files to start a service or redirect the user.
	*
	* @uses  direct_basic_functions::include_file()
	* @uses  direct_basic_functions::varfilter()
	* @uses  direct_class_function_check()
	* @uses  direct_class_init()
	* @uses  direct_debug()
	* @uses  direct_linker()
	* @uses  direct_output_control::redirect()
	* @uses  USE_debug_reporting
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function service_load ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->service_load ()- (#echo(__LINE__)#)"); }

		$f_redirected = false;
		$f_timeout_time = ($direct_cachedata['core_time'] + $direct_settings['timeout'] + $direct_settings['timeout_core']);

		if (($direct_settings['m'] == "default")&&($direct_settings['s'] == "index")&&($direct_settings['a'] == "index"))
		{
			if (!isset ($direct_classes['basic_functions'])) { direct_class_init ("basic_functions"); }

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

		if ($f_timeout_time < (time ())) { $direct_classes['output']->output_send_error ("fatal","core_unknown_error","FATAL ERROR:<br />The system is experiencing a high load and is therefore unable to service your request at this time.<br /><br />We apologize for this inconvenience.<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_load ()- (#echo(__LINE__)#)"); }
		elseif ($f_redirected)
		{
			$f_redirected = direct_class_function_check ($direct_classes['basic_functions'],"include_file");
			if ($f_redirected) { $f_redirected = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/functions/swg_linker.php"); }
			if ($f_redirected) { $f_redirected = direct_class_init ("output"); }

			if ($f_redirected)
			{
				$f_redirect_url = "";
				if (!$direct_settings['lang']) { $f_redirect_url .= ";lang="; }
				if (!$direct_settings['theme']) { $f_redirect_url .= ";theme="; }
				$f_redirect_url .= ";dsd=".($direct_classes['basic_functions']->varfilter ($f_redirect_dsds,"settings"));

				$f_redirect_url = direct_linker ("url1","m=$direct_settings[m];s=$direct_settings[s];a=".$direct_settings['a'].$f_redirect_url,false);
				$direct_classes['output']->redirect ($f_redirect_url);
			}
			else { $direct_classes['output']->output_send_error ("fatal","core_required_object_not_found","The system could not load a required component.<br /><br />Error accessing basic functions to initiate redirection<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_load ()- (#echo(__LINE__)#)"); }
		}
		else
		{
			$f_module = trim (str_replace ("/"," ",$direct_settings['s']));
			$f_module_data = explode (" ",$f_module);
			$f_module = ((count ($f_module_data)) - 1);
			$f_module_data[$f_module] = ("swg_".$f_module_data[$f_module].".php");
			$f_module = implode ("/",$f_module_data);

			if (file_exists ($direct_settings['path_system']."/modules/$direct_settings[m]/".$f_module)) { $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/modules/$direct_settings[m]/".$f_module,4); }
			else { $direct_classes['output']->output_send_error ("fatal","core_required_object_not_found","FATAL ERROR:<br />&quot;$direct_settings[path_system]/modules/$direct_settings[m]/$f_module&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_load ()- (#echo(__LINE__)#)"); }
		}
	}

	//f// direct_kernel_system->subkernel_load ()
/**
	* Loads the required file(s) to integrate a module subkernel into the sWG
	* kernel system.
	*
	* @uses  direct_basic_functions::include_file()
	* @uses  direct_debug()
	* @uses  USE_debug_reporting
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function subkernel_load ()
	{
		global $direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_load ()- (#echo(__LINE__)#)"); }

		$this->subkernel_initialized = false;

		if (($direct_settings['m'])&&(file_exists ($direct_settings['path_system']."/modules/$direct_settings[m]/swg_subkernel.php"))) { include_once ($direct_settings['path_system']."/modules/$direct_settings[m]/swg_subkernel.php"); }
		else
		{
			$direct_settings['m'] = "default";
			$direct_settings['s'] = "sysm";
			$direct_settings['a'] = "merror";

			if (!$direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/modules/default/swg_subkernel.php",4)) { $this->prekernel_error = array ("core_required_object_not_found","FATAL ERROR:<br />&quot;$direct_settings[path_system]/modules/default/swg_subkernel.php&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->subkernel_load ()- (#echo(__LINE__)#)"); }
		}
	}

	//f// direct_kernel_system->v_group_init ()
/**
	* "Virtual Binding" for "group_init ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_init ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_init ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_init");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_kernel_system->v_group_right_check ($f_gid,$f_rights,$f_explicit = false)
/**
	* "Virtual Binding" for "group_right_check ()"
	*
	* @param  string $f_gid Group ID
	* @param  mixed $f_rights One (string) or more (array) right name(s)
	* @param  boolean $f_explicit True if all defined rights must be true
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True if the check was successful
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_right_check ($f_gid,$f_rights,$f_explicit = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_right_check ($f_gid,+f_rights,+f_explicit)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_right_check");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid,$f_rights,$f_explicit) : false);
	}

	//f// direct_kernel_system->v_group_right_write ($f_objid,$f_rid,$f_right,$f_setup)
/**
	* "Virtual Binding" for "group_right_write ()"
	*
	* @param  string $f_objid Object ID for a right
	* @param  string $f_rid Right IDs
	* @param  string $f_right Right name
	* @param  boolean $f_setup True to grant the right
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_right_write ($f_objid,$f_rid,$f_right,$f_setup)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_right_write ($f_objid,$f_rid,$f_right,+f_setup)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_right_write");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_objid,$f_rid,$f_right,$f_setup) : false);
	}

	//f// direct_kernel_system->v_group_rights_get ($f_gid)
/**
	* "Virtual Binding" for "group_rights_get ()"
	*
	* @param  string $f_gid Group ID
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return array Rights for the given group
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_rights_get ($f_gid)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_rights_get ($f_gid)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_rights_get");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid) : array ());
	}

	//f// direct_kernel_system->v_group_user_check_group ($f_gid,$f_all = false)
/**
	* "Virtual Binding" for "group_user_check_group ()"
	*
	* @param  mixed $f_gid One (string) or more (array) group ID(s)
	* @param  boolean $f_all True if the user has to be in all given groups
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True if the user is in the defined group(s)
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_user_check_group ($f_gid,$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_user_check_group (+f_gid,+f_all)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_user_check_group");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_gid,$f_all) : false);
	}

	//f// direct_kernel_system->v_group_user_check_right ($f_rights,$f_explicit = false)
/**
	* "Virtual Binding" for "group_user_check_right ()"
	*
	* @param  mixed $f_rights One (string) or more (array) right IDs
	* @param  boolean $f_explicit True if all defined rights must be true
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True if the check was successful
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_user_check_right ($f_rights,$f_explicit = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_user_check_right (+f_rights,+f_explicit)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_user_check_right");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_rights,$f_explicit) : false);
	}

	//f// direct_kernel_system->v_group_user_get_groups ()
/**
	* "Virtual Binding" for "group_user_get_groups ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return array Group IDs for $direct_settings['user']['id']
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_user_get_groups ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_user_get_groups ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_user_get_groups");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : array ());
	}

	//f// direct_kernel_system->v_group_user_get_rights ()
/**
	* "Virtual Binding" for "group_user_get_rights ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return array Rights for $direct_settings['user']['id']
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_group_user_get_rights ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_user_get_rights ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_group_user_get_rights");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : array ());
	}

	//f// direct_kernel_system->v_subkernel_init ($f_threshold_id = "")
/**
	* "Virtual Binding" for "subkernel_init ()"
	*
	* @param string $f_threshold_id This parameter is used to determine if
	*        a request to write data is below the threshold (timeout). Multiple
	*        thresholds may exist.
	* @uses  direct_debug()
	* @uses  direct_virtual_class::v_call_get()
	* @uses  USE_debug_reporting
	* @since v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_subkernel_init ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_subkernel_init ($f_threshold_id)- (#echo(__LINE__)#)"); }

		if (!$this->subkernel_initialized)
		{
			$f_call = $this->v_call_get ("v_subkernel_init");
			$this->subkernel_initialized = true;

			if ($f_call) { $this->prekernel_error = $f_call[0]->{$f_call[1]} ($f_threshold_id); }
			else { $this->prekernel_error = array ("core_unknown_error","FATAL ERROR:<br />The kernel is not linked to a subkernel.<br /><br />sWG/#echo(__FILEPATH__)# -kernel_class->service_load ()- (#echo(__LINE__)#)"); }
		}
	}

	//f// direct_kernel_system->v_user_check ($f_userid,$f_username = "",$f_all = false)
/**
	* "Virtual Binding" for "user_check ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True if the user exists and no error occurred
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_check ($f_userid,$f_username = "",$f_all = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_check ($f_userid,$f_username,+f_all)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_check");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_username,$f_all) : false);
	}

	//f// direct_kernel_system->v_user_get ($f_userid,$f_username = "",$f_all = false,$f_overwrite = false)
/**
	* "Virtual Binding" for "user_get ()"
	*
	* @param  string $f_userid User ID
	* @param  string $f_username Username
	* @param  boolean $f_all Include banned and locked account if true
	* @param  boolean $f_overwrite Overwrite already read data
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return mixed User data array on success; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_get ($f_userid,$f_username = "",$f_all = false,$f_overwrite = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_get ($f_userid,$f_username,+f_all,+f_overwrite)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_get");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_username,$f_all,$f_overwrite) : false);
	}

	//f// direct_kernel_system->v_user_init ($f_threshold_id = "")
/**
	* "Virtual Binding" for "user_init ()"
	*
	* @param  string $f_threshold_id This parameter is used to determine if
	*         a request to write data is below the threshold (timeout). Multiple
	*         thresholds may exist.
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_init ($f_threshold_id = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_init ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_init");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_threshold_id) : false);
	}

	//f// direct_kernel_system->v_user_parse ($f_userid = "",$f_data = "",$f_prefix = "")
/**
	* "Virtual Binding" for "user_parse ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  string $f_prefix Key prefix
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return mixed Parsed (X)HTML data array; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_parse ($f_userid = "",$f_data = "",$f_prefix = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_parse ($f_userid,+f_data,$f_prefix)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_parse");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_prefix) : false);
	}

	//f// direct_kernel_system->v_user_insert ($f_userid = "",$f_data = "",$f_use_current_data = true)
/**
	* "Virtual Binding" for "user_insert ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_insert ($f_userid = "",$f_data = "",$f_use_current_data = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_insert ($f_userid,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_insert");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_use_current_data) : false);
	}

	//f// direct_kernel_system->v_user_update ($f_userid = "",$f_data = "",$f_use_current_data = true)
/**
	* "Virtual Binding" for "user_update ()"
	*
	* @param  string $f_userid User ID
	* @param  mixed $f_data Array containing user data or empty string
	* @param  boolean $f_use_current_data True to set user settings to current
	*         ones (time, theme, ...)
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_update ($f_userid = "",$f_data = "",$f_use_current_data = true)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_update ($f_userid,+f_data,+f_use_current_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_update");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid,$f_data,$f_use_current_data) : false);
	}

	//f// direct_kernel_system->v_user_write_kernel ($f_userid)
/**
	* "Virtual Binding" for "user_write_kernel ()"
	*
	* @param  string $f_userid User ID
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_user_write_kernel ($f_userid)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_user_write_kernel ($f_userid)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_user_write_kernel");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_userid) : false);
	}

	//f// direct_kernel_system->v_usertype_get_int ($f_data = 0)
/**
	* "Virtual Binding" for "usertype_get_int ()"
	*
	* @param  string $f_data String value for a group type
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return integer Integer value for a group type
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_usertype_get_int ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_usertype_get_int ($f_data)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_usertype_get_int");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data) : 0);
	}

	//f// direct_kernel_system->v_uuid_check_usage ()
/**
	* "Virtual Binding" for "uuid_check_usage ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True if uuID is valid and used
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_check_usage ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_check_usage ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_check_usage");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_kernel_system->v_uuid_cookie_load ()
/**
	* "Virtual Binding" for "uuid_cookie_load ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_cookie_load ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_cookie_load ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_cookie_load");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_kernel_system->v_uuid_cookie_save ()
/**
	* "Virtual Binding" for "uuid_cookie_save ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_cookie_save ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_cookie_save ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_cookie_save");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_kernel_system->v_uuid_get ($f_type,$f_cookie_mode = false)
/**
	* "Virtual Binding" for "uuid_get ()"
	*
	* @param  string $f_type Return type (a = array; s = string)
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return mixed Array or string on success; False on error
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_get ($f_type,$f_cookie_mode = false)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_get ($f_type,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_get");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_type,$f_cookie_mode) : false);
	}

	//f// direct_kernel_system->v_uuid_init ($f_uuid = NULL)
/**
	* "Virtual Binding" for "uuid_init ()"
	*
	* @param  string $f_uuid uuID of the current session
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_init ($f_uuid = NULL)
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_init (+f_uuid)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_init");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_uuid) : false);
	}

	//f// direct_kernel_system->v_uuid_is_cookied ()
/**
	* "Virtual Binding" for "uuid_is_cookied ()"
	*
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_is_cookied ()
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_uuid_is_cookied ()- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_is_cookied");
		return ($f_call ? $f_call[0]->{$f_call[1]} () : false);
	}

	//f// direct_kernel_system->v_uuid_write ($f_data,$f_cookie_mode = "")
/**
	* "Virtual Binding" for "uuid_write ()"
	*
	* @param  mixed $f_data uuID data array or string
	* @param  mixed $f_cookie_mode Boolean for (de)activation - empty string to
	*         use system setting
	* @uses   direct_debug()
	* @uses   direct_virtual_class::v_call_get()
	* @uses   USE_debug_reporting
	* @return boolean True on success
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function v_uuid_write ($f_data,$f_cookie_mode = "")
	{
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -kernel_class->v_group_init (+f_data,+f_cookie_mode)- (#echo(__LINE__)#)"); }

		$f_call = $this->v_call_get ("v_uuid_write");
		return ($f_call ? $f_call[0]->{$f_call[1]} ($f_data,$f_cookie_mode) : false);
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

$direct_classes['@names']['kernel'] = "direct_kernel_system";
define ("CLASS_direct_kernel_system",true);

//j// Script specific commands

if (!isset ($direct_settings['swg_kernel_hostname'])) { $direct_settings['swg_kernel_hostname'] = false; }
if (!isset ($direct_settings['swg_phpback_secure_functions_only'])) { $direct_settings['swg_phpback_secure_functions_only'] = true; }
$direct_settings['swg_force_local_handling'] = "";

if (file_exists ($direct_settings['path_data']."/settings/swg_lock.chk"))
{
	direct_class_init ("kernel");

	if ($direct_classes['kernel'])
	{
	if (($direct_classes['kernel']->basekernel_init ())&&($direct_classes['kernel']->kernel_modules_load ()))
	{
		$direct_classes['kernel']->subkernel_load ();
		$direct_classes['kernel']->service_load ();
	}
	}
}
else
{
	direct_class_init ("output");
	$direct_classes['output']->output_send_error ("critical","Dear Sir or Madam<br /><br />This is the &quot;secured WebGine&quot; program at &quot;$direct_settings[swg_server]&quot;.<br /><br />I'm afraid I wasn't able to deliver the requested resource because an &quot;Emergency lock&quot; has been activated.<br />Please feel free to contact the administration or simply try to reach your resource again later.<br /><br />Request terminated<br /><br />sWG/#echo(__FILEPATH__)# _main_ (#echo(__LINE__)#)");
}

//j// EOF
?>