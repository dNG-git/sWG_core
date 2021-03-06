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
* Provides functions to create and test directories as well as the given
* rights. 
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
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
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

/**
* Creates a directory (or returns the status of direct_dir_is_writable if it
* exists). Use slashes - even on Microsoft(R) Windows(R) machines.
*
* @param  string $f_dir_path Path to the new directory.
* @param  boolean $f_recursive True to create all missing directories
*         recursively
* @param  integer $f_timeout Timeout to use
* @return boolean True on success
* @since  v0.1.03
*/
function direct_dir_create ($f_dir_path,$f_recursive = true,$f_timeout = -1)
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_dir_create ($f_dir_path,+f_recursive,$f_timeout)- (#echo(__LINE__)#)"); }

	$f_dir_path = preg_replace ("#\/$#","",$f_dir_path);

	if ((!strlen ($f_dir_path))||($f_dir_path == ".")) { $f_return = false; }
	elseif (direct_dir_is_writable ($f_dir_path)) { $f_return = true; }
	elseif (direct_dir_exists ($f_dir_path)) { $f_return = false; }
	else
	{
		$f_continue_check = true;
		$f_return = false;
		$f_timeout_time = (($f_timeout < 0) ? ($direct_cachedata['core_time'] + $direct_settings['timeout']) : ($direct_cachedata['core_time'] + $f_timeout));

		$f_dir_array = explode ("/",$f_dir_path);
		$f_dir_count = count ($f_dir_array);

		if ($f_dir_count > 1)
		{
			array_pop ($f_dir_array);
			$f_dir_basepath = implode ("/",$f_dir_array);
			$f_continue_check = ($f_recursive ? direct_dir_create ($f_dir_basepath) : direct_dir_is_writable ($f_dir_basepath));
		}

		if (($f_continue_check)&&($f_timeout_time > (time ())))
		{
			if ($direct_settings['swg_umask_change']) { umask (intval ($direct_settings['swg_umask_change'],8)); }

			$f_chmod = (strlen ($direct_settings['swg_chmod_dirs_change']) ? intval ($direct_settings['swg_chmod_dirs_change'],8) : 0750);
			$f_continue_check = @mkdir ($f_dir_path,$f_chmod);
			$f_dir_id = md5 ($f_dir_path);

			if ($f_continue_check)
			{
				if (isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id])) { unset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]); }
				$f_return = direct_dir_is_writable ($f_dir_path);
			}
			else
			{
$direct_cachedata['core_dir_functions_data'][$f_dir_id] = array (
"exists" => false,
"readable" => false,
"writable" => false
);
			}
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_dir_create ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Check if a directory exist and is readable for the current PHP process.
*
* @param  string $f_dir_path Path to the directory.
* @return boolean True on success
* @since  v0.1.03
*/
function direct_dir_exists ($f_dir_path)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_dir_exists ($f_dir_path)- (#echo(__LINE__)#)"); }

	$f_dir_path = preg_replace ("#\/$#","",$f_dir_path);
	$f_dir_id = md5 ($f_dir_path);

	$f_readable_check = false;
	$f_return = false;

	if ((isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]))&&(is_array ($direct_cachedata['core_dir_functions_data'][$f_dir_id]))) { $f_return = $direct_cachedata['core_dir_functions_data'][$f_dir_id]['exists']; }
	else
	{
		$direct_cachedata['core_dir_functions_data'][$f_dir_id] = array ();

		if ((file_exists ($f_dir_path))&&(is_dir ($f_dir_path)))
		{
			$f_return = true;
			$f_readable_check = is_readable ($f_dir_path);
		}

		if (($f_return)&&($f_readable_check))
		{
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['exists'] = true;
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['readable'] = true;
		}
		elseif ($f_return)
		{
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['exists'] = true;
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['readable'] = false;
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['writable'] = false;
		}
		else
		{
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['exists'] = false;
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['readable'] = false;
			$direct_cachedata['core_dir_functions_data'][$f_dir_id]['writable'] = false;
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_dir_exists ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

/**
* Check if a directory is readable for the current PHP process.
*
* @param  string $f_dir_path Path to the directory.
* @return boolean True on success
* @since  v0.1.03
*/
function direct_dir_is_readable ($f_dir_path)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_dir_is_readable ($f_dir_path)- (#echo(__LINE__)#)"); }

	$f_dir_path = preg_replace ("#\/$#","",$f_dir_path);
	$f_dir_id = md5 ($f_dir_path);

	if (!isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id])) { direct_dir_exists ($f_dir_path); }
	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_dir_is_readable ()- (#echo(__LINE__)#)",:#*/$direct_cachedata['core_dir_functions_data'][$f_dir_id]['readable']/*#ifdef(DEBUG):,true):#*/;
}

/**
* Check if a directory is writable for the current PHP process.
*
* @param  string $f_dir_path Path to the directory.
* @return boolean True on success
* @since  v0.1.03
*/
function direct_dir_is_writable ($f_dir_path)
{
	global $direct_cachedata;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_dir_is_writable ($f_dir_path)- (#echo(__LINE__)#)"); }

	$f_dir_path = preg_replace ("#\/$#","",$f_dir_path);
	$f_dir_id = md5 ($f_dir_path);

	if (!isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id])) { direct_dir_exists ($f_dir_path); }
	if (!isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]['writable'])) { $direct_cachedata['core_dir_functions_data'][$f_dir_id]['writable'] = is_writable ($f_dir_path); }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_dir_is_writable ()- (#echo(__LINE__)#)",:#*/$direct_cachedata['core_dir_functions_data'][$f_dir_id]['writable']/*#ifdef(DEBUG):,true):#*/;
}

/**
* Removes a directory optionally including all subfolders and -files. Use
* slashes - even on Microsoft(R) Windows(R) machines.
*
* @param  string $f_dir_path Path to the new directory.
* @param  boolean $f_recursive True to remove everything recursively
* @param  integer $f_timeout Timeout to use
* @return boolean True on success
* @since  v0.1.08
*/
function direct_dir_remove ($f_dir_path,$f_recursive = true,$f_timeout = -1)
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_dir_remove ($f_dir_path,+f_recursive,$f_timeout)- (#echo(__LINE__)#)"); }

	$f_dir_path = preg_replace ("#\/$#","",$f_dir_path);

	if ((!strlen ($f_dir_path))||($f_dir_path == ".")) { $f_return = false; }
	elseif (!direct_dir_exists ($f_dir_path)) { $f_return = true; }
	else
	{
		$f_dir_pointer = @opendir ($f_dir_path);
		$f_return = false;
		$f_timeout_time = (($f_timeout < 0) ? ($direct_cachedata['core_time'] + $direct_settings['timeout']) : ($direct_cachedata['core_time'] + $f_timeout));

		if ($f_dir_pointer)
		{
			$f_return = true;

			while (($f_return)&&($f_dir = readdir ($f_dir_pointer))&&($f_timeout_time > (time ())))
			{
				if (($f_dir != ".")&&($f_dir != ".."))
				{
					if (is_dir ($f_dir_path."/".$f_dir)) { $f_return = direct_dir_remove ($f_dir_path."/".$f_dir,$f_recursive,$f_timeout); }
					else { $f_return = @unlink ($f_dir_path."/".$f_dir); }

					$f_dir_id = md5 ($f_dir_path."/".$f_dir);
					if (($f_return)&&(isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]))) { unset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]); }
				}
			}

			closedir ($f_dir_pointer);
			if ($f_timeout_time <= (time ())) { $f_return = false; }
		}

		if ($f_return)
		{
			$f_dir_id = md5 ($f_dir_path);
			$f_return = @rmdir ($f_dir_path);
			if (($f_return)&&(isset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]))) { unset ($direct_cachedata['core_dir_functions_data'][$f_dir_id]); }
		}
	}

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_dir_remove ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

$direct_cachedata['core_dir_functions_data'] = array ();

//j// EOF
?>