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
* @since      v0.1.02
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
* @param  boolean $f_html_encode True to append "amp;" to each "&" character
*         (Needed for (X)HTML)
* @param  boolean $f_withuuid True to add the current uuID string to the query
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker ($f_type,$f_data,$f_html_encode = true,$f_withuuid = true)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker ($f_type,$f_data,+f_html_encode,+f_withuuid)- (#echo(__LINE__)#)"); }

	$f_html_filter = array ("<",">","&#60;","&#62;","&lt;","&gt;");

	if ($f_type == "asis")
	{
		$f_return = $f_data;
	}
	elseif ($f_type == "asisuuid")
	{
		$f_uuid = (((isset ($direct_globals['input']))&&($f_withuuid)) ? $direct_globals['input']->uuidGet () : "");
		$f_return = str_replace ("[uuid]",((($f_uuid)&&(!$direct_globals['kernel']->vUuidIsCookied ())&&($direct_globals['kernel']->vUuidCheckUsage ())) ? $f_uuid : ""),$f_data);
	}
	elseif ($f_type == "form")
	{
/* -------------------------------------------------------------------------
Get all form data in a string like "<input type='hidden' name='lang'
value='de' />"
------------------------------------------------------------------------- */

		$f_html_filter = array ("&#60;","&#62;","&lt;","&gt;");
		$f_return = "<input type='hidden' name='ohandler' value=\"{$direct_settings['ohandler']}\" />";

		if (strpos ($f_data,"#") !== false)
		{
			if (preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array)) { $f_data = $f_result_array[1]; }
		}

		$f_variables_array = explode (";",$f_data);

		foreach ($f_variables_array as $f_variable)
		{
			if ($f_variable)
			{
				$f_variable_array = explode ("=",$f_variable,2);
				if (!empty ($f_variable_array)) { $f_return .= "<input type='hidden' name='{$f_variable_array[0]}' value=\"".(isset ($f_variable_array[1]) ? direct_html_encode_special ($f_variable_array[1]) : "")."\" />"; }
			}
		}

/* -------------------------------------------------------------------------
Automatically add language, theme and uuid fields to the form
------------------------------------------------------------------------- */

		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false) { $f_return .= "<input type='hidden' name='lang' value='$direct_settings[lang]' />"; }
		if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false) { $f_return .= "<input type='hidden' name='theme' value='$direct_settings[theme]' />"; }

		if ((isset ($direct_globals['input']))&&($f_withuuid))
		{
			$f_uuid = $direct_globals['input']->uuidGet ();
			if (($f_uuid)&&(!$direct_globals['kernel']->vUuidIsCookied ())&&($direct_globals['kernel']->vUuidCheckUsage ())) { $f_return .= "<input type='hidden' name='uuid' value='$f_uuid' />"; }
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

				$f_return .= ((strlen ($f_pathinfo['basename']) < (3 + $f_length_available)) ? $f_pathinfo['basename'] : " ... ".(substr ($f_pathinfo['basename'],(-1 * $f_length_available))));
			}
		}
		else { $f_return = $f_data; }

		$f_return = direct_html_encode_special ($f_return);
	}
	else { $f_return = (($direct_settings['ihandler'] == "shadow") ? direct_linker_shadow ($f_type,$f_data,$f_withuuid) : direct_linker_dynamic ($f_type,$f_data,$f_html_encode,$f_withuuid)); }
/* -------------------------------------------------------------------------
There are two possibilities for creating normal links - shadowing them or
not. If shadowed, they may be look like http://localhost/swg_base64data.htm
------------------------------------------------------------------------- */

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker ()- (#echo(__LINE__)#)",(:#*/str_replace ($f_html_filter,"",$f_return)/*#ifdef(DEBUG):),true):#*/;
}

/**
* Most URLs have to contain dynamic data like "theme", "lang" and "uuid". They
* will be added automatically through this function. It will be used, if a
* shadow-setting doesn't apply.
*
* @param  string $f_type Linking mode: "url0" for internal links, "url1" for
*         external ones, "form" to create hidden fields or "optical" to remove
*         parts of a very long string.
* @param  string $f_data Query string
* @param  boolean $f_html_encode True to append "amp;" to each "&" character
*         (Needed for (X)HTML)
* @param  boolean $f_withuuid True to add the current uuID string to the query
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker_dynamic ($f_type,$f_data,$f_html_encode = true,$f_withuuid = true)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker_dynamic ($f_type,$f_data,+f_html_encode,+f_withuuid)- (#echo(__LINE__)#)"); }

	$f_anchor = "";

	if ((strpos ($f_data,"#") !== false)&&(preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array)))
	{
		$f_data = $f_result_array[1];
		$f_anchor = $f_result_array[2];
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false)
	{
		if ($f_data) { $f_data .= ";"; }
		$f_data .= "lang=".$direct_settings['lang'];
	}

	if (/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false)
	{
		if ($f_data) { $f_data .= ";"; }
		$f_data .= "theme=".$direct_settings['theme'];
	}

	if ((isset ($direct_globals['input']))&&($f_withuuid))
	{
		$f_uuid = $direct_globals['input']->uuidGet ();

		if (($f_uuid)&&(!$direct_globals['kernel']->vUuidIsCookied ())&&($direct_globals['kernel']->vUuidCheckUsage ()))
		{
			if ($f_data) { $f_data .= ";"; }
			$f_data .= "uuid=".$f_uuid;
		}
	}

/* -------------------------------------------------------------------------
Two types are available: url0 for relative URLs like swg.php?... and url1
for complete URLs like http://localhost/swg.php?...

Setting $f_html_encode to 1 will create XHTML-conform URLs with &amp; instead
of & seperators
------------------------------------------------------------------------- */

	if ($f_type == "url1") { $f_return = $direct_settings['iscript_req']."?".$f_data; }
	else { $f_return = $direct_settings['iscript_url'].$f_data; }

	if (strlen ($f_anchor)) { $f_return .= "#".$f_anchor; }
	if ($f_html_encode) { $f_return = direct_html_encode_special ($f_return); }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker_dynamic ()- (#echo(__LINE__)#)",:#*/$f_return/*#ifdef(DEBUG):,true):#*/;
}

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
* @return string Ready to use URL
* @since  v0.1.02
*/
function direct_linker_shadow ($f_type,$f_data,$f_withuuid = true,$f_lang = true,$f_theme = true)
{
	global $direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_linker_shadow ($f_type,$f_data,+f_withuuid)- (#echo(__LINE__)#)"); }

	$f_anchor = "";
	$f_return = "";

	if ((strpos ($f_data,"#") !== false)&&(preg_match ("#^(.+?)\#(.*?)$#",$f_data,$f_result_array)))
	{
		$f_data = $f_result_array[1];
		$f_anchor = $f_result_array[2];
	}

	if (($f_lang)&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"lang=") === false))
	{
		if ($f_data) { $f_data .= ";"; }
		$f_data .= "lang=".$direct_settings['lang'];
	}

	if (($f_theme)&&(/*#ifndef(PHP4) */stripos/* #*//*#ifdef(PHP4):stristr:#*/($f_data,"theme=") === false))
	{
		if ($f_data) { $f_data .= ";"; }
		$f_data .= "theme=".$direct_settings['theme'];
	}

	if ((isset ($direct_globals['input']))&&($f_withuuid))
	{
		$f_uuid = $direct_globals['input']->uuidGet ();

		if (($f_uuid)&&(!$direct_globals['kernel']->vUuidIsCookied ())&&($direct_globals['kernel']->vUuidCheckUsage ()))
		{
			if ($f_data) { $f_data .= ";"; }
			$f_data .= "uuid=".$f_uuid;
		}
	}

	$f_variables_array = explode (";",$f_data);

	if (!empty ($f_variables_array))
	{
		foreach ($f_variables_array as $f_variable)
		{
			$f_variable_array = explode ("=",$f_variable,2);
			if (!empty ($f_variable_array)) { $f_return .= "/".$f_variable_array[0].(isset ($f_variable_array[1]) ? "-".$f_variable_array[1] : ""); }
		}
	}

	$f_return = $direct_settings['swg_shadow_url'].$f_return;
	$f_return .= "/page.htm";

	if (strlen ($f_anchor)) { $f_return .= "#".$f_anchor; }

	return /*#ifdef(DEBUG):direct_debug (7,"sWG/#echo(__FILEPATH__)# -direct_linker_shadow ()- (#echo(__LINE__)#)",(:#*/direct_html_encode_special ($f_return)/*#ifdef(DEBUG):),true):#*/;
}

//j// Script specific commands

if ((!isset ($direct_settings['swg_url_opticalmaxlength']))||($direct_settings['swg_url_opticalmaxlength'] < 1)) { $direct_settings['swg_url_opticalmaxlength'] = 75; }

//j// EOF
?>