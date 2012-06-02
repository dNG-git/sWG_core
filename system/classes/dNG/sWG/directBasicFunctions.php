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
* Basic functions to include files, check input or support localisations are
* required everywhere.
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
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #\n*/
/*#use(direct_use) */
use dNG\directXml;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

if (!defined ("CLASS_directBasicFunctions"))
{
/**
* Currently we have only really basic functions - now we want to introduce
* some more.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/
class directBasicFunctions extends directActionParser
{
/**
	* @var array $mimetype_extensions_cache Cache for mimetype assignments
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $mimetype_extensions_cache;
/**
	* @var array $mimetype_icons_cache Array containing already found icon
	*      pathes
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $mimetype_icons_cache;
/*#ifndef(PHP5n):
/**
	* @var boolean $PHP_filter_var True if the PHP function "filter_var () " is
	*      supported.
*\/
	/*#ifndef(PHP4) *\/protected/* #*\//*#ifdef(PHP4):var:#*\/ $PHP_filter_var;
:#\n*/
/**
	* @var array $settings_cache Cache for already read settings files
*/
	/*#ifndef(PHP4) */protected/* #*//*#ifdef(PHP4):var:#*/ $settings_cache;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directBasicFunctions)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->__construct (directBasicFunctions)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['backtraceGet'] = true;
		$this->functions['datetime'] = true;
		$this->functions['dsdParse'] = true;
		$this->functions['includeFile'] = true;
		$this->functions['inputfilterBasic'] = true;
		$this->functions['inputfilterEMail'] = true;
		$this->functions['inputfilterFilePath'] = true;
		$this->functions['inputfilterNumber'] = true;
		$this->functions['magicQuotesFilter'] = true;
		$this->functions['magicQuotesInput'] = true;
		$this->functions['memcacheGetFile'] = true;
		$this->functions['memcacheGetFilePathName'] = true;
		$this->functions['memcacheGetFileMergedXml'] = true;
		$this->functions['memcacheWriteFile'] = true;
		$this->functions['mimetypeExtension'] = true;
		$this->functions['mimetypeIcon'] = true;
		$this->functions['requireClass'] = true;
		$this->functions['requireFile'] = true;
		$this->functions['settingsGet'] = true;
		$this->functions['settingsWrite'] = true;
		$this->functions['tmd5'] = true;
		$this->functions['varfilter'] = true;

/* -------------------------------------------------------------------------
Set up the caching variables
------------------------------------------------------------------------- */

		$this->mimetype_extensions_cache = array ();
		$this->mimetype_icons_cache = array ();
/*#ifndef(PHP5n):
		$this->PHP_filter_var = function_exists ("filter_var");
:#\n*/
		$this->settings_cache = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directBasicFunctions
	*
	* @since v0.1.01
*\/
	function directBasicFunctions () { $this->__construct (); }
:#\n*/
/**
	* Destructor (PHP5) __destruct (directBasicFunctions)
	*
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function __destruct () { restore_error_handler (); }

/**
	* Parse a given backtrace array (or try to load one via "debug_backtrace").
	*
	* @param  array $f_data Already extracted backtrace as array
	* @return array Backtrace array
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function backtraceGet ($f_data = NULL)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->backtraceGet (+f_data)- (#echo(__LINE__)#)"); }
		$f_return = array ();

		if (is_array ($f_data)) { $f_backtrace_array = $f_data; }
		elseif (function_exists ("debug_backtrace")) { $f_backtrace_array = debug_backtrace (); }

		if (isset ($f_backtrace_array))
		{
			foreach ($f_backtrace_array as $f_backtrace_entry_array)
			{
				$f_backtrace_line = "";

				if (isset ($f_backtrace_entry_array['file'])) { $f_backtrace_line .= $f_backtrace_entry_array['file'].": "; }
				if (isset ($f_backtrace_entry_array['class'])) { $f_backtrace_line .= $f_backtrace_entry_array['class']."->"; }
				if (isset ($f_backtrace_entry_array['function'])) { $f_backtrace_line .= $f_backtrace_entry_array['function']." "; }
				if (isset ($f_backtrace_entry_array['line'])) { $f_backtrace_line .= "({$f_backtrace_entry_array['line']}) "; }

				$f_return[] = $f_backtrace_line;
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->backtraceGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* First of all, we want to provide a function to format a date (including
	* local time settings).
	*
	* @param  string $f_type Defines the requested type that should be returned
    *         The following types are supported: "longdate", "longdate&time",
    *         "shortdate", "shortdate&time". The default one is "time".
	* @param  integer $f_date An Unix timestamp
	* @param  float $f_cutz The difference in hours between the local time and
	*         GMT.
	* @param  string $f_dtconnector An string that combines a date and the
	*         time.
	* @return string Formatted date and / or time
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function datetime ($f_type,$f_date,$f_cutz,$f_dtconnector = "",$f_hidez = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->datetime ($f_type,$f_date,$f_cutz,$f_dtconnector,+f_hidez)- (#echo(__LINE__)#)"); }

		if ($f_date)
		{
			if (!empty ($f_cutz)) { $f_date += (3600 * $f_cutz); }

			switch ($f_type)
			{
			case "longdate":
			{
				$f_month = gmdate ("n",$f_date);
				$f_return = (gmdate (direct_local_get ("datetime_longdate_1"),$f_date)).(direct_local_get ("datetime_longdate_month_".$f_month)).(gmdate (direct_local_get ("datetime_longdate_2"),$f_date));

				break 1;
			}
			case "longdate&time":
			{
				$f_month = gmdate ("n",$f_date);
				$f_return = (gmdate (direct_local_get ("datetime_longdate_1"),$f_date)).(direct_local_get ("datetime_longdate_month_".$f_month)).(gmdate (direct_local_get ("datetime_longdate_2"),$f_date)).$f_dtconnector.(gmdate (direct_local_get ("datetime_time"),$f_date));

				break 1;
			}
			case "shortdate":
			{
				$f_return = gmdate (direct_local_get ("datetime_shortdate"),$f_date);
				break 1;
			}
			case "shortdate&time":
			{
				$f_return = (gmdate (direct_local_get ("datetime_shortdate"),$f_date)).$f_dtconnector.(gmdate (direct_local_get ("datetime_time"),$f_date));
				break 1;
			}
			default: { $f_return = gmdate (direct_local_get ("datetime_time"),$f_date); }
			}

			if (!$f_hidez)
			{
				$f_return .= " ".(direct_local_get ("core_timezone_gmt"));
				if ($f_cutz < 0) { $f_return .= $f_cutz; }
				if ($f_cutz > 0) { $f_return .= "+".$f_cutz; }
			}
		}
		else { $f_return = direct_local_get ("core_unknown"); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->datetime ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* DSD stands for dynamic service data and should be used for transfering
	* IDs for news, topics, ... All data will be encoded using addslashes -
	* take care for HTML injection!
	*
	* @param  mixed $f_data DSD string for parsing or an array to use
	* @return array Parsed DSD array
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function dsdParse ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->dsdParse (+f_data)- (#echo(__LINE__)#)"); }

		if (is_array ($f_data)) { $f_return = $f_data; }
		elseif (is_string ($f_data))
		{
			if (strpos ($f_data," ") !== false) { $f_data = urlencode ($f_data); }
			$f_data = preg_replace ("#[\+]{3,}#i","++",$f_data);

			$f_dsds = explode ("++",$f_data);
			$f_return = array ();

			foreach ($f_dsds as $f_dsd)
			{
				$f_data = explode ("+",(trim ($f_dsd)),2);

				if (isset ($f_data[1])) { $f_return[$f_data[0]] = $this->inputfilterBasic (urldecode ($f_data[1])); }
				elseif ($f_data[0]) { $f_return[$f_data[0]] = ""; }
			}
		}
		else { $f_return = NULL; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->dsdParse ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Include a class or return 'false' - process will continue.
	*
	* @param  string $f_file_pathname Relative path from "swg.php" to the file and
	*         filename
	* @param  integer $f_cachelevel There are three cache levels for system files.
	*         "1" is for always needed files, "2" for often used and "3" for
	*         module specific ones. Level "4" is used to cache module files.
	* @param  boolean $f_once Include a file once only
	* @return boolean True on successful inclusion
	* @since  v0.1.10
*/
	/*#ifndef(PHP4) */public /* #*/function includeClass ($f_class,$f_cachelevel = 4)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->includeClass ($f_class,$f_cachelevel)- (#echo(__LINE__)#)"); }

		$f_class_array = direct_class_pathname ($f_class);

		if (is_array ($f_class_array))
		{
			$f_file_pathname = $f_class_array[0];
			$f_return = $this->includeFile ($f_file_pathname,$f_cachelevel);
		}
		else { $f_return = false; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->includeClass ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Include a file or return 'false' - process will continue.
	*
	* @param  string $f_file_pathname Relative path from "swg.php" to the file and
	*         filename
	* @param  integer $f_cachelevel There are three cache levels for system files.
	*         1 is for always needed files, 2 for often used and 3 for module
	*         specific ones. Level 4 is used to cache module files.
	* @param  boolean $f_once Include a file once only
	* @return boolean True on successful inclusion
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function includeFile ($f_file_pathname,$f_cachelevel = 4,$f_once = true)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->includeFile ($f_file_pathname,$f_cachelevel,+f_once)- (#echo(__LINE__)#)"); }

		$f_return = false;

		$f_memcache_check = false;
		$f_memcache_pathname = $direct_globals['basic_functions']->memcacheGetFilePathName ($f_file_pathname,$f_cachelevel);

		if (isset ($f_memcache_pathname))
		{
			$f_file_pathname = $f_memcache_pathname;
			$f_memcache_check = true;
		}

		if (($f_memcache_check)||(file_exists ($f_file_pathname)))
		{
			if ($f_once) { include_once ($f_file_pathname); }
			else { include ($f_file_pathname); }

			$f_return = true;
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->includeFile ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* There are some persons out there that may want to inject data like NULL
	* characters into our system. The function "inputfilterBasic ()" will
	* remove these characters.
	*
	* @param  string $f_data Input string
	* @param  boolean $f_tab_allowed Accept TABs
	* @return string Filtered string
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function inputfilterBasic ($f_data,$f_tab_allowed = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterBasic (+f_data)- (#echo(__LINE__)#)"); }

		if (is_string ($f_data))
		{
			$f_preg_expr = ($f_tab_allowed ? "#[\\x00-\\x08]#" : "#[\\x00-\\x09]#");
			$f_data = preg_replace ($f_preg_expr,"",$f_data);
			if (INFO_magic_quotes_input) { $this->magicQuotesInput ($f_data); }
		}
		else { $f_data = ""; }

		return $f_data;
	}

/**
	* Checks a eMail address if it's valid (RFC822) and returns the (unfolded)
	* address if it is.
	*
	* @param  string $f_data Input eMail
	* @return string Filtered eMail address or empty string if the address is not
	*         valid
	* @since  v0.1.05
*/
	/*#ifndef(PHP4) */public /* #*/function inputfilterEMail ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterEMail ($f_data)- (#echo(__LINE__)#)"); }

/*#ifndef(PHP5n):
		if ($this->PHP_filter_var)
		{
:#\n*/
		$f_data = filter_var ($f_data,FILTER_VALIDATE_EMAIL);
		$f_continue_check = ((is_bool ($f_data)) ? false : true);
/*#ifndef(PHP5n):
		}
		else
		{
			$f_address_parsing = true;
			$f_continue_check = true;
			$f_data_part = "";

			if (is_string ($f_data)) { $f_data = preg_replace ("#\r\n([\\x09\\x20])+#","\\1",$f_data); }
			$f_data = $this->inputfilterBasic ($f_data);
			$f_dot_array = explode (".",$f_data);

			foreach ($f_dot_array as $f_dot_part)
			{
				if (!$f_address_parsing) { $f_data_part .= ".".$f_dot_part; }
				elseif ($f_continue_check)
				{
					if ((strlen ($f_data_part))||($f_dot_part[0] == "\""))
					{
						if ((strlen ($f_dot_part) > 1)&&($f_dot_part[(strlen ($f_dot_part) - 1)] == "\""))
						{
							if ((preg_match ("#([\\\\]+)\"$#",$f_dot_part,$f_result_array))&&(strlen ($f_result_array) % 2 == 1)) { $f_data_part .= $f_dot_part; }
							else
							{
								$f_data_part .= $f_dot_part;

								if (preg_match ("#^\"[\\x00-\\x0c\\x0e-\\x7f]+\"$#",$f_data_part)) { $f_data_part = ""; }
								else { $f_continue_check = false; }
							}
						}
						else
						{
							if (strpos ($f_dot_part,"\"@") === false) { $f_data_part .= $f_dot_part; }
							else
							{
								$f_at_array = explode ("\"@",$f_dot_part,2);
								$f_address_parsing = false;

								if (preg_match ("#^\"[\\x00-\\x0c\\x0e-\\x7f]+$#",$f_data_part.$f_at_array[0])) { $f_data_part = $f_at_array[1]; }
								else { $f_continue_check = false; }
							}
						}
					}
					else
					{
						if (strpos ($f_dot_part,"@") === false) { $f_data_part = $f_dot_part; }
						else
						{
							$f_at_array = explode ("@",$f_dot_part,2);
							$f_address_parsing = false;
							$f_data_part = $f_at_array[0];
						}

						if (preg_match ("#[\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]#",$f_data_part)) { $f_continue_check = false; }
						$f_data_part = ($f_address_parsing ? "" : $f_at_array[1]);
					}
				}
			}

			if (!strlen ($f_data_part)) { $f_continue_check = false; }

			$f_dot_array = explode (".",$f_data_part);
			$f_data_part = "";

			foreach ($f_dot_array as $f_dot_part)
			{
				if ($f_continue_check)
				{
					if ((strlen ($f_data_part))||($f_dot_part[0] == '['))
					{
						if ((strlen ($f_dot_part) > 1)&&($f_dot_part[(strlen ($f_dot_part) - 1)] == "]"))
						{
							if ((preg_match ("#([\\\\]+)\]$#",$f_dot_part,$f_result_array))&&(strlen ($f_result_array) % 2 == 1)) { $f_data_part .= $f_dot_part; }
							else
							{
								$f_data_part .= $f_dot_part;

								if (preg_match ("#^\[[\\x00-\\x0c\\x0e-\\x7f]+\]$#",$f_data_part)) { $f_data_part = ""; }
								else { $f_continue_check = false; }
							}
						}
						else { $f_data_part .= $f_dot_part; }
					}
					elseif (preg_match ("#[\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]#",$f_dot_part)) { $f_continue_check = false; }
				}
			}
		}
:#\n*/

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterEMail ()- (#echo(__LINE__)#)",:#*/($f_continue_check ? $f_data : "")/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* File pathes should never contain target definitions like directory
	* traversals. We will filter them using "inputfilterFilePath ()".
	*
	* @param  string $f_data Input path
	* @param  boolean $f_uprefs_allowed True to not remove references that
	*         leave the current base directory
	* @return string Filtered output path
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function inputfilterFilePath ($f_data,$f_uprefs_allowed = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterFilePath ($f_data,+f_uprefs_allowed)- (#echo(__LINE__)#)"); }

		$f_return = $this->inputfilterBasic ($f_data);
		$f_return = preg_replace ("#^(\w{3,5})\:\/\/#i","",$f_return);

		$f_return = str_replace ("/./","/",$f_return);
		$f_return = str_replace ("\\","",$f_return);
		$f_return = preg_replace ("#\w\/[\.\/]#","",$f_return);

		if ((!$f_uprefs_allowed)&&($f_return != "."))
		{
			$f_return = preg_replace ("#^[\.\/]+#","",$f_return);
			$f_return = preg_replace ("#[\.\/]+$#","",$f_return);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterFilePath ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Convert to a number-only format.
	*
	* @param  string $f_data Input string
	* @return integer Filtered output integer
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function inputfilterNumber ($f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterNumber ($f_data)- (#echo(__LINE__)#)"); }

/*#ifndef(PHP5n):
		if ($this->PHP_filter_var)
		{
:#\n*/
		$f_return = filter_var ($f_data,FILTER_VALIDATE_FLOAT,(FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_SCIENTIFIC));
		if (is_bool ($f_return)) { $f_return = ""; }
/*#ifndef(PHP5n):
		}
		else { $f_return = ((is_numeric ($f_data)) ? (float)$f_data : ""); }
:#\n*/

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->inputfilterNumber ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Unfortunately we are unable to stop Magic-Quotes-Runtime completely or
	* sometimes it should add slashes to incoming data. The following function
	* will remove these slashes from arrays and strings depending on the
	* Magic-Quotes-Runtime setting.
	*
	* @param mixed &$f_data Input array or string
	* @param boolean $f_force Force input to be stripslashed
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function magicQuotesFilter (&$f_data,$f_force = false)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->magicQuotesFilter (+f_data,+f_force)- (#echo(__LINE__)#)"); }

		if (((INFO_magic_quotes_runtime)||($f_force))&&(!empty ($f_data)))
		{
			if (is_array ($f_data))
			{
				foreach ($f_data as $f_key => $f_value)
				{
					if (is_array ($f_value))
					{
						$this->magicQuotesFilter ($f_value);
						$f_data[$f_key] = $f_value;
					}
					elseif (INFO_magic_quotes_sybase) { $f_data[$f_key] = str_replace ("''","'",$f_value); }
					else { $f_data[$f_key] = stripslashes ($f_value); }
				}
			}
			else { $f_data = (INFO_magic_quotes_sybase ? str_replace ("''","'",$f_data) : stripslashes ($f_data)); }
		}
	}

/**
	* Incoming variables may contain additional slashes as an increasing step for
	* security. Our function "magicQuotesInput ()" will remove these
	* slashes depending on the global setting.
	*
	* @param string &$f_data Input string
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function magicQuotesInput (&$f_data)
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->magicQuotesInput (+f_data)- (#echo(__LINE__)#)"); }
		if ((INFO_magic_quotes_input)&&(!empty ($f_data))) { $f_data = (INFO_magic_quotes_sybase ? str_replace ("''","'",$f_data) : stripslashes ($f_data)); }
	}

/**
	* Reads a file from the memcache or the filesystem. Certain system files are
	* read in on each page call. These small files are stored in the memcache
	* (ramfs on UNIX for example) to increase the read performance.
	*
	* @param  string $f_file_pathname The file (which may also exist in the
	*         memcache)
	* @return mixed Data on success; false on error
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function memcacheGetFile ($f_file_pathname)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFile ($f_file_pathname)- (#echo(__LINE__)#)"); }

		$f_return = false;

		$f_memcache_check = false;
		$f_memcache_pathname = ($direct_settings['swg_memcache_files'] ? $direct_globals['basic_functions']->memcacheGetFilePathName ($f_file_pathname,0) : NULL);

		if (isset ($f_memcache_pathname))
		{
			$f_file_pathname = $f_memcache_pathname;
			$f_memcache_check = true;
		}

		if (($f_memcache_check)||(file_exists ($f_file_pathname))) { $f_return = direct_file_get ("s",$f_file_pathname); }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFile ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads a file from the memcache or the filesystem. Certain system files are
	* read in on each page call. These small files are stored in the memcache
	* (ramfs on UNIX for example) to increase the read performance.
	*
	* @param  string $f_file_pathname The file (which may also exist in the
	*         memcache)
	* @return mixed Data on success; false on error
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function memcacheGetFilePathName ($f_file_pathname,$f_cachelevel = 4)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFile ($f_file_pathname)- (#echo(__LINE__)#)"); }

		$f_return = NULL;

		if ((strlen ($direct_settings['swg_memcache']))&&($direct_settings['swg_memcache_source_code']))
		{
			$f_pathinfo = pathinfo ($f_file_pathname);
			$f_pathinfo['basename'] = md5 ($f_pathinfo['dirname']).".".$f_pathinfo['basename'];
			$f_memcache_check = true;

			if (file_exists ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename']))
			{
				$f_memcache_check = false;
				$f_return = $direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'];
			}

			if (($f_memcache_check)&&($f_cachelevel <= $direct_settings['swg_memcache_source_code']))
			{
				if (file_exists ($f_file_pathname))
				{
					if (@copy ($f_file_pathname,$direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename']))
					{
						chmod ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'],0600);
						$f_return = $direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'];
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFile ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This function uses preparsed XML files to increase performance. Please node
	* that these files are only readable with "serialize ()" and "unserialize ()"
	* implementations of the PHP functions.
	*
	* @param  string $f_file_pathname The XML file (which may also exist in the
	*         memcache)
	* @return mixed Parsed merged XML array on success
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function memcacheGetFileMergedXml ($f_file_pathname)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFileMergedXml ($f_file_pathname)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		$f_return = array ();

		if ((strlen ($direct_settings['swg_memcache']))&&($direct_settings['swg_memcache_merged_xml_files']))
		{
			$f_pathinfo = pathinfo ($f_file_pathname);
			$f_pathinfo['basename'] = md5 ($f_pathinfo['dirname']).".".$f_pathinfo['basename'];

			if (file_exists ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename']))
			{
				$f_continue_check = false;

				$f_file_data = direct_file_get ("s",$direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename']);
				if ($f_file_data) { $f_return = unserialize ($f_file_data); }
			}
		}

		if ($f_continue_check)
		{
			if (file_exists ($f_file_pathname))
			{
				$f_file_data = direct_file_get ("s",$f_file_pathname);

				if ($f_file_data)
				{
					$f_return = $direct_globals['xml_bridge']->xml2array ($f_file_data,false);

					if ((strlen ($direct_settings['swg_memcache']))&&($direct_settings['swg_memcache_merged_xml_files'])&&($f_return))
					{
						$f_file_data = serialize ($f_return);
						if (direct_file_write ($f_file_data,$direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'],"s")) { chmod ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'],0600); }
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheGetFileMergedXml ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Writes data to a file (and deletes the old memcache copy).
	*
	* @param  string $f_data Data string
	* @param  string $f_file_pathname Target file
	* @param  string $f_type Write mode to use. Options: "r", "s", "s0" and "s1"
	*         for ASCII (string); "a", "a0" and "a1" for ASCII (one line per array
	*         element) and "b" for binary. Use "a0" or "s0" to save the content as
	*         it is. "a1" and "s1" add "<?php exit (); ?>" strings but whitespace
	*         characters at the start or end of the file content remain.
	* @return boolean True on success
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function memcacheWriteFile ($f_data,$f_file_pathname,$f_type = "s0")
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheWriteFile (+f_data,$f_file_pathname,$f_type)- (#echo(__LINE__)#)"); }

		if ((strlen ($direct_settings['swg_memcache']))&&(($direct_settings['swg_memcache_files'])||($direct_settings['swg_memcache_merged_xml_files'])))
		{
			$f_pathinfo = pathinfo ($f_file_pathname);
			$f_pathinfo['basename'] = md5 ($f_pathinfo['dirname']).".".$f_pathinfo['basename'];
			if (file_exists ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename'])) { unlink ($direct_settings['swg_memcache']."/".$direct_settings['swg_memcache_id'].".".$f_pathinfo['basename']); }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->memcacheWriteFile ()- (#echo(__LINE__)#)",(:#*/direct_file_write ($f_data,$f_file_pathname,$f_type)/*#ifdef(DEBUG):),true):#*/;
	}

/**
	* Identify a mimetype via the given extension. Warning: Extensions may be
	* altered. Take the needed steps to check the magic string.
	*
	* @param  string $f_extension Input extension string
	* @param  boolean $f_case_insensitive If true the mode will be case
	*         insensitive
	* @return string Identified mimetype string
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function mimetypeExtension ($f_extension,$f_case_insensitive = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->mimetypeExtension ($f_extension,+f_case_insensitive)- (#echo(__LINE__)#)"); }

		if (empty ($this->mimetype_extensions_cache))
		{
			$f_xml_array = $this->memcacheGetFileMergedXml ($direct_settings['path_data']."/settings/swg_mimetype_extensions.xml");
			if ($f_xml_array) { $this->mimetype_extensions_cache = $f_xml_array; }
		}

		if ($f_case_insensitive) { $f_extension = strtolower ($f_extension); }

		if ((isset ($this->mimetype_extensions_cache["swg_mimetype_file_v1_".$f_extension]))&&(!empty ($f_extension))) { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->mimetypeExtension ()- (#echo(__LINE__)#)",:#*/$this->mimetype_extensions_cache["swg_mimetype_file_v1_".$f_extension]['value']/*#ifdef(DEBUG):,true):#*/; }
		else { return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->mimetypeExtension ()- (#echo(__LINE__)#)",:#*/"application/octet-stream"/*#ifdef(DEBUG):,true):#*/; }
	}

/**
	* Return the mimetype icon for the given mimetype.
	*
	* @param  string $f_mimetype Mimetype for the requested icon
	* @param  string $f_file_pathname Mimetype icon definition file
	* @param  boolean $f_case_insensitive If true the mode will be case
	*         insensitive
	* @return string Identified mimetype icon path
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function mimetypeIcon ($f_mimetype,$f_file_pathname = "",$f_case_insensitive = false)
	{
		global $direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->mimetypeIcon ($f_mimetype,$f_file_pathname,+f_case_insensitive)- (#echo(__LINE__)#)"); }

		if (!$f_file_pathname) { $f_file_pathname = $direct_settings['path_data']."/settings/swg_mimetype_icons.xml"; }
		$f_file_md5 = md5 ($f_file_pathname);
		$f_return = "";

		if (isset ($this->mimetype_icons_cache[$f_file_md5])) { $f_icons_array = $this->mimetype_icons_cache[$f_file_md5]; }
		else
		{
			$f_xml_array = $this->memcacheGetFileMergedXml ($f_file_pathname);

			if ($f_xml_array)
			{
				$f_icons_array = array ();

				if (isset ($f_xml_array['swg_mimetype_icons_file_v1_icon']))
				{
					foreach ($f_xml_array['swg_mimetype_icons_file_v1_icon'] as $f_xml_node_array)
					{
						if (isset ($f_xml_node_array['attributes']['mimetype']/*#ifndef(PHP4) */,/* #*//*#ifdef(PHP4):) && isset (:#*/$f_xml_node_array['attributes']['image'])) { $f_icons_array[$f_xml_node_array['attributes']['mimetype']] = $f_xml_node_array['attributes']['image']; }
					}
				}

				$this->mimetype_icons_cache[$f_file_md5] = $f_icons_array;
			}
		}

		if (!empty ($f_icons_array))
		{
			if ($f_case_insensitive) { $f_mimetype = strtolower ($f_mimetype); }
			$f_mimetype_array = explode ("/",$f_mimetype,2);

			if (isset ($f_icons_array[$f_mimetype_array[0]."/".$f_mimetype_array[1]])) { $f_return = $f_icons_array[$f_mimetype_array[0]."/".$f_mimetype_array[1]]; }
			elseif (isset ($f_icons_array[$f_mimetype_array[0]])) { $f_return = $f_icons_array[$f_mimetype_array[0]]; }
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->mimetypeIcon ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Include a required class or initiate an error message if the class does not
	* exist. The process will stop after printing out the error message.
	*
	* @param  string $f_file_pathname Relative path from "swg.php" to the file and
	*         filename
	* @param  integer $f_cachelevel There are three cache levels for system files.
	*         "1" is for always needed files, "2" for often used and "3" for
	*         module specific ones. Level "4" is used to cache module files.
	* @param  boolean $f_once Include a file once only
	* @return boolean True on successful inclusion
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function requireClass ($f_class,$f_cachelevel = 4)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->requireClass ($f_class,$f_cachelevel)- (#echo(__LINE__)#)"); }

		$f_return = $this->includeClass ($f_class,$f_cachelevel);

		if (!$f_return)
		{
			trigger_error ("sWG/#echo(__FILEPATH__)# -basicFunctions->requireClass ()- (#echo(__LINE__)#) reporting: Requested class $f_class not found",E_USER_ERROR);
			direct_class_init ("output");

			if (direct_class_function_check ($direct_globals['output'],"outputSendError"))
			{
				if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->outputSendError ("critical","core_required_object_not_found","FATAL ERROR:<br />&quot;$f_class&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->requireClass ()- (#echo(__LINE__)#)"); }
				else { $direct_globals['output']->outputSendError ("critical","The system could not load a required component.<br /><br />&quot;$f_class&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->requireClass ()- (#echo(__LINE__)#)"); }
			}
			else
			{
				echo ("The system could not load a required component.<br /><br />&quot;$f_class&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -basicFunctions->requireClass ()- (#echo(__LINE__)#)");
				exit ();
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Include a required file or initiate an error message if the file does not
	* exist. The process will stop after printing out the error message.
	*
	* @param  string $f_file_pathname Relative path from "swg.php" to the file and
	*         filename
	* @param  integer $f_cachelevel There are three cache levels for system files.
	*         "1" is for always needed files, "2" for often used and "3" for
	*         module specific ones. Level "4" is used to cache module files.
	* @param  boolean $f_once Include a file once only
	* @return boolean True on successful inclusion
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function requireFile ($f_file_pathname,$f_cachelevel = 4,$f_once = true)
	{
		global $direct_globals;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ($f_file_pathname,$f_cachelevel,+f_once)- (#echo(__LINE__)#)"); }

		$f_return = $this->includeFile ($f_file_pathname,$f_cachelevel,$f_once);

		if (!$f_return)
		{
			trigger_error ("sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#) reporting: Requested file $f_file_pathname not found",E_USER_ERROR);
			direct_class_init ("output");

			if (direct_class_function_check ($direct_globals['output'],"outputSendError"))
			{
				if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->outputSendError ("critical","core_required_object_not_found","FATAL ERROR:<br />&quot;$f_file_pathname&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#)"); }
				else { $direct_globals['output']->outputSendError ("critical","The system could not load a required component.<br /><br />&quot;$f_file_pathname&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#)"); }
			}
			else
			{
				echo ("The system could not load a required component.<br /><br />&quot;$f_file_pathname&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#)");
				exit ();
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->requireFile ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Reads settings from file (XML-encoded) and adds them to $direct_settings.
	*
	* @param  string $f_file_pathname The file containing settings
	* @param  boolean $f_required If the file is required (true) but does
	*         not exist, emergency_mode is called.
	* @param  boolean $f_use_cache False to read a settings file even if it has
	*         already been parsed.
	* @return boolean True on success; false on error
	* @since  v0.1.02
*/
	/*#ifndef(PHP4) */public /* #*/function settingsGet ($f_file_pathname,$f_required = false,$f_use_cache = true)
	{
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->settingsGet ($f_file_pathname,+f_required,+f_use_cache)- (#echo(__LINE__)#)"); }

		$f_continue_check = true;
		$f_return = false;

		if (direct_class_function_check ($direct_globals['xml_bridge'],"xml2array"))
		{
			if (($f_use_cache)&&(in_array ((md5 ($f_file_pathname)),$this->settings_cache)))
			{
				$f_return = true;
				$f_continue_check = false;
			}

			if ($f_continue_check)
			{
				$f_xml_array = $this->memcacheGetFileMergedXml ($f_file_pathname);

				if ($f_xml_array)
				{
					$this->settings_cache[] = md5 ($f_file_pathname);

					foreach ($f_xml_array as $f_key => $f_xml_node_array)
					{
						if (isset ($f_xml_node_array['tag']))
						{
							$f_key = preg_replace ("#swg_settings_file_v(\d+)_#i","",$f_key);
							if ((!isset ($direct_settings[$f_key]))||(strlen ($f_xml_node_array['value']))) { $direct_settings[$f_key] = $f_xml_node_array['value']; }
						}
						elseif (isset ($f_xml_node_array[0]['tag']))
						{
							$f_key = preg_replace ("#swg_settings_file_v(\d+)_#i","",$f_key);
							$direct_settings[$f_key] = array ();

							foreach ($f_xml_node_array as $f_xml_sub_node_array) { $direct_settings[$f_key][] = $f_xml_sub_node_array['value']; }
						}
					}

					$f_return = true;
				}
				elseif ($f_required)
				{
					direct_class_init ("output");

					if (direct_class_function_check ($direct_globals['output'],"outputSendError"))
					{
						if (isset ($direct_local['lang_charset'])) { $direct_globals['output']->outputSendError ("critical","core_required_object_not_found","FATAL ERROR:<br />&quot;$f_file_pathname&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->settingsGet ()- (#echo(__LINE__)#)"); }
						else { $direct_globals['output']->outputSendError ("critical","The system could not load a required component.<br /><br />&quot;$f_file_pathname&quot; was not found","sWG/#echo(__FILEPATH__)# -basicFunctions->settingsGet ()- (#echo(__LINE__)#)"); }
					}
					else
					{
						echo ("The system could not load a required component.<br /><br />&quot;$f_file_pathname&quot; was not found<br /><br />sWG/#echo(__FILEPATH__)# -basicFunctions->settingsGet ()- (#echo(__LINE__)#)");
						exit ();
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->settingsGet ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* Writes the setting array to a file (XML-encoded).
	*
	* @param  array $f_settings Settings array
	* @param  string $f_file_pathname The file containing settings
	* @return boolean True on success; false on error
	* @since  v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function settingsWrite ($f_settings,$f_file_pathname)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->settingsWrite (+f_settings,$f_file_pathname)- (#echo(__LINE__)#)"); }

		$f_return = false;

		$f_xml_object = new directXml ();

		if (($f_continue_check)&&(is_array ($f_settings))&&($f_xml_object))
		{
			$f_xml_object->nodeAdd ("swg_settings_file_v1","",(array ("xmlns" => "urn:de-direct-netware-xmlns:swg.settings.v1")));
			foreach ($f_settings as $f_setting_key => $f_setting_value) { $f_xml_object->nodeAdd ("swg_settings_file_v1 ".(str_replace ("_"," ",$f_setting_key)),$f_setting_value,(array ("xml:space" => "preserve"))); }
			$f_return = $this->memcacheWriteFile ($f_xml_object->cacheExport (),$f_file_pathname);
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->settingsWrite ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* To increase security we are using two additional steps for MD5. All
	* strings will be divided into three parts and reverted to make attacks
	* based on pre-encoded dictionary words against our triple MD5 strings
	* harder. Furthermore "bytemix" data can be applied to each part as a hash.
	*
	* @param  string $f_data String that should be encrypted.
	* @param  string $f_bytemix Binary data hash
	* @return string Encrypted string
	* @since  v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function tmd5 ($f_data,$f_bytemix = "")
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -basicFunctions->tmd5 ($f_data,+f_bytemix)- (#echo(__LINE__)#)"); }

		$f_bytemix_length = strlen ($f_bytemix);
		$f_bytemixing = false;
		$f_data_length = strlen ($f_data);
		$f_data_remaining = strlen ($f_data);
		$f_part_length = round (($f_data_length / 3),0);
		$f_return = "";
		$f_return_length = 0;

		if ($f_bytemix_length)
		{
			$f_bytemixing = true;

			if (($f_part_length * 3) < $f_bytemix_length) { $f_bytemix_length = substr ($f_bytemix,$f_part_length,($f_part_length * 2)); }
			elseif (($f_part_length * 2) < $f_bytemix_length) { $f_bytemix_length = substr ($f_bytemix,0,($f_part_length * 2)); }
			else { $f_bytemix_length = $f_bytemix; }
		}
		else { $f_bytemix_length = ""; }

/* -------------------------------------------------------------------------
We will now divide the string into three parts, revert each of them and put
it together to our result.
------------------------------------------------------------------------- */

		if ($f_data_length)
		{
			$f_part = substr ($f_data,0,$f_part_length);
			$f_return = ($f_bytemixing ? md5 (str_pad ($f_part,$f_data_length,$f_bytemix_length,STR_PAD_LEFT)) : md5 (strrev ($f_part)));

			$f_data_remaining -= $f_part_length;
			$f_return_length += $f_part_length;

			$f_part = substr ($f_data,$f_return_length,$f_part_length);
			$f_return .= ($f_bytemixing ? md5 (str_pad ($f_part,$f_data_length,$f_bytemix_length,STR_PAD_RIGHT)) : md5 (strrev ($f_part)));

			$f_data_remaining -= $f_part_length;
			$f_return_length += $f_part_length;

			$f_part = substr ($f_data,$f_return_length,$f_data_remaining);
			$f_return .= ($f_bytemixing ? md5 (str_pad ($f_part,$f_data_length,$f_bytemix_length,STR_PAD_LEFT)) : md5 (strrev ($f_part)));
		}
		else { $f_return = ""; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->tmd5 ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
	}

/**
	* This function provides access to system wide information saved in variables.
	*
	* SECURITY WARNING: Do NOT use this function in areas where user has access to
	* via input fields or where user defined data is shown!
	*
	* @param  string $f_data Input string
	* @param  string $f_type Access variables of the given type. Available options
	*         are: "cachedata", "local", "output", "settings"
	* @return string Filtered string
	* @since  v0.1.03
*/
	/*#ifndef(PHP4) */public /* #*/function varfilter ($f_data,$f_type = "output")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -basicFunctions->varfilter (+f_data,$f_type)- (#echo(__LINE__)#)"); }

		if (preg_match_all ("#\{var:(\w+)\}#i",$f_data,$f_result_array,PREG_SET_ORDER))
		{
			foreach ($f_result_array as $f_var_array)
			{
				$f_var_array[1] = preg_replace ("#(\W+)#","",$f_var_array[1]);

				if ($f_var_array[1])
				{
					switch ($f_type)
					{
					case "cachedata":
					{
						if ($direct_cachedata[$f_var_array[1]]) { $f_data = str_replace ($f_var_array[0],$direct_cachedata[$f_var_array[1]],$f_data); }
						break 1;
					}
					case "local":
					{
						$f_data = str_replace ($f_var_array[0],(direct_local_get ($f_var_array[1])),$f_data);
						break 1;
					}
					case "settings":
					{
						if ($direct_settings[$f_var_array[1]]) { $f_data = str_replace ($f_var_array[0],$direct_settings[$f_var_array[1]],$f_data); }
						break 1;
					}
					default:
					{
						if ($direct_cachedata["output_".$f_var_array[1]]) { $f_data = str_replace ($f_var_array[0],$direct_cachedata["output_".$f_var_array[1]],$f_data); }
					}
					}
				}
			}
		}

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -basicFunctions->varfilter ()- (#echo(__LINE__)#)",:#*/$f_data/*#ifdef(DEBUG):,true):#*/;
	}
}

/**
* Define a error handler for "trigger_error ()" and "E_USER_NOTICE",
* "E_USER_WARNING" as well as "E_USER_ERROR".
*
* @param  string $f_theme Requested theme
* @return boolean False on error
* @since  v0.1.08
*/
function direct_core_php_error ($f_level,$f_err_msg,$f_err_file = NULL,$f_err_no = NULL,$f_err_context = NULL)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_core_php_error (+f_level,$f_err_msg,+f_err_file,+f_err_no,+f_err_context)- (#echo(__LINE__)#)"); }

	switch ($f_level & (E_USER_NOTICE | E_USER_WARNING | E_USER_ERROR))
	{
	case (E_USER_NOTICE):
	{
		if (USE_debug_reporting_level > 8) { $direct_cachedata['core_error'][] = $f_err_msg; }
		break 1;
	}
	case (E_USER_WARNING):
	{
		if (USE_debug_reporting_level) { $direct_cachedata['core_error'][] = $f_err_msg; }
		break 1;
	}
	case (E_USER_ERROR):
	{
		$direct_cachedata['core_error'][] = $f_err_msg;
		break 1;
	}
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directBasicFunctions",true);

//j// Script specific commands

global $direct_globals,$direct_settings;
$direct_globals['@names']['basic_functions'] = 'dNG\sWG\directBasicFunctions';

if (!isset ($direct_settings['swg_id'])) { $direct_settings['swg_id'] = "BZR"; }

if ((defined ("USE_pre_settings_id"))&&(defined ("USE_pre_settings_memcache"))&&(defined ("USE_pre_settings_memcache_merged_xml_files"))&&(defined ("USE_pre_settings_memcache_source_code")))
{
	$direct_settings['swg_memcache'] = USE_pre_settings_memcache;
	$direct_settings['swg_memcache_id'] = USE_pre_settings_id;
	$direct_settings['swg_memcache_files'] = false;
	$direct_settings['swg_memcache_merged_xml_files'] = USE_pre_settings_memcache_merged_xml_files;
	$direct_settings['swg_memcache_source_code'] = USE_pre_settings_memcache_source_code;
}
else
{
	if (!isset ($direct_settings['swg_memcache'])) { $direct_settings['swg_memcache'] = ""; }
	if (!isset ($direct_settings['swg_memcache_id'])) { $direct_settings['swg_memcache_id'] = $direct_settings['swg_id']; }
	if (!isset ($direct_settings['swg_memcache_files'])) { $direct_settings['swg_memcache_files'] = false; }
	if (!isset ($direct_settings['swg_memcache_merged_xml_files'])) { $direct_settings['swg_memcache_merged_xml_files'] = true; }
	if (!isset ($direct_settings['swg_memcache_source_code'])) { $direct_settings['swg_memcache_source_code'] = 0; }
}

set_error_handler (/*#ifdef(PHP5n) */'dNG\sWG\direct_core_php_error'/* #*//*#ifndef(PHP5n):"direct_core_php_error":#*//*#ifndef(PHP4) */,(E_USER_NOTICE | E_USER_WARNING | E_USER_ERROR)/* #*/);
}

//j// EOF
?>