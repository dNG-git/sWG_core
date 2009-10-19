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
* osets/default_etitle/swg_default_embedded.php
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
* @subpackage osets_default_etitle
* @since      v0.1.06
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

//f// direct_output_oset_default_embedded_done ()
/**
* direct_output_oset_default_embedded_done ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.08
*/
function direct_output_oset_default_embedded_done ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_done ()- (#echo(__LINE__)#)"); }

	$f_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));
	$f_return = "<p class='pagecontenttitle'>$f_title</p>\n<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if ($direct_cachedata['output_jsjump'] > 0)
		{
$f_return .= ("\n<p id='swgjsjump_point' class='pagecontent' style='font-weight:bold;text-align:center'><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
\"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\",'swgjsjump_point');
self.setTimeout (\"self.location.replace (\\\"{$direct_cachedata['output_scripttarget']}\\\")\",{$direct_cachedata['output_jsjump']});
]]></script>");
		}
		else { $f_return .= "\n<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p>"; }
	}

	return $f_return;
}

//f// direct_output_oset_default_embedded_done_extended ()
/**
* direct_output_oset_default_embedded_done_extended ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.08
*/
function direct_output_oset_default_embedded_done_extended ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_done_extended ()- (#echo(__LINE__)#)"); }

	$f_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));

$f_return = ("<p class='pagecontenttitle'>$f_title</p>
<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>
<p class='pagecontenttitle' style='font-size:10px'>".(direct_local_get ("core_detailed_information"))."</p>
<p class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_job_extension']}</p>");

	if (isset ($direct_cachedata['output_pagetarget'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p>"; }

	return $f_return;
}

//f// direct_output_oset_default_embedded_ajax_aphandler ()
/**
* direct_output_oset_default_embedded_ajax_aphandler ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_aphandler ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_aphandler ()- (#echo(__LINE__)#)"); }

$f_return = ("<div id='swg_core_aphandler_point' style='text-align:center'><table class='pageborder1' style='margin:auto;table-layout:auto'>
<thead><tr>
<td colspan='3' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px;font-weight:bold;text-align:center'>{$direct_cachedata['output_title']}</span></td>
</tr></thead><tbody><tr>
<td colspan='3' class='pagebg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pagecontent' style='text-align:center'>");

	$f_return .= (isset ($direct_cachedata['output_text']) ? $direct_cachedata['output_text'] : direct_local_get ("aphandler_please_wait_a_second_js"));
	$f_return .= "</span></td>\n</tr>";

	if (!empty ($direct_cachedata['output_time_estimated']))
	{
$f_return .= ("<tr>
<td colspan='3' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px;font-weight:bold'>".(direct_local_get ("aphandler_progress"))."</span></td>
</tr><tr>
<td colspan='3' class='pagebg' style='padding:$direct_settings[theme_td_padding];text-align:center'><progress class='pagecontent'>{$direct_cachedata['output_percentage']}%</progress></td>
</tr>");
	}

$f_return .= ("<tr>
<td colspan='3' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px;font-weight:bold'>".(direct_local_get ("aphandler_time_elapsed"))."</span></td>
</tr><tr>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_elapsed'][0]}</span></td>
<td class='pagebg' style='width:34%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_elapsed'][1]}</span></td>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_elapsed'][2]}</span></td>
</tr>");

	if (!empty ($direct_cachedata['output_time_estimated']))
	{
$f_return .= ("<tr>
<td colspan='3' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px;font-weight:bold'>".(direct_local_get ("aphandler_time_estimated"))."</span></td>
</tr>
<tr>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_estimated'][0]}</span></td>
<td class='pagebg' style='width:34%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_estimated'][1]}</span></td>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_time_estimated'][2]}</span></td>
</tr>");
	}

$f_return .= ("<tr>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>".(direct_local_get ("aphandler_hours"))."</span></td>
<td class='pagebg' style='width:34%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>".(direct_local_get ("aphandler_minutes"))."</span></td>
<td class='pagebg' style='width:33%;padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagecontent' style='font-size:10px'>".(direct_local_get ("aphandler_seconds"))."</span></td>
</tr></tbody>
</table></div>");

	return $f_return;
}

//f// direct_output_oset_default_embedded_error_critical ()
/**
* direct_output_oset_default_embedded_error_critical ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_critical ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_critical ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle'>".(direct_local_get ("core_error"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	return $f_return;
}

//f// direct_output_oset_default_embedded_error_fatal ()
/**
* direct_output_oset_default_embedded_error_fatal ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_fatal ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_fatal ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle'>".(direct_local_get ("core_error_fatal"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p class='pagecontent' style='text-align:center'><span style='font-weight:bold'><a href=\"{$direct_cachedata['output_link_back']}' target='_self'>".(direct_local_get ("core_back"))."</a></span>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= ("\n<p class='pagecontenttitle'>Debug checkpoint list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>");
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= ("\n<p class='pagecontenttitle'>Error list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>");
		}
	}

	$f_return .= "<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";
	return $f_return;
}

//f// direct_output_oset_default_embedded_error_standard ()
/**
* direct_output_oset_default_embedded_error_standard ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_standard ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle'>".(direct_local_get ("core_error"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p class='pagecontent' style='text-align:center'><span style='font-weight:bold'><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></span>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	return $f_return;
}

if (isset ($direct_classes['@names']['output_formbuilder']))
{
	//f// direct_output_oset_default_embedded_form ()
/**
	* direct_output_oset_default_embedded_form ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_embedded_form ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_form ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_classes['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		$f_return = "<p class='pagecontenttitle'>{$direct_cachedata['output_formtitle']}</p>\n";
		$f_form_id = uniqid ("swg");

		if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
		{
			$f_return .= "<p class='pagehighlightborder2' style='text-align:left'>";
			if ($direct_cachedata['output_credits_information']) { $f_return .= "<span class='pagecontent'>{$direct_cachedata['output_credits_information']}</span>"; }
			if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : "<span class='pagecontent'>{$direct_cachedata['output_credits_payment_data']}</span>"); }
			$f_return .= "</p>";
		}

$f_return .= ($direct_settings['iscript_form']." name='swgForm' id='swgForm' onsubmit=\"return djs_formbuilder_submit('swgForm');\">".(direct_linker ("form",$direct_cachedata['output_formtarget']))."<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead class='pagehide'><tr>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field"))."</span></td>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field_content"))."</span></td>
</tr></thead><tbody>".($direct_classes['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."</tbody>
</table>
<p class='pagecontent' style='text-align:center'><input type='submit' id='$f_form_id' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' onfocus=\"djs_formbuilder_focused('$f_form_id')\" /><script type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_form_id');
]]></script></p></form>");

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<p class='pagecontenttitle'>{$direct_cachedata['output_formiview_title']}</p>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}

	//f// direct_output_oset_default_embedded_form_preview ()
/**
	* direct_output_oset_default_embedded_form_preview ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_embedded_form_preview ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_form_preview ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_classes['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/$direct_cachedata[output_preview_function_file].php");
		$f_form_id = uniqid ("swg");

		if (function_exists ("direct_".$direct_cachedata['output_preview_function']))
		{
			$f_oset = "direct_".$direct_cachedata['output_preview_function'];

			$f_return = $f_oset ();
			$f_return .= "<p class='pagecontenttitle'>{$direct_cachedata['output_formtitle']}</p>";

			if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
			{
				$f_return .= "<p class='pagehighlightborder2' style='text-align:left'>";
				if ($direct_cachedata['output_credits_information']) { $f_return .= "<span class='pagecontent'>{$direct_cachedata['output_credits_information']}</span>"; }
				if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : "<span class='pagecontent'>{$direct_cachedata['output_credits_payment_data']}</span>"); }
				$f_return .= "</p>";
			}

$f_return .= ($direct_settings['iscript_form']." name='swgForm' id='swgForm' onsubmit=\"return djs_formbuilder_submit('swgForm');\">".(direct_linker ("form",$direct_cachedata['output_formtarget']))."<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead class='pagehide'><tr>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field"))."</span></td>
<td class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center;vertical-align:middle'><span class='pagetitlecellcontent'>".(direct_local_get ("formbuilder_field_content"))."</span></td>
</tr></thead><tbody>".($direct_classes['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."</tbody>
</table>
<p class='pagecontent' style='text-align:center'><input type='submit' id='$f_form_id' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' onfocus=\"djs_formbuilder_focused('$f_form_id')\" /><script type='text/javascript'><![CDATA[
djs_formbuilder_tabindex ('$f_form_id');
]]></script></p></form>");
		}

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<p class='pagecontenttitle'>{$direct_cachedata['output_formiview_title']}</p>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>