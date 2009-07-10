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
* Creates links including uuID, "lang" variable and other useful information.
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
* @since      v0.1.02
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

//f// direct_linker ($f_type,$f_data,$f_ampconvert = true,$f_withuuid = true)
/**
* Using "direct_linker ()" will allow you to link local sWG pages easier. You
* may use internal links "swg.php?...", external links
* "http://localhost/swg.php?...", input (hidden) forms or an URL, replacing
* parts of it if it's larger than x characters. This function uses "Shadow"
* URLs to be search engine friendly if applicable.
*
* @param  string $f_type Linking mode: "url0" for internal links, "url1" for
*         external ones, "form" to create hidden fields or "optical" to remove
*         parts of a very long string.
* @param  string $f_data Query string
* @param  boolean $f_ampconvert True to append "amp;" to each "&" character
*         (Needed for (X)HTML)
* @param  boolean $f_withuuid True to add the current uuID string to the query
* @uses   direct_debug()
* @uses   direct_html_encode_special()
* @uses   direct_kernel_system::v_uuid_check_usage()
* @uses   direct_linker_dynamic()
* @uses   direct_linker_shadow()
* @uses   USE_debug_reporting
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker ($f_type,$f_data,$f_ampconvert = true,$f_withuuid = true)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker ($f_type,$f_data,+f_ampconvert,+f_withuuid)- (#echo(__LINE__)#)"); }

	if ($f_type == "asis") { $f_return = $f_data; }
	elseif ($f_type == "form")
	{
/* -------------------------------------------------------------------------
Get all form data in a string like "<input type='hidden' name='lang'
value='de' />"
------------------------------------------------------------------------- */

		$f_return = "";

		if (strpos ($f_data,"#") !== false)
		{
			if (preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array)) { $f_data = $f_result_array[1]; }
		}

		$f_variables_array = explode ("&",$f_data);

		foreach ($f_variables_array as $f_variable)
		{
			if ($f_variable)
			{
				$f_variable_array = explode ("=",$f_variable,2);
				if ($f_variable_array[0]) { $f_return .= "<input type='hidden' name='{$f_variable_array[0]}' value='{$f_variable_array[1]}' />"; }
			}
		}

/* -------------------------------------------------------------------------
Automatically add language, theme and uuid fields to the form
------------------------------------------------------------------------- */

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false) { $f_return .= "<input type='hidden' name='lang' value='$direct_settings[lang]' />"; }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false) { $f_return .= "<input type='hidden' name='theme' value='$direct_settings[theme]' />"; }

		if (($direct_settings['uuid'])&&($f_withuuid))
		{
			if ((!$direct_classes['kernel']->v_uuid_is_cookied ())&&($direct_classes['kernel']->v_uuid_check_usage ())) { $f_return .= "<input type='hidden' name='uuid' value='$direct_settings[uuid]' />"; }
		}
	}
	elseif ($f_type == "optical")
	{
/* -------------------------------------------------------------------------
A filter is required for really long URLs. First we will have a look at the
"optical maximal length" setting, then if the URL is larger than the setting
------------------------------------------------------------------------- */

		if (strlen ($f_data) > $direct_settings['swg_url_opticalmaxlength'])
		{
			$f_url_array = parse_url ($f_data);

			$f_url_array['url'] = $f_url_array['scheme']."://";
			if ((isset ($f_url_array['user']))||(isset ($f_url_array['pass']))) { $f_url_array['url'] .= $f_url_array['user'].":{$f_url_array['pass']}@"; }
			$f_url_array['url'] .= $f_url_array['host'];

			if (isset ($f_url_array['port'])) { $f_url_array['url'] .= ":".$f_url_array['port']; }

			if (isset ($f_url_array['path']))
			{
				$f_pathinfo = pathinfo ($f_url_array['path']);
				if (substr ($f_url_array['path'],-1) == "/") { $f_pathinfo['basename'] .= "/"; }
				$f_url_array['url'] .= preg_replace ("#{$f_pathinfo['basename']}$#","",$f_url_array['path']);
			}
			else { $f_pathinfo = array ("basename" => ""); }

			if ((isset ($f_url_array['query']))||(isset ($f_url_array['fragment'])))
			{
				$f_length_available = $direct_settings['swg_url_opticalmaxlength'];
				$f_one_eighth = floor (($f_length_available - 3) / 8);
				$f_one_fourth = ($f_one_eighth * 2);
				$f_three_eigths = ($f_length_available - ($f_one_fourth * 2) - $f_one_eighth);

/* -------------------------------------------------------------------------
Now we will find out, how to remove unimportant parts of the given URL
------------------------------------------------------------------------- */

				if (strlen ($f_url_array['url']) < (3 + $f_three_eigths + $f_one_eighth))
				{
/* -------------------------------------------------------------------------
The URL (excluding the file name) is small enough. We will add the whole
string to our result
------------------------------------------------------------------------- */

					$f_return = $f_url_array['url'];
					$f_length_available -= strlen ($f_url_array['url']);
				}
				else
				{
/* -------------------------------------------------------------------------
The source URL is too large - we will strip everything, that's larger than
our projected size
------------------------------------------------------------------------- */

					$f_return = (substr ($f_url_array['url'],0,$f_three_eigths))." ... ".(substr ($f_url_array['url'],(-1 * $f_one_eighth)));
					$f_length_available -= (3 + $f_three_eigths + $f_one_eighth);
				}

/* -------------------------------------------------------------------------
The next few lines will check the size of the filename and remove parts of
it if required
------------------------------------------------------------------------- */

				if (strlen ($f_pathinfo['basename']) < (3 + $f_one_fourth))
				{
/* -------------------------------------------------------------------------
Again, the filename is small enough - no action is required (add it 1 to 1)
------------------------------------------------------------------------- */

					$f_return .= $f_pathinfo['basename'];
					$f_length_available -= strlen ($f_pathinfo['basename']);
				}
				else
				{
/* -------------------------------------------------------------------------
Unfortunately, the filename is too long - we will remove the first part
------------------------------------------------------------------------- */

					$f_return .= " ... ".(substr ($f_pathinfo['basename'],(-1 * $f_one_fourth)));
					$f_length_available -= (3 + $f_one_fourth);
				}

/* -------------------------------------------------------------------------
Our last step is to add the whole or the last part of the query string, once
more depending on the string length
------------------------------------------------------------------------- */

				$f_query = "";
				if (isset ($f_url_array['query'])) { $f_query .= "?".$f_url_array['query']; }
				if (isset ($f_url_array['fragment'])) { $f_query .= "#".$f_url_array['fragment']; }

				if (strlen ($f_query) < (3 + $f_length_available)) { $f_return .= $f_query; }
				else { $f_return .= " ... ".(substr ($f_query,(-1 * $f_length_available))); }
			}
			else
			{
				$f_length_available = $direct_settings['swg_url_opticalmaxlength'];
				$f_one_sixth = floor ($f_length_available / 6);
				$f_one_third = ($f_one_sixth * 2);

/* -------------------------------------------------------------------------
Now we will find out, how to remove unimportant parts of the given URL
------------------------------------------------------------------------- */

				if (strlen ($f_url_array['url']) < (3 + $f_one_third + $f_one_sixth))
				{
/* -------------------------------------------------------------------------
The URL (excluding the file name) is small enough. We will add the whole
string to our result
------------------------------------------------------------------------- */

					$f_return = $f_url_array['url'];
					$f_length_available -= strlen ($f_url_array['url']);
				}
				else
				{
/* -------------------------------------------------------------------------
The source URL is too large - we will strip everything, that's larger than
our projected size
------------------------------------------------------------------------- */

					$f_return = (substr ($f_url_array['url'],0,$f_one_third))." ... ".(substr ($f_url_array['url'],(-1 * $f_one_sixth)));
					$f_length_available -= (3 + $f_one_third + $f_one_sixth);
				}

/* -------------------------------------------------------------------------
The next two lines will check the size of the filename and remove parts of
it if required
------------------------------------------------------------------------- */

				if (strlen ($f_pathinfo['basename']) < (3 + $f_length_available)) { $f_return .= $f_pathinfo['basename']; }
				else { $f_return .= " ... ".(substr ($f_pathinfo['basename'],(-1 * $f_length_available))); }
			}
		}
		else { $f_return = $f_data; }

		return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker ()- (#echo(__LINE__)#)",(:#*/direct_html_encode_special ($f_return)/*#ifdef(DEBUG):),true):#*/;
	}
	else
	{
/* -------------------------------------------------------------------------
There are two possibilities for creating normal links - shadowing them or
not. If shadowed, they may be look like http://localhost/swg_base64data.htm
------------------------------------------------------------------------- */

		if ($direct_settings['swg_shadow_url']) { $f_return = direct_linker_shadow ($f_type,$f_data,$f_withuuid); }
		else { $f_return = direct_linker_dynamic ($f_type,$f_data,$f_ampconvert,$f_withuuid); }
	}

	return $f_return;
}

//f// direct_linker_dynamic ($f_type,$f_data,$f_ampconvert = true,$f_withuuid = true)
/**
* Most URLs have to contain dynamic data like "theme", "lang" and "uuid". They
* will be added automatically through this function. It will be used, if a
* shadow-setting doesn't apply.
*
* @param  string $f_type Linking mode: "url0" for internal links, "url1" for
*         external ones, "form" to create hidden fields or "optical" to remove
*         parts of a very long string.
* @param  string $f_data Query string
* @param  boolean $f_ampconvert True to append "amp;" to each "&" character
*         (Needed for (X)HTML)
* @param  boolean $f_withuuid True to add the current uuID string to the query
* @uses   direct_debug()
* @uses   direct_kernel_system::v_uuid_check_usage()
* @uses   USE_debug_reporting
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker_dynamic ($f_type,$f_data,$f_ampconvert = true,$f_withuuid = true)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker_dynamic ($f_type,$f_data,+f_ampconvert,+f_withuuid)- (#echo(__LINE__)#)"); }

	$f_anchor = "";

	if (strpos ($f_data,"#") !== false)
	{
		if (preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array))
		{
			$f_data = $f_result_array[1];
			$f_anchor = $f_result_array[2];
		}
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false)
	{
		if ($f_data) { $f_data .= "&"; }
		$f_data .= "lang=".$direct_settings['lang'];
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false)
	{
		if ($f_data) { $f_data .= "&"; }
		$f_data .= "theme=".$direct_settings['theme'];
	}

	if (($direct_settings['uuid'])&&($f_withuuid))
	{
		if ((!$direct_classes['kernel']->v_uuid_is_cookied ())&&($direct_classes['kernel']->v_uuid_check_usage ()))
		{
			if ($f_data) { $f_data .= "&"; }
			$f_data .= "uuid=".$direct_settings['uuid'];
		}
	}

/* -------------------------------------------------------------------------
Two types are available: url0 for relative URLs like swg.php?... and url1
for complete URLs like http://localhost/swg.php?...

Setting $f_ampconvert to 1 will create XHTML-conform URLs with &amp; instead
of & seperators
------------------------------------------------------------------------- */

	if ($f_type == "url1")
	{
		$f_return = $direct_settings['iscript_req']."?".$f_data;
		if ($f_ampconvert) { $f_return = str_replace ("&","&amp;",$f_return); }
	}
	else
	{
		$f_return = $direct_settings['iscript_url'].$f_data;
		if ($f_ampconvert) { $f_return = str_replace ("&","&amp;",$f_return); }
	}

	if (strlen ($f_anchor)) { $f_return .= "#".$f_anchor; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker_dynamic ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//f// direct_linker_shadow ($f_type,$f_data,$f_withuuid = true)
/**
* Most URLs have to contain dynamic data like "theme", "lang" and "uuid". They
* will be added automatically through this function. Furthermore
* direct_linker_shadow will create links of the form
* http://localhost/swg_base64data.htm to disguise dynamic pages.
*
* @param  string $f_type Linking mode (currently unused) - same as for
*         "direct_linker ()"
* @param  string $f_data Query string
* @param  boolean $f_withuuid True to add the current uuID string to the query
* @uses   direct_debug()
* @uses   direct_kernel_system::v_uuid_check_usage()
* @uses   USE_debug_reporting
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker_shadow ($f_type,$f_data,$f_withuuid = true)
{
	global $direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker_shadow ($f_type,$f_data,+f_ampconvert,+f_withuuid)- (#echo(__LINE__)#)"); }

	$f_anchor = "";
	$f_return = "";

	if (strpos ($f_data,"#") !== false)
	{
		if (preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array))
		{
			$f_data = $f_result_array[1];
			$f_anchor = $f_result_array[2];
		}
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false)
	{
		if ($f_data) { $f_data .= "&"; }
		$f_data .= "lang=".$direct_settings['lang'];
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false)
	{
		if ($f_data) { $f_data .= "&"; }
		$f_data .= "theme=".$direct_settings['theme'];
	}

	if (($direct_settings['uuid'])&&($f_withuuid))
	{
		if ((!$direct_classes['kernel']->v_uuid_is_cookied ())&&($direct_classes['kernel']->v_uuid_check_usage ()))
		{
			if ($f_data) { $f_data .= "&"; }
			$f_data .= "uuid=".$direct_settings['uuid'];
		}
	}

	$f_variables_array = explode ("&",$f_data);

	if (!empty ($f_variables_array))
	{
		foreach ($f_variables_array as $f_variable)
		{
			$f_variable_array = explode ("=",$f_variable,2);
			if (!empty ($f_variable_array)) { $f_return .= "/{$f_variable_array[0]}-".(urlencode ($f_variable_array[1])); }
		}
	}

	$f_return = $direct_settings['swg_shadow_url'].$f_return;
	$f_return .= "/page.htm";

	if (strlen ($f_anchor)) { $f_return .= "#".$f_anchor; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker_shadow ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

//j// Script specific commands

if ((!isset ($direct_settings['swg_url_opticalmaxlength']))||($direct_settings['swg_url_opticalmaxlength'] < 1)) { $direct_settings['swg_url_opticalmaxlength'] = 75; }

//j// EOF
?>