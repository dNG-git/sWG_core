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
* @since      v0.1.01
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
/*#ifdef(PHP4):

if (!@function_exists ("array_map"))
{
/**
	* "array_map ()" has been added (the first time) to PHP 4.0.6.
	*
	* php.net: Applies the callback to the elements of the given arrays.
	*
	* array array_map ( callback $callback , array $arr1 [, array $... ] )
	*
	* @return array Result array
	* @since  v0.1.08
*\/
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
*\/
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
				if (strlen ($f_args)) { return (is_array ($f_args_array[0]) ? eval ("\$f_args_array[0][0]->{$f_args_array[0][1]} ($f_args);") : eval ($f_args_array[0]." ($f_args);")); }
				else { return (is_array ($f_args_array[0]) ? eval ("\$f_args_array[0][0]->{$f_args_array[0][1]} ();") : eval ($f_args_array[0]." ();")); }
			}
		}

		return $f_return;
	}
}
:#*/
if (!@function_exists ("mb_convert_encoding"))
{
/**
	* "mb_convert_encoding ()" is an optional function to handle multibyte
	* strings. This implementation does only call "utf8_encode ()" and
	* "utf8_decode ()" if applicable for the defined encoding definitions.
	*
	* php.net: Converts the character encoding of string str to to_encoding from
	* optionally from_encoding.
	*
	* mb_convert_encoding ( string $str , string $to_encoding
	* [, mixed $from_encoding ] )
	*
	* @param  string $f_data Input string
	* @param  string $f_to The type of encoding the string is being converted
	*         to.
	* @param  mixed $f_from Is specified by character code names before
	*         conversion.
	* @return string Returns the string
	* @since  v0.1.08
*/
	function mb_convert_encoding ($f_data,$f_to,$f_from = NULL)
	{
		if ((strtoupper ($f_to) == "UTF-8")&&(($f_from == NULL)||(($f_from != "auto")&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_from,"UTF-8") === false)))) { return utf8_encode ($f_data); }
		elseif ((strtoupper ($f_to) != "UTF-8")&&($f_from != NULL)&&(($f_from == "auto")||(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/ ($f_from,"UTF-8") !== false))) { return utf8_decode ($f_data); }
		else { return $f_data; }
	}
}

if (!@function_exists ("mb_internal_encoding"))
{
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
	function mb_internal_encoding ($f_encoding = "") { return (strlen ($f_encoding) ? "phpback" : true); }
}

if (!@function_exists ("mb_send_mail"))
{
/**
	* "mb_send_mail ()" is an optional function to handle multibyte strings. This
	* implementation is NOT compatible with multibyte strings and things will
	* probably break in connection with UTF-8 or similar encoded strings.
	*
	* php.net: Send encoded mail
	*
	* mb_send_mail ( string $to , string $subject , string $message
	* [, string $additional_headers = NULL
	* [, string $additional_parameter = NULL ]] )
	*
	* @param  string $f_recipients Recipients
	* @param  string $f_subject Title of the eMail
	* @param  string $f_email_content eMail content
	* @param  string $f_email_headers Additional headers
	* @param  string $f_email_parameters Additional parameters
	* @return boolean True on success
	* @since  v0.1.08
*/
	function mb_send_mail ($f_data,$f_encoding = "") { return mail ($f_recipients,$f_subject,$f_email_content,$f_email_headers,$f_email_parameters); }
}

if (!@function_exists ("mb_strlen"))
{
/**
	* "mb_strlen ()" is an optional function to handle multibyte strings. This
	* implementation is NOT compatible with multibyte strings and things will
	* probably break in connection with UTF-8 or similar encoded strings.
	*
	* php.net: Get string length
	*
	* mb_strlen ( string $str [, string $encoding ] )
	*
	* @param  string $f_data Input string 
	* @param  string $f_encoding Character encoding name to be used
	* @return integer Returns the string length
	* @since  v0.1.08
*/
	function mb_strlen ($f_data,$f_encoding = "") { return strlen ($f_data); }
}

if (!@function_exists ("mb_strpos"))
{
/**
	* "mb_strpos ()" is an optional function to handle multibyte strings. This
	* implementation is NOT compatible with multibyte strings and things will
	* probably break in connection with UTF-8 or similar encoded strings.
	*
	* php.net: Find position of first occurrence of string in a string
	*
	* mb_substr ( string $haystack , string $needle [, int $offset
	* [, string $encoding ]] )
	*
	* @param  string $f_data Input string
	* @param  string $f_search_value Search value
	* @param  integer $f_offset String offset
	* @param  string $f_encoding Character encoding name to be used
	* @return string Returns the substring
	* @since  v0.1.08
*/
	function mb_strpos ($f_data,$f_search_value,$f_offset = NULL,$f_encoding = "") { return (($f_offset === NULL) ? strpos ($f_data,$f_search_value) : strpos ($f_data,$f_search_value,$f_offset)); }
}

if (!@function_exists ("mb_substr"))
{
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
	function mb_substr ($f_data,$f_offset,$f_length = NULL,$f_encoding = "") { return (($f_length === NULL) ? substr ($f_data,$f_offset) : substr ($f_data,$f_offset,$f_length)); }
}
/*#ifdef(PHP4):

if (!@function_exists ("md5_file"))
{
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
*\/
	function md5_file ($f_fileaddr)
	{
		$f_return = direct_getfile ("b",$f_fileaddr);
		if ((is_string ($f_return))&&($f_return)) { $f_return = md5 ($f_return); }
		return $f_return;
	}
}

if (!@function_exists ("mysql_real_escape_string"))
{
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
*\/
	function mysql_real_escape_string ($f_data,$f_rp = "unused") { return mysql_escape_string ($f_data); }
}
:#\n*/
/*#ifndef(PHP5n):

if (!@function_exists ("property_exists"))
{
/**
	* "property_exists ()" has been added (the first time) to PHP 5.1.0.
	*
	* php.net: Checks if the object or class has a property.
	*
	* bool property_exists ( mixed $class , string $property )
	*
	* @param  mixed $f_class The class name or an object of the class to test
	*         for.
	* @param  mixed $f_property The name of the property.
	* @return mixed Returns TRUE if the property exists, FALSE if it doesn't
	*         exist or NULL in case of an error.
	* @since  v0.1.08
*\/
	function property_exists ($f_class,$f_property)
	{
		if ((is_string ($f_class))&&(class_exists ($f_class,/*#ifndef(PHP4) *\/false/* #*\/))) { $f_return = array_key_exists ($f_property,(get_class_vars  ($f_class))); }
		elseif (is_object ($f_class)) { $f_return = (((isset ($f_class->$f_property))||(is_null ($f_class->$f_property))) ? true : false); }
		else { $f_return = NULL; }

		return $f_return;
	}
}
:#\n*/
/*#ifdef(PHP4):

if (!@function_exists ("scandir"))
{
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
*\/
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

if (!@function_exists ("stream_set_blocking"))
{
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
*\/
	function stream_set_blocking ($f_rp,$f_mode) { return (function_exists ("socket_set_blocking") ? socket_set_blocking ($f_rp,$f_mode) : false); }
}

if (!@function_exists ("stream_set_timeout"))
{
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
*\/
	function stream_set_timeout ($f_rp,$f_sec,$f_msec = 0) { return (function_exists ("socket_set_timeout") ? socket_set_timeout ($f_rp,$f_sec,$f_msec) : false); }
}
:#\n*/
/*#ifndef(PHP5n):

if (!@function_exists ("sys_get_temp_dir"))
{
/**
	* "sys_get_temp_dir ()" has been added (the first time) to PHP 5.2.1.
	*
	* php.net: Returns the path of the directory PHP stores temporary files in by
	* default. 
	*
	* string sys_get_temp_dir ( void )
	*
	* @return boolean Returns the path of the temporary directory.
	* @since  v0.1.10
*\/
	function sys_get_temp_dir ()
	{
		$f_return = get_cfg_var ("upload_tmp_dir");
		return (is_bool ($f_return) ? ini_get ("upload_tmp_dir") : $f_return);
	}
}
:#*/
//j// EOF
?>