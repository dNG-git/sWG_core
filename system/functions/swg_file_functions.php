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
* This file contains functions to read and write local files.
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

//f// direct_file_get ($f_type,$f_file_path)
/**
* Let's work with files - use "direct_file_get ()" to get content from a local
* file. A time check will stop the reading process before a script timeout
* occurs.
*
* @param  string $f_type Read mode to use. Options: "r", "s", "s0" and "s1"
*         for ASCII (string); "a", "a0" and "a1" for ASCII (one line per array
*         element) and "b" for binary. Use "a0" or "s0" to return the content
*         as it is. "a1" and "s1" remove "<?php exit (); ?>" strings but
*         whitespace characters at the start or end of the file content
*         remain.
* @param  string $f_file_path File path
* @uses   direct_debug()
* @uses   direct_basic_functions::magic_quotes_filter()
* @uses   direct_file_functions::close()
* @uses   direct_file_functions::open()
* @uses   direct_file_functions::read()
* @uses   direct_file_functions::resource_check()
* @uses   USE_debug_reporting
* @return mixed False on error
* @since  v0.1.01
*/
function direct_file_get ($f_type,$f_file_path)
{
	global $direct_cachedata,$direct_classes;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_file_get ($f_type,$f_file_path)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (file_exists ($f_file_path))
	{
		$f_file = new direct_file_functions ();

		if ($f_type == "b") { $f_file->open ($f_file_path,true,"rb"); }
		else { $f_file->open ($f_file_path,true,"r"); }

		if ($f_file->resource_check ())
		{
			$f_file_content = $f_file->read (0);
			$f_file->close ();

			if (is_string ($f_file_content))
			{
				if ($f_type != "b")
				{
					$f_return = "";
					$f_file_content = str_replace ("\r","",$f_file_content);

					if (INFO_magic_quotes_runtime) { $direct_classes['basic_functions']->magic_quotes_filter ($f_file_content); }

					if (($f_type != "a0")&&($f_type != "s0"))
					{
						$f_file_content = preg_replace ("#^<\?php exit(.*?); \?>\n#i","",$f_file_content);
						if (($f_type != "a1")&&($f_type != "s1")) { $f_file_content = trim ($f_file_content); }
					}
				}

				if (($f_type == "a")||($f_type == "a0")||($f_type == "a1")) { $f_return = ($f_file_content ? explode ("\n",$f_file_content) : array ()); }
				else { $f_return = $f_file_content; }
			}
		}
	}
	else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_file_get ()- (#echo(__LINE__)#) reporting: Failed opening $f_file_path - file does not exist",E_USER_WARNING); }

	return $f_return;
}

//f// direct_file_write ($f_data,$f_file_path,$f_type = "")
/**
* The following function will save given data (as $f_data) to a file.
*
* @param  mixed $f_data Data to write (array or string)
* @param  string $f_file_path File path
* @param  string $f_type Write mode to use. Options: "r", "s", "s0" and "s1"
*         for ASCII (string); "a", "a0" and "a1" for ASCII (one line per array
*         element) and "b" for binary. Use "a0" or "s0" to save the content as
*         it is. "a1" and "s1" add "<?php exit (); ?>" strings but whitespace
*         characters at the start or end of the file content remain.
* @uses   direct_debug()
* @uses   direct_file_functions::close()
* @uses   direct_file_functions::open()
* @uses   direct_file_functions::write()
* @uses   USE_debug_reporting
* @return boolean True on success
* @since  v0.1.01
*/
function direct_file_write ($f_data,$f_file_path,$f_type = "")
{
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_file_write (+f_data,$f_file_path,$f_type)- (#echo(__LINE__)#)"); }

	$f_file_content = (is_array ($f_data) ? implode ("\n",$f_data) : $f_data);
	if (($f_type == "a")||($f_type == "r")||($f_type == "s")) { $f_file_content = trim ($f_file_content); }

	$f_file = new direct_file_functions ();

	if ($f_type == "b") { $f_file->open ($f_file_path,false,"wb"); }
	else { $f_file->open ($f_file_path,false,"w"); }

	if (($f_type == "a0")||($f_type == "b")||($f_type == "s0")) { $f_file->write ($f_file_content); }
	else { $f_file->write ("<?php exit (); ?>\n".$f_file_content); }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_file_write ()- (#echo(__LINE__)#)",(:#*/$f_file->close ()/*#ifdef(DEBUG):),true):#*/;
}

//j// Script specific commands

$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_file_functions.php",1);

//j// EOF
?>