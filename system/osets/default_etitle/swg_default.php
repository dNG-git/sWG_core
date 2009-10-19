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
* osets/default_etitle/swg_default.php
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

//f// direct_output_oset_default_aphandler ()
/**
* direct_output_oset_default_aphandler ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_aphandler ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_aphandler ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("aphandler_working");

	$f_return = "";

	if (($direct_cachedata['output_ajaxtarget'])&&($direct_cachedata['output_ajaxnexttarget']))
	{
$f_return .= ("<script type='text/javascript'><![CDATA[
djs_var['core_aphandler_ajax_mode'] = false;

if ((djs_swgAJAX)&&(djs_swgDOM))
{
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		djs_var['core_aphandler_ajax_mode'] = true;

		function djs_core_aphandler_call () { djs_swgAJAX_call ('core_aphandler_ajax_helper',djs_core_aphandler_response,'GET','{$direct_cachedata['output_ajaxtarget']}',30000); }
		djs_var['core_run_onload'].push ('djs_core_aphandler_call ()');

		function djs_core_aphandler_response ()
		{
			var f_result_code = djs_swgAJAX_response ('core_aphandler_ajax_helper','swg_core_aphandler_point','{$direct_cachedata['output_ajaxnexttarget']}');
			if (f_result_code == 200) { self.setTimeout ('djs_core_aphandler_call ()',500); }
		}
	}
}
]]></script>");
	}

$f_return .= ("<div id='swg_core_aphandler_point' style='text-align:center'><table class='pageborder1' style='table-layout:auto'>
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
</tr><tr>
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
</table></div>
<p id='swgjsjump_point' class='pagecontent' style='text-align:center;font-weight:bold'>".(direct_local_get ("aphandler_please_wait_a_second_nojs"))."<br /><br />
<span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
\"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\",'swgjsjump_point');\n");

	if (($direct_cachedata['output_ajaxtarget'])&&($direct_cachedata['output_ajaxnexttarget'])) { $f_return .= "\nif (!djs_var['core_aphandler_ajax_mode']) { djs_var['core_run_onload'].push ('self.setTimeout (\"self.location.replace (\\'{$direct_cachedata['output_scripttarget']}\\')\",1000)'); }"; }
	else { $f_return .= "\ndjs_var['core_run_onload'].push ('self.setTimeout (\"self.location.replace (\\'{$direct_cachedata['output_scripttarget']}\\')\",1000)');"; }

	return $f_return."\n]]></script>";
}

//f// direct_output_oset_default_done ()
/**
* direct_output_oset_default_done ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_done ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));
	$f_return = "<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";

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

//f// direct_output_oset_default_done_extended ()
/**
* direct_output_oset_default_done_extended ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_done_extended ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done_extended ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));

$f_return = ("<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>
<p class='pagecontenttitle' style='font-size:10px'>".(direct_local_get ("core_detailed_information"))."</p>
<p class='pagecontent' style='font-size:10px'>{$direct_cachedata['output_job_extension']}</p>");

	if (isset ($direct_cachedata['output_pagetarget'])) { $f_return .= "\n<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p>"; }

	return $f_return;
}

//f// direct_output_oset_default_error_critical ()
/**
* direct_output_oset_default_done ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_error_critical ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_critical ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("core_error");

	$f_return = "<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

//f// direct_output_oset_default_error_fatal ()
/**
* direct_output_oset_default_error_fatal ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_error_fatal ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_fatal ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("core_error_fatal");

	$f_return = "<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
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
		$f_return .= "\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= "\n<p class='pagecontenttitle'>Debug checkpoint list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>";
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= "\n<p class='pagecontenttitle'>Error list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>";
		}
	}

	return $f_return."\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";
}

//f// direct_output_oset_default_error_login ()
/**
* direct_output_oset_default_error_login ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_error_login ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_login ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("core_error");

$f_return = ("<p class='pagecontent'>{$direct_cachedata['output_error']}</p>
<p class='pagehighlightborder2'><span class='pagecontent'><span style='font-weight:bold'>".(direct_local_get ("core_user_current")).":</span> {$direct_cachedata['output_current_user']}</span></p>
<p class='pagecontent'>".(direct_local_get ("core_access_rights_insufficient"))."</p>
<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_link_login']}\" target='_self'>".(direct_local_get ("core_login_with_authorized_account"))."</a></p>");

	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

//f// direct_output_oset_default_error_standard ()
/**
* direct_output_oset_default_error_standard ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_standard ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("core_error");

	$f_return = "<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
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
		$f_return .= "\n<p class='pagecontenttitle'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

if (isset ($direct_classes['@names']['output_formbuilder']))
{
	//f// direct_output_oset_default_form ()
/**
	* direct_output_oset_default_form ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.06
*/
	function direct_output_oset_default_form ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form ()- (#echo(__LINE__)#)"); }

		$direct_settings['theme_output_page_title'] = $direct_cachedata['output_formtitle'];

		if (!isset ($direct_classes['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$f_form_id = uniqid ("swg");

		$f_return = "";

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

	//f// direct_output_oset_default_form_preview ()
/**
	* direct_output_oset_default_form_preview ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.06
*/
	function direct_output_oset_default_form_preview ()
	{
		global $direct_cachedata,$direct_classes,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form_preview ()- (#echo(__LINE__)#)"); }

		$direct_settings['theme_output_page_title'] = $direct_cachedata['output_formtitle'];

		if (!isset ($direct_classes['output_oset_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/$direct_cachedata[output_preview_function_file].php");
		$f_form_id = uniqid ("swg");

		if (function_exists ("direct_".$direct_cachedata['output_preview_function']))
		{
			$f_oset = "direct_".$direct_cachedata['output_preview_function'];

			$f_return = $f_oset ();

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

//f// direct_output_oset_default_redirect ()
/**
* direct_output_oset_default_redirect ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_redirect ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_redirect ()- (#echo(__LINE__)#)"); }

	$direct_settings['theme_output_page_title'] = direct_local_get ("core_redirect");

return ("<p class='pagecontent'><span style='font-weight:bold'>".(direct_local_get ("core_redirect_url")).":</span> <a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>{$direct_cachedata['output_redirect']}</a></p>
<p id='swgjsjump_point' class='pagecontent' style='font-weight:bold;text-align:center'><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
djs_swgDOM_replace (\"<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
\"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\",'swgjsjump_point');
self.setTimeout (\"self.location.replace ('{$direct_cachedata['output_scripttarget']}')\",2000);
]]></script>");
}

//f// direct_output_oset_default_service_list ()
/**
* direct_output_oset_default_service_list ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_service_list ()
{
	global $direct_cachedata,$direct_classes,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_service_list ()- (#echo(__LINE__)#)"); }

	$f_filter_check = isset ($direct_cachedata['output_filter_tid']);
	if ($f_filter_check) { $f_filter_check = $direct_classes['basic_functions']->include_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php"); }
	$direct_settings['theme_output_page_title'] = (isset ($direct_cachedata['output_services_title']) ? $direct_cachedata['output_services_title'] : direct_local_get ("core_service_list"));

	if (empty ($direct_cachedata['output_services']))
	{
$f_return = ("<div id='swg_default_service_list_filter_point' style='display:none'><!-- iPoint // --></div><script type='text/javascript'><![CDATA[
if (djs_swgDOM)
{
".(direct_output_oset_default_filter_table (true,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),"djs_default_service_list_filter_process ()",$direct_cachedata['output_filter_text']))."

	function djs_default_service_list_filter_process () { self.location.replace ('".(direct_linker ("url1","m=dataport&s=swgap;default;filter&dsd=dtheme+1++dfid+{$direct_cachedata['output_filter_fid']}++dftext+[f_text]++tid+{$direct_cachedata['output_filter_tid']}++source+".$direct_cachedata['output_filter_source'],false))."'.replace (/\[f_text\]/g,(encodeURIComponent (self.document.getElementById('swg_default_service_list_filter_point_f').value)))); }
	djs_formbuilder_tabindex ('swg_default_service_list_filter_point_f');
	djs_formbuilder_tabindex ('swg_default_service_list_filter_point_b');
}
]]></script><p class='pagecontent'>".(direct_local_get ("core_service_list_empty"))."</p>");
	}
	else
	{
$f_return = ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead class='pagehide'><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pagetitlecellcontent'>$direct_settings[theme_output_page_title]</span></td>
</tr></thead><tbody>");

		if ($direct_cachedata['output_pages'] > 1)
		{
$f_return .= ("<tr>
<td colspan='2' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></td>
</tr>");
		}

		if ($f_filter_check)
		{
$f_return .= ("<tr id='swg_default_service_list_filter_point1' style='display:none'>
<td colspan='2' class='pagebg' style='padding:$direct_settings[theme_td_padding];text-align:center'>".(direct_output_oset_default_filter_table (false,"swg_default_service_list_filter_point2",(direct_local_get ("core_filter_search","text")),"djs_default_service_list_filter_process ()",$direct_cachedata['output_filter_text']))."<script type='text/javascript'><![CDATA[
if (djs_swgDOM)
{
	djs_var['swg_default_service_list_filter_point1_style_display'] = 'table-row';
	djs_var['core_run_onload'].push ('djs_iblock_init (\"swg_default_service_list_filter_point1\",true)');

	function djs_default_service_list_filter_process () { self.location.replace ('".(direct_linker ("url1","m=dataport&s=swgap;default;filter&dsd=dtheme+1++dfid+{$direct_cachedata['output_filter_fid']}++dftext+[f_text]++tid+{$direct_cachedata['output_filter_tid']}++source+".$direct_cachedata['output_filter_source'],false))."'.replace (/\[f_text\]/g,(encodeURIComponent (self.document.getElementById('swg_default_service_list_filter_point2_f').value)))); }
	djs_formbuilder_tabindex ('swg_default_service_list_filter_point2_f');
	djs_formbuilder_tabindex ('swg_default_service_list_filter_point2_b');
}
]]></script></td>
</tr>");
		}

		foreach ($direct_cachedata['output_services'] as $f_service_array)
		{
			if (isset ($f_right_switch))
			{
				if ($f_right_switch)
				{
					$f_return .= "</td>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = false;
				}
				else
				{
					$f_return .= "</td>\n</tr><tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td class='pagebg' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
				$f_right_switch = true;
			}

			if ($f_service_array[0]) { $f_service_array[0] = "<img src='{$f_service_array[0]}' alt='{$f_service_array[1]}' title='{$f_service_array[1]}' style='float:left;padding:0px 5px' />"; }

$f_return .= ("<span class='pagecontent'>{$f_service_array[0]}<a href='{$f_service_array[2]}' target='_self'>{$f_service_array[1]}</a><br />
<span style='font-size:10px'>{$f_service_array[3]}</span></span>");
		}

		$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%'><span style='font-size:8px'>&#0160;</span></td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2' style='text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></p>"; }
	}

	return $f_return;
}

//j// Script specific commands

if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>