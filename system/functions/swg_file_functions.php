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
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/*#use(direct_use) */
use dNG\sWG\directFileFunctions;

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
* @param  string $f_file_pathname File path
* @return mixed False on error
* @since  v0.1.01
*/
function direct_file_get ($f_type,$f_file_pathname)
{
	global $direct_cachedata,$direct_globals;
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_file_get ($f_type,$f_file_pathname)- (#echo(__LINE__)#)"); }

	$f_return = false;

	if (file_exists ($f_file_pathname))
	{
		$f_file = new directFileFunctions ();

		if ($f_type == "b") { $f_file->open ($f_file_pathname,true,"rb"); }
		else { $f_file->open ($f_file_pathname,true,"r"); }

		if ($f_file->resourceCheck ())
		{
			$f_file_content = $f_file->read (0);
			$f_file->close ();

			if (is_string ($f_file_content))
			{
				if ($f_type != "b")
				{
					$f_return = "";
					$f_file_content = str_replace ("\r","",$f_file_content);

					if (INFO_magic_quotes_runtime) { $direct_globals['basic_functions']->magicQuotesFilter ($f_file_content); }

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
	else { trigger_error ("sWG/#echo(__FILEPATH__)# -direct_file_get ()- (#echo(__LINE__)#) reporting: Failed opening $f_file_pathname - file does not exist",E_USER_WARNING); }

	return $f_return;
}

/**
* The following function will save given data (as $f_data) to a file.
*
* @param  mixed $f_data Data to write (array or string)
* @param  string $f_file_pathname File path
* @param  string $f_type Write mode to use. Options: "r", "s", "s0" and "s1"
*         for ASCII (string); "a", "a0" and "a1" for ASCII (one line per array
*         element) and "b" for binary. Use "a0" or "s0" to save the content as
*         it is. "a1" and "s1" add "<?php exit (); ?>" strings but whitespace
*         characters at the start or end of the file content remain.
* @return boolean True on success
* @since  v0.1.01
*/
function direct_file_write ($f_data,$f_file_pathname,$f_type = "")
{
	if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -direct_file_write (+f_data,$f_file_pathname,$f_type)- (#echo(__LINE__)#)"); }

	$f_file_content = (is_array ($f_data) ? implode ("\n",$f_data) : $f_data);
	if (($f_type == "a")||($f_type == "r")||($f_type == "s")) { $f_file_content = trim ($f_file_content); }

	$f_file = new directFileFunctions ();

	if ($f_type == "b") { $f_file->open ($f_file_pathname,false,"wb"); }
	else { $f_file->open ($f_file_pathname,false,"w"); }

	if (($f_type == "a0")||($f_type == "b")||($f_type == "s0")) { $f_file->write ($f_file_content); }
	else { $f_file->write ("<?php exit (); ?>\n".$f_file_content); }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_file_write ()- (#echo(__LINE__)#)",(:#*/$f_file->close ()/*#ifdef(DEBUG):),true):#*/;
}

//j// EOF
?>