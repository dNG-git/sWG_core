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
* OOP (Object Oriented Programming) requires an abstract data
* handling. The sWG is OO (where it makes sense).
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
/*#ifdef(PHP5n) */

namespace dNG\sWG;
/* #\n*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/* -------------------------------------------------------------------------
Testing for required classes
------------------------------------------------------------------------- */

$g_continue_check = ((defined ("CLASS_directOHandler")) ? false : true);
if (!defined ("CLASS_directVirtualClass")) { $g_continue_check = false; }

if ($g_continue_check)
{
/**
* The following class is the basic (inline) output system, giving everybody
* functions for headers and the internal sWG page theme.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage output
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOHandler extends directVirtualClass
{
/**
	* @var integer $last_modified Variable to save the oset data
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $last_modified;
/**
	* @var string $output_content Variable containing the content
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_content;
/**
	* @var string $output_data This variable contains the result data
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_data;
/**
	* @var array $output_headers Headers are used by the final node
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers;
/**
	* @var integer $output_headers_index Current named headers index
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers_index;
/**
	* @var array $output_headers_indexed Headers using a header index
*/
	/*#ifndef(PHP4) */public/* #*//*#ifdef(PHP4):var:#*/ $output_headers_indexed;

/* -------------------------------------------------------------------------
Extend the class using old and new behavior
------------------------------------------------------------------------- */

/**
	* Constructor (PHP5) __construct (directOHandler)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->__construct (directOHandler)- (#echo(__LINE__)#)"); }

/* -------------------------------------------------------------------------
My parent should be on my side to get the work done
------------------------------------------------------------------------- */

		parent::__construct ();

/* -------------------------------------------------------------------------
Informing the system about available functions
------------------------------------------------------------------------- */

		$this->functions['header'] = true;
		$this->functions['lastModified'] = true;
		$this->functions['outputHeader'] = true;
		$this->functions['outputResponse'] = true;
		$this->functions['outputResponseData'] = true;
		$this->functions['outputResponseHeaders'] = true;
		$this->functions['outputSend'] = true;
		$this->functions['outputSendError'] = true;
		$this->functions['themePage'] = true;

/* -------------------------------------------------------------------------
Set "last modified" time to "0".
------------------------------------------------------------------------- */

		$this->last_modified = 0;
		$this->output_content = NULL;
		$this->output_data = NULL;
		$this->output_headers = array ();
		$this->output_headers_index = 0;
		$this->output_headers_indexed = array ();
	}
/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOHandler (directOHandler)
	*
	* @since v0.1.01
*\/
	function directOHandler () { $this->__construct (); }
:#*/
/**
	* Important headers will be created here. This includes caching, cookies, the
	* compression setting and information about P3P.
	*
	* @param boolean $f_cacheing Allow caching at client
	* @param boolean $f_withenc Send page GZip encoded (if supported)
	* @param string $f_p3purl Valid P3P-URL
	* @param string $f_p3pcp Valid P3P header string
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function header ($f_cacheing = false,$f_withenc = true,$f_p3purl = "",$f_p3pcp = "")
	{
		global $direct_cachedata,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->header ($f_cacheing,$f_withenc,+f_p3purl,+f_p3pcp)- (#echo(__LINE__)#)"); }

		if ($f_cacheing)
		{
			$f_headers = array ("Cache-Control" => "public");
			$f_expires = gmdate ("D, d M Y H:i:s",($direct_cachedata['core_time'] + 18748800));
			if (!$this->last_modified) { $f_last_modified = "Thu, 01 Jan 2004 00:00:00"; }
		}
		else
		{
			$f_headers = array ("Cache-Control" => "no-cache, must-revalidate","Pragma" => "no-cache");
			$f_expires = gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']);
			if (!$this->last_modified) { $f_last_modified = gmdate ("D, d M Y H:i:s",$direct_cachedata['core_time']); }
		}

		$f_headers['Expires'] = $f_expires." GMT";

		if (($f_withenc)&&(USE_outputenc)&&(extension_loaded ("zlib"))) { ob_start ("ob_gzhandler"); }
		else { ob_start (); }

		if ($this->last_modified) { $f_last_modified = gmdate ("D, d M Y H:i:s",$this->last_modified); }
		$f_headers['Last-Modified'] = $f_last_modified." GMT";

		if ((!$direct_settings['swg_cookies_deactivated'])&&(!empty ($direct_cachedata['core_cookies'])))
		{
			$f_headers['Set-Cookie'] = $direct_cachedata['core_cookies'];
			$direct_cachedata['core_cookies'] = array ();
		}

/* -------------------------------------------------------------------------
Encode the output for smaller bandwidth connections
------------------------------------------------------------------------- */

		$f_p3purl = str_replace ("&","&amp;",$f_p3purl);
		$direct_cachedata['output_p3purl'] = $f_p3purl;

		if (($f_p3purl.$f_p3pcp) != "")
		{
			$f_p3pdata = (($f_p3purl == "") ? "policyref=\"$f_p3purl\"" : "");

			if ($f_p3pcp != "")
			{
				if ($f_p3pdata != "") { $f_p3pdata .= ","; }
				$f_p3pdata .= "CP=\"$f_p3pcp\"";
			}

			$f_headers['P3P'] = $f_p3pdata;
		}

		$this->output_headers = array_merge ($this->output_headers,$f_headers);
	}

/**
	* Set's a custom "last modified" header entry for the upcoming output.
	*
	* @param integer $f_timestamp UNIX timestamp
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function lastModified ($f_timestamp)
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->lastModified ($f_timestamp)- (#echo(__LINE__)#)"); }
		$this->last_modified = $f_timestamp;
	}

/**
	* Returns or sets a header.
	*
	* @param string $f_name Header name
	* @param mixed $f_value Header value as string or array
	* @param boolean $f_name_as_key True if the name is used as a key
	* @param boolean $f_value_append True if headers should be appended
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function outputHeader ($f_name = "",$f_value = NULL,$f_name_as_key = false,$f_value_append = false)
	{
		$f_return = NULL;

		if (($f_name_as_key)&&($f_name == "HTTP/1.1")&&($_SERVER['SERVER_PROTOCOL'] == "HTTP/1.0"))
		{
			switch ($f_value)
			{
			case "HTTP/1.1 203 Non-Authoritative Information":
			{
				$f_value = "HTTP/1.0 200 OK";
				break 1;
			}
			case "HTTP/1.1 303 See Other":
			{
				$f_value = "HTTP/1.0 302 Found";
				break 1;
			}
			case "HTTP/1.1 307 Temporary Redirect":
			{
				$f_value = "HTTP/1.0 302 Found";
				break 1;
			}
			default: { $f_value = str_replace ("HTTP/1.1","HTTP/1.0",$f_value); }
			}
		}

		if (isset ($f_value))
		{
			if ($f_name_as_key)
			{
				if (isset ($this->output_headers_indexed[$f_name]))
				{
					if ($f_value_append)
					{
						if (is_array ($this->output_headers[$this->output_headers_indexed[$f_name]])) { $f_value = array_merge ($this->output_headers[$this->output_headers_indexed[$f_name]],(array ($f_value))); }
						else { $f_value = array ($this->output_headers[$this->output_headers_indexed[$f_name]],$f_value); }
					}

					$this->output_headers[$this->output_headers_indexed[$f_name]] = $f_value;
				}
				else
				{
					$this->output_headers[$this->output_headers_index] = $f_value;
					$this->output_headers_indexed[$f_name] = $this->output_headers_index;
					$this->output_headers_index++;
				}
			}
			elseif (is_array ($f_value)) { $this->output_headers[$f_name] = ((count ($f_value) > 1) ? $f_value : array_pop ($f_value)); }
			elseif (($f_value_append)&&(isset ($this->output_headers[$f_name])))
			{
				if (is_array ($this->output_headers[$f_name])) { $f_value = array_merge ($this->output_headers[$f_name],(array ($f_value))); }
				else { $f_value = array ($this->output_headers[$f_name],$f_value); }
			}
			else { $this->output_headers[$f_name] = $f_value; }
		}
		elseif (isset ($this->output_headers[$f_name])) { $f_return = $this->output_headers[$f_name]; }
		elseif (($f_name_as_key)&&(isset ($this->output_headers_indexed[$f_name]))) { $f_return = $this->output_headers[$this->output_headers_indexed[$f_name]]; }

		return $f_return;
	}

/**
	* This function will actually send the prepared content and debug information
	* to user.
	*
	* @param string $f_title Valid XHTML page title
	* @param array $f_headers Additional output headers
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function outputResponse ($f_title = "",$f_headers = NULL)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->outputResponse (+f_title,+f_headers)- (#echo(__LINE__)#)"); }

		if ((!isset ($direct_local['lang_charset']))||(!$direct_local['lang_charset'])) { $direct_local['lang_charset'] = "UTF-8"; }

		if (is_array ($direct_settings['dsd']))
		{
			$f_debug_inline = isset ($direct_settings['dsd']['debug_inline']);
			$f_debug_text = isset ($direct_settings['dsd']['debug_text']);
			$f_debug_xml = isset ($direct_settings['dsd']['debug_xml']);
		}
		else
		{
			$f_debug_inline = false;
			$f_debug_text = false;
			$f_debug_xml = false;
		}

		if ((USE_debug_reporting)&&(($f_debug_text)||($f_debug_xml)))
		{
			if ($f_debug_xml)
			{
				$this->output_headers['Content-Type'] = "text/xml; charset=".$direct_local['lang_charset'];
				echo "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><swg>";

				if ((is_array ($direct_cachedata['core_debug']))&&(!empty ($direct_cachedata['core_debug'])))
				{
					echo "<debug>";

					$f_line = 0;

					foreach ($direct_cachedata['core_debug'] as $f_line_data)
					{
						$f_line++;
						$f_line_data = str_replace ("]]>","]]&gt;",$f_line_data);
						echo "<step line='$f_line'><![CDATA[{$f_line_data}]]></step>";
					}

					echo "</debug>";
				}

				if ((is_array ($direct_cachedata['core_error']))&&(!empty ($direct_cachedata['core_error'])))
				{
					echo "<errors>";
					$f_line = 0;

					foreach ($direct_cachedata['core_error'] as $f_line_data)
					{
						$f_line++;
						$f_line_data = str_replace ("]]>","]]&gt;",$f_line_data);
						echo "<error number='$f_line'><![CDATA[{$f_line_data}]]></error>";
					}

					echo "</errors>";
				}

				echo "</swg>";
			}
			else { $this->output_headers['Content-Type'] = "text/plain; charset=".$direct_local['lang_charset']; }
		}
		elseif (isset ($f_title))
		{
			if (!isset ($direct_globals['output_theme'])) { direct_class_init ("output_theme"); }

			if (isset ($direct_globals['output_theme']))
			{
				if ($f_title)
				{
					if (isset ($direct_settings['swg_title_txt'])) { $f_title = (direct_html_encode_special ($direct_settings['swg_title_txt'])).": ".$f_title; }
				}
				else { $f_title = direct_html_encode_special ($direct_settings['swg_title_txt']); }

				if ($f_debug_inline)
				{
					if ((USE_debug_reporting)&&(is_array ($direct_cachedata['core_debug']))&&(!empty ($direct_cachedata['core_debug'])))
					{
						foreach ($direct_cachedata['core_debug'] as $f_line_data) { $direct_cachedata['output_warning'][] = array ("title" => "Debug","text" => direct_html_encode_special ($f_line_data)); }
					}

					if ((is_array ($direct_cachedata['core_error']))&&(!empty ($direct_cachedata['core_error'])))
					{
						foreach ($direct_cachedata['core_error'] as $f_line_data) { $direct_cachedata['output_warning'][] = array ("title" => "Error","text" => direct_html_encode_special ($f_line_data)); }
					}
				}

				if (is_array ($f_headers)) { $this->output_headers = array_merge ($this->output_headers,$f_headers); }

				if ((isset ($this->output_data))&&(function_exists ($this->output_data))) { $this->output_data (); }
				else { $direct_globals['output_theme']->themePage ($f_title); }

				if (isset ($direct_settings['theme_xhtml_type']))
				{
					if ((isset ($_SERVER['HTTP_ACCEPT']))&&(/*#ifndef(PHP4) */stripos /* #*//*#ifdef(PHP4):stristr :#*/($_SERVER['HTTP_ACCEPT'],"application/xhtml+xml") === false)) { $this->outputResponseXHtmlLegacy ($direct_globals['output_theme']->output_data); }
				}
				else { direct_outputenc_xhtml_cleanup ($direct_globals['output_theme']->output_data); }

				$this->outputResponseHeaders ();
				$this->outputResponseData ($direct_globals['output_theme']->output_data);
			}
			elseif (isset ($direct_local['lang_charset'])) { $this->outputSendError ("fatal","core_required_object_not_found","FATAL ERROR:<br />The theme class is unavailable.","sWG/#echo(__FILEPATH__)# -output_class->outputResponse ()- (#echo(__LINE__)#)"); }
			else { $this->outputSendError ("fatal","The system was unable to load a required component.","","sWG/#echo(__FILEPATH__)# -output_class->outputResponse ()- (#echo(__LINE__)#)"); }
		}
		else
		{
			$this->outputResponseHeaders ();

			if (($this->output_data)||(!is_string ($this->outputHeader ("HTTP/1.1",NULL,true)))) { $this->outputResponseData ($this->output_data); }
			else { $this->outputSendError ("fatal",($this->outputHeader ("HTTP/1.1",NULL,true)),"","sWG/#echo(__FILEPATH__)# -output_class->outputResponse ()- (#echo(__LINE__)#)"); }
		}

		$f_debug_endtime = /*#ifndef(PHP4) */microtime (true)/* #*//*#ifdef(PHP4):time ():#*/;

		if (isset ($f_title))
		{
			if (USE_debug_reporting)
			{
				if (!$f_debug_text) { echo "<!--\n"; }

echo ("Delivered page after: ".($f_debug_endtime - $direct_cachedata['core_debug_starttime'])."
Debug checkpoints reached: ".(count ($direct_cachedata['core_debug']))."
Errors: ".(count ($direct_cachedata['core_error'])));

				if (function_exists ("memory_get_usage")) { echo "\nMemory in use: ".(memory_get_usage (true))." bytes"; }

				if ($f_debug_text)
				{
echo ("\n\nDebug checkpoint list:
".(implode ("\n",$direct_cachedata['core_debug']))."

Error list:
".(implode ("\n",$direct_cachedata['core_error'])));
				}

				echo "\n\n$direct_settings[product_lcode_txt] $direct_settings[product_version] ($direct_settings[product_buildid])\nhttp://www.direct-netware.de/redirect.php?$direct_settings[product_icode]";
				if (!$f_debug_text) { echo "\n// -->"; }
			}
			else
			{
echo ("<!--
Delivered page after: ".($f_debug_endtime - $direct_cachedata['core_debug_starttime'])." seconds
$direct_settings[product_lcode_txt]
// -->");
			}
		}

		ob_end_flush ();
	}

/**
	* Send the content of a page.
	*
	* @param string &$f_data Data to send
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */protected /* #*/function outputResponseData (&$f_data) { echo $f_data; }

/**
	* This function will actually send the prepared headers to user.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */protected /* #*/function outputResponseHeaders ()
	{
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->outputResponseHeaders ()- (#echo(__LINE__)#)"); }

		if ((!isset ($this->output_headers_indexed['HTTP/1.1']))&&($_SERVER['SERVER_PROTOCOL'] == "HTTP/1.0")) { header ("HTTP/1.0 200 OK"); }

		foreach ($this->output_headers as $f_header_name => $f_header_value)
		{
			if (is_int ($f_header_name)) { header ($f_header_value); }
			elseif (is_array ($f_header_value))
			{
				foreach ($f_header_value as $f_header_array_value) { header ($f_header_name.": ".$f_header_array_value,false); }
			}
			else { header ($f_header_name.": ".$f_header_value); }
		}
	}

/**
	* The sWG uses XHTML by default. If the browser does not support XHTML we need
	* to switch to a legacy HTML (quirks) mode.
	*
	* @param string &$f_data Reference to the output content
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */protected /* #*/function outputResponseXHtmlLegacy (&$f_data)
	{
		global $direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (8,"sWG/#echo(__FILEPATH__)# -oHandler->outputResponseXHtmlLegacy (+f_data)- (#echo(__LINE__)#)"); }

		$f_content_type = str_replace ("application/xhtml+xml","text/html",$direct_settings['theme_xhtml_type']);
		$this->outputHeader ("Content-Type",$f_content_type);
		$f_data = preg_replace (array ("#\s*<\?(.*?)\?>(.*?)<#s","#\s*\/\s*>#s","#</head>#i","#<(script|style)(.*?)><\!\[CDATA\[(.*?)\]\]><\/(script|style)>#si"),(array ("<",">","<meta http-equiv='Content-Type' content=\"$f_content_type\">\n</head>","<\\1\\2><!--\\3// --></\\4>")),$f_data);
	}

/**
	* This function is used for later multi-level delivery. Only the final
	* node actually sends data to the requesting client.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.08
*/
	/*#ifndef(PHP4) */public /* #*/function outputSend ($f_title = "",$f_headers = NULL) { $this->outputResponse ($f_title,$f_headers); }

/**
	* We are trying to catch all errors - even semi-fatal ones. For that reason
	* we provide the emergency mode function that does not require an active theme
	* or localiation strings to work.
	*
	* @param string $f_type Ignored error type - if this function is called,
	*        it is an emergency error. 
	* @param string $f_error A key for localisation strings or an error message
	* @param string $f_extra_data More detailed information to track down the
	*        problem
	* @param string $f_error_position Position where the error occurred
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function outputSendError ($f_type,$f_error,$f_extra_data = "",$f_error_position = "")
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->outputSendError ($f_type,$f_error,+f_extra_data,$f_error_position)- (#echo(__LINE__)#)"); }

		if ((!preg_match ("#\W#i",$f_error))&&(function_exists ("direct_local_get"))) { $f_error = direct_local_get ("errors_".$f_error); }

		if (strlen ($f_extra_data))
		{
			$f_extra_data = "\n<p class='pagecontent' style='text-align:center'>".$f_extra_data;
			if ((USE_debug_reporting)&&($f_error_position)) { $f_extra_data .= "<br />\n<span style='font-size:10px'>$f_error_position</span>"; }
			$f_extra_data .= "</p>";
		}
		elseif ((USE_debug_reporting)&&($f_error_position)) { $f_extra_data = "\n<p class='pagecontent' style='text-align:center;font-size:10px'>$f_error_position</p>"; }

$direct_globals['output']->output_content = ("<p class='pagecontent' style='text-align:center'><strong>$direct_settings[product_lcode_html]</strong> $direct_settings[product_version]</p>
<p class='pagecontent' style='text-align:center'><strong style='color:#FF0000'>Entering emergency mode:</strong><br />
$f_error</p>$f_extra_data
<p class='pagecontent' style='text-align:center;font-size:10px'>If this seems to be a bug then please <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode];itracker;bug' target='_blank'>report</a> it.</p>");

		if (USE_debug_reporting)
		{
			if (!empty ($direct_cachedata['core_debug']))
			{
				$f_data = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
				$direct_globals['output']->output_content .= ("\n<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Debug Data List:</strong><br />\n".(implode ("<br />\n",$f_data))."</p>");
			}

			if (!empty ($direct_cachedata['core_error']))
			{
				$f_data = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
				$direct_globals['output']->output_content .= ("\n<p class='pagecontent' style='text-align:center;font-size:10px'><strong>Error List:</strong><br />\n".(implode ("<br />\n",$f_data))."</p>");
			}
		}

		$direct_globals['output']->header (false,true);
		$direct_globals['output']->outputSend ($direct_settings['product_lcode_htmltitle']);

/*#ifndef(PHP4) */
		$direct_cachedata['core_service_activated'] = true;
		throw new /*#ifdef(PHP5n) */\RuntimeException/* #*//*#ifndef(PHP5n):RuntimeException:#*/ ($f_error);
/* #*//*#ifdef(PHP4):
		exit ();
:#\n*/
	}

/**
	* Prepare an output for a XHTML encoded page with the standard sWG design.
	*
	* @param string $f_title Valid XHTML page title
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function themePage ($f_title)
	{
		global $direct_cachedata,$direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->themePage ($f_title)- (#echo(__LINE__)#)"); }

		if ((!isset ($direct_local['lang_iso_domain']))||(!$direct_local['lang_iso_domain'])) { $direct_local['lang_iso_domain'] = "en"; }
		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];

		$direct_globals['output']->outputHeader ("Content-Type",$direct_settings['theme_xhtml_type']);

$this->output_data = ("<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><!DOCTYPE html SYSTEM \"about:legacy-compat\">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='$direct_local[lang_iso_domain]'>

<head>
<title>$f_title</title>");

		if (strlen ($direct_cachedata['output_p3purl'])) { $this->output_data .= "\n<link rel='P3Pv1' href='{$direct_cachedata['output_p3purl']}'>"; }

$this->output_data .= ("\n<meta name='author' content='direct Netware Group' />
<meta name='creator' content='$direct_settings[product_lcode_txt] by the direct Netware Group' />
<meta name='description' content='$direct_settings[product_lcode_subtitle_txt]' />
<style type='text/css'><![CDATA[
p, td, th { cursor:default }

a { cursor:pointer }
a:link { text-decoration:underline }
a:active { text-decoration:none }
a:visited { text-decoration:underline }
a:hover { text-decoration:none }
a:focus { text-decoration:underline }

body { margin:0px;padding:0px 19px;background-color:#6A6A6A }
body { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-style:normal;font-weight:normal }
form { margin:0px;padding:0px }
h1, h2, h3, h4, h5, h6 { margin:0px;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:14px;font-style:normal;font-weight:bold }
img { border:none }
table { margin:0px;table-layout:fixed;border:none;border-collapse:collapse;border-spacing:0px }
td, th { padding:0px }

.designcopyright { background-color:#808080 }
.designcopyright { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#DDDDDD }
.designcopyright a, .designcopyright a:link, .designcopyright a:active, .designcopyright a:visited, .designcopyright a:hover, .designcopyright a:focus { color:#FFFFFF }

.designpage { padding:10px 12px;background-color:#FFFFFF;text-align:left;vertical-align:middle }
.designpage > :first-child { margin-top:0px }
.designpage > :last-child { margin-bottom:0px }

.designtitle { height:85px;padding:5px 15px;background-image:url($direct_settings[iscript_url]a=cache;dsd=dfile+swg_bg.png);background-repeat:repeat-x;background-color:#FFFFFF;text-align:right;vertical-align:middle }
.designtitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;color:#000000 }

.pagebg { background-color:#FFFFFF }
.pageborder { border:1px solid #DDDDDD;padding:4px }

.pagecontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pagecontent a, .pagecontent a:link, .pagecontent a:active, .pagecontent a:visited, .pagecontent a:hover, .pagecontent a:focus { color:#000000 }

.pagecontentinputbutton { background-color:#F5F5F5;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#000000 }
.pagecontentinputcheckbox { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222;background-color:#FFFFFF }
.pagecontentinputfocused { border-color:#193879 }

.pagecontentinputtextnpassword { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentinputtextnpassword { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }

.pagecontentselect { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontentselect { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }

.pagecontenttextarea { border:1px solid #C0C0C0;background-color:#F5F5F5 }
.pagecontenttextarea { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }

.pagecontenttitle { border:1px solid #193879;background-color:#375A9D;padding:5px;clear:both }
.pagecontenttitle { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#DDDDDD }
.pagecontenttitle a, .pagecontenttitle a:link, .pagecontenttitle a:active, .pagecontenttitle a:visited, .pagecontenttitle a:hover, .pagecontenttitle a:focus { color:#FFFFFF }

.pageembeddedbg { background-color:#FFFFFF }
.pageembeddedborder { border:1px solid #DDDDDD;padding:4px }
.pageemptycell { background-color:#F5F5F5 }

.pageerrorcontent { font-weight:bold;color:#FF0000 }
.pageerrorcontent a, .pageerrorcontent a:link, .pageerrorcontent a:active, .pageerrorcontent a:visited, .pageerrorcontent a:hover, .pageerrorcontent a:focus { color:#CC0000 }

.pageextrabg { background-color:#F5F5F5 }

.pageextracontent { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;color:#222222 }
.pageextracontent a, .pageextracontent a:link, .pageextracontent a:active, .pageextracontent a:visited, .pageextracontent a:hover, .pageextracontent a:focus { color:#000000 }

.pagehide { display:none }
.pagehighlightbg { background-color:#FBF6CD }
.pagehighlightborder { border:1px solid #FF0000;padding:4px }

.pagehighlighttable { border-collapse:collapse }
.pagehighlighttable td, .pagehighlighttable th { border:1px solid #FF0000 }

.pagehr { height:1px;overflow:hidden;border-top:1px solid #193879 }

.pageservicemenu { border:1px solid #D9D9DA;padding:5px;clear:both }
.pageservicemenu { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;color:#222222 }
.pageservicemenu a, .pageservicemenu a:link, .pageservicemenu a:visited { color:#000000;text-decoration:underline }
.pageservicemenu a:active, .pageservicemenu a:hover, .pageservicemenu a:focus { color:#444444;text-decoration:none }

.pagetable { border:1px solid #DDDDDD;border-collapse:collapse }
.pagetable td { border:1px dotted #C0C0C0 }
.pagetable td.pagetitlecell { border:1px solid #193879 }

.pagetitlecell { padding:3px;background-color:#375A9D }
.pagetitlecell { font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;color:#FFFFFF }
.pagetitlecell a, .pagetitlecell a:link, .pagetitlecell a:active, .pagetitlecell a:visited, .pagetitlecell a:hover, .pagetitlecell a:focus { color:#FFFFFF }

td:first-child, th:first-child { border-left:none }
td:last-child, th:last-child { border-right:none }
]]></style>
</head>

<body><!--
internal sWG page theme
// --><div style='position:absolute;top:0px;left:0px;z-index:255;width:19px;height:71px;background-color:#FFFFFF'>
<div style='width:19px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div><div style='width:100%;height:10px;background-color:#000000'></div><table style='width:100%'>
<tbody><tr>
<td class='designtitle'><a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank' style='float:left'><img src='$direct_settings[iscript_url]a=cache;dsd=dfile+swg_logo.png' width='75' height='75' alt='$direct_settings[product_lcode_txt]' title='$direct_settings[product_lcode_txt]' /></a>
<span style='font-size:24px'>$direct_settings[product_lcode_html]</span><br />
$direct_settings[product_lcode_subtitle_html]</td>
</tr><tr>
<td class='designpage pagecontent'>");

		if ((is_array ($direct_cachedata['output_warning']))&&(!empty ($direct_cachedata['output_warning'])))
		{
			foreach ($direct_cachedata['output_warning'] as $f_warning_data) { $this->output_data .= "<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent'><strong>{$f_warning_data['title']}</strong><br />\n{$f_warning_data['text']}</span></p>"; }
		}

$this->output_data .= ($direct_globals['output']->output_content."</td>
</tr></tbody><tfoot><tr>
<td class='designcopyright' style='height:50px;text-align:center;vertical-align:middle'>Powered by: $direct_settings[product_lcode_html] $direct_settings[product_version]<br />
&#xA9; <a href='http://www.direct-netware.de/redirect.php?$direct_settings[product_icode]' target='_blank'><em>direct</em> Netware Group</a> - All rights reserved</td>
</tr></tfoot>
</table><div style='position:absolute;top:0px;right:0px;z-index:255;width:19px;height:71px;background-color:#FFFFFF'>
<div style='width:19px;height:16px;background-color:#000000'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#000000'></div>
<div style='width:19px;height:49px;margin-top:1px;background-color:#193879'></div>
<div style='width:19px;height:1px;margin-top:1px;background-color:#193879'></div>
</div>
</body>

</html>");
	}
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directOHandler",true);

//j// Script specific commands

global $direct_globals,$direct_settings;
$direct_globals['@names']['output'] = 'dNG\sWG\directOHandler';
$direct_globals['@names']['output_theme'] = 'dNG\sWG\directOHandler';
$direct_settings['swg_cookies_deactivated'] = ((!USE_cookies) ? true : false);
}

//j// EOF
?>