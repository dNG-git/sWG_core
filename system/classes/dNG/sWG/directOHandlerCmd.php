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
class directOHandlerCmd extends directVirtualClass
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
	* Constructor (PHP5) __construct (directOHandlerCmd)
	*
	* @since v0.1.01
*/
	/*#ifndef(PHP4) */public /* #*/function __construct ()
	{
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -oHandler->__construct (directOHandlerCmd)- (#echo(__LINE__)#)"); }

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
	* Constructor (PHP4) directOHandlerCmd
	*
	* @since v0.1.01
*\/
	function directOHandlerCmd () { $this->__construct (); }
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
		global $direct_cachedata;
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
		if ($this->last_modified) { $f_last_modified = gmdate ("D, d M Y H:i:s",$this->last_modified); }
		$f_headers['Last-Modified'] = $f_last_modified." GMT";

		if (!empty ($direct_cachedata['core_cookies']))
		{
			$f_headers['Set-Cookie'] = array ();
			foreach ($direct_cachedata['core_cookies'] as $f_cookie) { $f_headers['Set-Cookie'][] = $f_cookie; }
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
		echo "<?xml version='1.0' encoding='$direct_local[lang_charset]' ?><swg xmlns='urn:de-direct-netware-xmlns:swg.v1'>";

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
			}
		}
		elseif (isset ($f_title))
		{
			if ($f_title)
			{
				if (isset ($direct_settings['swg_title_txt'])) { $f_title = (direct_html_encode_special ($direct_settings['swg_title_txt'])).": ".$f_title; }
			}
			else { $f_title = direct_html_encode_special ($direct_settings['swg_title_txt']); }

			echo "<title><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_title))."]]></title>";

			if ($f_debug_inline)
			{
				echo "<debug>";

				if ((USE_debug_reporting)&&(is_array ($direct_cachedata['core_debug']))&&(!empty ($direct_cachedata['core_debug'])))
				{
					foreach ($direct_cachedata['core_debug'] as $f_line_data) { echo "<debug><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_line_data))."]]></debug>"; }
				}

				if ((is_array ($direct_cachedata['core_error']))&&(!empty ($direct_cachedata['core_error'])))
				{
					foreach ($direct_cachedata['core_error'] as $f_line_data) { echo "<error><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$f_line_data))."]]></error>"; }
				}

				echo "</debug>";
			}

			if ((isset ($this->output_data))&&(function_exists ($this->output_data))) { $this->output_data (); }
			$this->outputResponseHeaders ();

			$this->output_content = "<data><![CDATA[".(str_replace ("]]>","]]]]><![CDATA[>",$this->output_content))."]]></data>";
			$this->outputResponseData ($this->output_content);
		}
		else
		{
			$this->outputResponseHeaders ();

			if (($this->output_data)||(!is_string ($this->outputHeader ("HTTP/1.1",NULL,true)))) { $this->outputResponseData ($this->output_data); }
			else { $this->outputSendError ("fatal",($this->outputHeader ("HTTP/1.1",NULL,true)),"","sWG/#echo(__FILEPATH__)# -output_class->outputResponse ()- (#echo(__LINE__)#)"); }
		}

		$f_debug_endtime = /*#ifndef(PHP4) */microtime (true)/* #*//*#ifdef(PHP4):time ():#*/;

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
		elseif (isset ($f_title))
		{
echo ("<!--
Delivered page after: ".($f_debug_endtime - $direct_cachedata['core_debug_starttime'])." seconds
$direct_settings[product_lcode_txt]
// -->");
		}

		echo "</swg>";
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
		echo "<headers>";

		foreach ($this->output_headers as $f_header_name => $f_header_value)
		{
			if (is_int ($f_header_name)) { echo "<header>$f_header_value</header>"; }
			elseif (is_array ($f_header_value))
			{
				foreach ($f_header_value as $f_header_array_value)
				{
					echo "<header>";
					foreach ($f_header_value as $f_header_array_value) { echo "<header>$f_header_name: $f_header_value</header>"; }
					echo "</header>";
				}
			}
			else { echo "<header>$f_header_name: $f_header_value</header>"; }
		}

		echo "</headers>";
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
		global $direct_globals,$direct_local,$direct_settings;
		if (USE_debug_reporting) { direct_debug (3,"sWG/#echo(__FILEPATH__)# -oHandler->themePage ($f_title)- (#echo(__LINE__)#)"); }

		if ((!isset ($direct_local['lang_iso_domain']))||(!$direct_local['lang_iso_domain'])) { $direct_local['lang_iso_domain'] = "en"; }
		$direct_settings['theme_xhtml_type'] = "application/xhtml+xml; charset=".$direct_local['lang_charset'];

		$direct_globals['output']->outputHeader ("Content-Type",$direct_settings['theme_xhtml_type']);
		$this->output_data = $direct_globals['output']->output_content;
	}
}

/**
* To extend correctly be sure to provide the output handler class.
*
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG_core
* @subpackage basic_functions
* @since      v0.1.10
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/
class directOHandler extends directOHandlerCmd
{
/* -------------------------------------------------------------------------
Extend the class using old behavior
------------------------------------------------------------------------- */

/*#ifdef(PHP4):
/**
	* Constructor (PHP4) directOHandler
	*
	* @since v0.1.01
*\/
	function directOHandler () { $this->__construct (); }
:#\n*/
}

/* -------------------------------------------------------------------------
Mark this class as the most up-to-date one
------------------------------------------------------------------------- */

define ("CLASS_directOHandler",true);
define ("CLASS_directOHandlerCmd",true);

//j// Script specific commands

global $direct_globals;
$direct_globals['@names']['output'] = 'dNG\sWG\directOHandlerCmd';
$direct_globals['@names']['output_theme'] = 'dNG\sWG\directOHandlerCmd';
}

//j// EOF
?>