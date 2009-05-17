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
$Id: swg_phpback.php,v 1.14 2008/12/14 20:33:44 s4u Exp $
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* We want to support as many versions of PHP as possible. This file implements
* some functions that are available on newer PHP versions only.
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

if (!@function_exists ("array_map"))
{
	//f// array_map ()
/**
	* "array_map ()" has been added (the first time) to PHP 4.0.6.
	*
	* php.net: Applies the callback to the elements of the given arrays.
	*
	* array array_map ( callback $callback , array $arr1 [, array $... ] )
	*
	* @return array Result array
	* @since  v0.1.08
*/
	function array_map ()
	{
		$f_args_array = func_get_args ();
		$f_args = array ();

		if (count ($f_args_array) > 1)
		{
			$f_function = $f_args_array[0];
			$f_return = $f_args_array[1];
			unset ($f_args_array[0]);
			unset ($f_args_array[1]);

			array_walk ($f_return,$f_function,$f_args_array);
			return $f_return;
		}

		return NULL;
	}
}

if (!@function_exists ("call_user_func"))
{
	//f// call_user_func ()
/**
	* "call_user_func ()" is not available on Quercus (Resin 3.0.21). WARNING!
	* This function might be a security risk for your system.
	*
	* php.net: Call a user function given by the first parameter
	*
	* mixed call_user_func ( callback $function [, mixed $parameter
	* [, mixed $...]] )
	*
	* function
	* The function to be called. Class methods may also be invoked statically
	* using this function by passing array($classname, $methodname) to this
	* parameter.
	*
	* parameter
	* Zero or more parameters to be passed to the function.
	*
	* @return mixed Returned value from the function
	* @since  v0.1.05
*/
	function call_user_func ()
	{
		global $direct_settings;
		$f_return = false;

		if (!$direct_settings['swg_phpback_secure_functions_only'])
		{
			$f_args_array = func_get_args ();
			$f_args = "";

			if (count ($f_args_array) > 1)
			{
				foreach ($f_args_array as $f_key => $f_value)
				{
					if ($f_key)
					{
						if ($f_args) { $f_args .= ","; }
						$f_args .= "\$f_args_array[{$f_key}]";
					}
				}
			}

			if ((count ($f_args_array) > 0)&&(strpos ($f_args_array[0],";") === false))
			{
				if (strlen ($f_args))
				{
					if (is_array ($f_args_array[0])) { return eval ("\$f_args_array[0][0]->{$f_args_array[0][1]} ($f_args);"); }
					else { return eval ($f_args_array[0]." ($f_args);"); }
				}
				else
				{
					if (is_array ($f_args_array[0])) { return eval ("\$f_args_array[0][0]->{$f_args_array[0][1]} ();"); }
					else { return eval ($f_args_array[0]." ();"); }
				}
			}
		}

		return $f_return;
	}
}

if (!@function_exists ("mb_internal_encoding"))
{
	//f// mb_internal_encoding ($f_encoding = "")
/**
	* "mb_internal_encoding ()" is an optional function to handle multibyte
	* strings. This implementation is NOT compatible with multibyte strings and
	* things will probably break in connection with UTF-8 or similar encoded 
	* strings.
	*
	* php.net: Set/Get internal character encoding
	*
	* mb_internal_encoding ([ string $encoding  ] )
	*
	* @param  string $f_encoding Character encoding name to be used
	* @return mixed Returns "phpback" as the current encoding if $f_encoding was
	*         empty or true (even if the setting has not been changed)
	* @since  v0.1.08
*/
	function mb_internal_encoding ($f_encoding = "")
	{
		if (strlen ($f_encoding)) { return "phpback"; }
		else { return true; }
	}
}

if (!@function_exists ("mb_substr"))
{
	//f// mb_substr ($f_data,$f_offset,$f_length = NULL,$f_encoding = "")
/**
	* "mb_substr ()" is an optional function to handle multibyte strings. This
	* implementation is NOT compatible with multibyte strings and things will
	* probably break in connection with UTF-8 or similar encoded strings.
	*
	* php.net: Performs a multi-byte safe substr() operation based on number of
	* characters. Position is counted from the beginning of str. First
	* character's position is 0. Second character position is 1, and so on.
	*
	* mb_substr ( string $str , int $start [, int $length [, string $encoding ]] )
	*
	* @param  string $f_data Input string
	* @param  integer $f_offset String offset
	* @param  integer $f_length Substring length
	* @param  string $f_encoding Character encoding name to be used
	* @return string Returns the substring
	* @since  v0.1.08
*/
	function mb_substr ($f_data,$f_offset,$f_length = NULL,$f_encoding = "")
	{
		if ($f_length === NULL) { return substr ($f_data,$f_offset); }
		else { return substr ($f_data,$f_offset,$f_length); }
	}
}

if (!@function_exists ("md5_file"))
{
	//f// md5_file ($f_fileaddr)
/**
	* "md5_file ()" has been added (the first time) to PHP 4.2.0. The optional
	* parameter for "raw" output (available since PHP 5.0.0) is not supported.
	*
	* php.net: Calculates the MD5 hash of the file specified by the filename
	* parameter using the >> RSA Data Security, Inc. MD5 Message-Digest Algorithm,
	* and returns that hash. The hash is a 32-character hexadecimal number.
	*
	* string md5_file ( string $f_fileaddr )
	*
	* @param  string $f_fileaddr The filename
	* @return mixed Returns a string on success, FALSE otherwise.
	* @since  v0.1.01
*/
	function md5_file ($f_fileaddr)
	{
		$f_return = direct_getfile ("b",$f_fileaddr);
		if ((is_string ($f_return))&&($f_return)) { $f_return = md5 ($f_return); }

		return $f_return;
	}
}

if (!@function_exists ("scandir"))
{
	//f// scandir ($f_dir,$f_sorting_reverse = 0)
/**
	* "scandir ()" has been added (the first time) to PHP 5.0.0. The optional
	* parameter to define a context stream is not supported.
	*
	* php.net: List files and directories inside the specified path
	*
	* array scandir ( string $f_dir [, int $f_sorting_reverse] )
	*
	* @param  string $f_dir The directory that will be scanned.
	* @param  integer $f_sorting_reverse By default, the sorted order is
	*         alphabetical in ascending order. If the optional sorting_order is
	*         used (set to 1), then the sort order is alphabetical in descending
	*         order.
	* @return mixed Returns an array of filenames on success, or FALSE on failure.
	* @since  v0.1.03
*/
	function scandir ($f_dir,$f_sorting_reverse = 0)
	{
		$f_return = false;

		$f_dir_pointer = @opendir ($f_dir);

		if ($f_dir_pointer)
		{
			$f_return = array ();
			while ($f_dir = readdir ($f_dir_pointer)) { $f_return[] = $f_dir; }

			if ($f_sorting_reverse) { rsort ($f_return); }
			else { sort ($f_return); }

			closedir ($f_dir_pointer);
		}

		return $f_return;
	}
}

if (!@function_exists ("mysql_real_escape_string"))
{
	//f// mysql_real_escape_string ($f_data,$f_rp = "unused")
/**
	* "mysql_real_escape_string ()" has been added (the first time) to PHP 4.3.0
	*
	* php.net: Escapes special characters in a string for use in a SQL statement
	*
	* string mysql_real_escape_string ( string $f_data [, resource $f_rp] )
	*
	* @param  string $f_data The string that is to be escaped.
	* @param  mixed $f_rp The MySQL connection. This phpback function ignores
	*         this parameter.
	* @return mixed Returns the escaped string, or FALSE on error.
	* @since  v0.1.03
*/
	function mysql_real_escape_string ($f_data,$f_rp = "unused") { return mysql_escape_string ($f_data); }
}

if (!@function_exists ("stream_set_blocking"))
{
	//f// stream_set_blocking ($f_rp,$f_mode)
/**
	* "stream_set_blocking ()" has been added (the first time) to PHP 4.3.0
	* It's former name was "socket_set_blocking ()". This function is not
	* available on Quercus (Resin 3.0.21).
	*
	* php.net: Set blocking/non-blocking mode on a stream
	*
	* bool stream_set_blocking ( resource $f_rp, int $f_mode )
	*
	* @param  resource $f_rp Affected stream
	* @param  integer $f_mode If mode is 0, the given stream will be switched to
	*         non-blocking mode, and if 1, it will be switched to blocking mode.
	*         This affects calls like fgets() and fread() that read from the
	*         stream. In non-blocking mode an fgets() call will always return
	*         right away while in blocking mode it will wait for data to become
	*         available on the stream.
	* @return boolean Returns TRUE on success or FALSE on failure.
	* @since  v0.1.01
*/
	function stream_set_blocking ($f_rp,$f_mode)
	{
		if (function_exists ("socket_set_blocking")) { return socket_set_blocking ($f_rp,$f_mode); }
	}
}

if (!@function_exists ("stream_set_timeout"))
{
	//f// stream_set_timeout ($f_rp,$f_sec,$f_msec = 0)
/**
	* "stream_set_timeout ()" has been added (the first time) to PHP 4.3.0
	* It's former name was "socket_set_timeout ()". This function is not
	* available on Quercus (Resin 3.0.21).
	*
	* php.net: Set timeout period on a stream
	*
	* bool stream_set_timeout ( resource $f_rp, int $f_sec [, int $f_msec] )
	*
	* @param  resource $f_rp Affected stream
	* @param  integer $f_sec Seconds until a timeout occurs.
	* @param  integer $f_msec Microseconds until a timeout occurs.
	* @return boolean Returns TRUE on success or FALSE on failure.
	* @since  v0.1.01
*/
	function stream_set_timeout ($f_rp,$f_sec,$f_msec = 0)
	{
		if (function_exists ("socket_set_timeout")) { return socket_set_timeout ($f_rp,$f_sec,$f_msec); }
	}
}

//j// EOF
?>