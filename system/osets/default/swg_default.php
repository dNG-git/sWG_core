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
* osets/default/swg_default.php
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
* @subpackage osets_default
* @since      v0.1.01
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

//f// direct_output_oset_default_aphandler ()
/**
* direct_output_oset_default_aphandler ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.01
*/
function direct_output_oset_default_aphandler ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_aphandler ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("aphandler_working"))."</p>";

	if (isset ($direct_cachedata['output_ajaxtarget']))
	{
$f_return = ("<script type='text/javascript'><![CDATA[
djs_var['core_aphandler_url'] = \"{$direct_cachedata['output_ajaxtarget']}\";

function djs_aphandler_call (f_params)
{
	djs_html5_progress ($(\"#swg_core_aphandler_point\"));
	if (typeof (f_params['url']) != 'undefined') { djs_var.core_aphandler_url = f_params.url; }
	if (djs_var.core_aphandler_url) { djs_swgAJAX_replace ({ id:'swg_core_aphandler_point',onReplace:{ func:'djs_aphandler_call',params: { } },url:djs_var.core_aphandler_url }); }
}
]]></script>");
	}

	$f_return .= "<div id='swg_core_aphandler_point' class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='width:40%;margin:0px 30%;text-align:center'><p style='font-weight:bold'>{$direct_cachedata['output_title']}</p>\n<div><span style='width:90%'>";
	$f_return .= (isset ($direct_cachedata['output_percentage']) ? "<progress value=\"{$direct_cachedata['output_percentage']}\" max='100' style='width:100%'><span style='font-weight:bold'>".(direct_local_get ("aphandler_progress")).":</span> {$direct_cachedata['output_percentage']}%</progress>" : "<progress style='width:100%'><span style='font-weight:bold'>".(direct_local_get ("aphandler_progress")).":</span> ".(direct_local_get ("core_unknown"))."</progress>");
	$f_return .= "</span>";

	if (isset ($direct_cachedata['output_ajaxtarget']))
	{
$f_return .= ("<script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_basic_functions.php.js',block:'djs_html5_progress' } });
djs_var.core_run_onload.push ({ func:'djs_load_functions',params: { file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' } });
djs_var.core_run_onload.push ({ func:'djs_aphandler_call',params: { } });
]]></script>");
	}

	$f_return .= "<br />\n<span style='font-style:10px'>";
	$f_return .= (isset ($direct_cachedata['output_text']) ? $direct_cachedata['output_text'] : direct_local_get ("aphandler_please_wait_a_second_js"));

$f_return .= ("</span></div>
<p class='pageextracontent' style='font-size:11px'><span style='font-weight:bold'>".(direct_local_get ("aphandler_time_elapsed"))."</span><br />
{$direct_cachedata['output_time_elapsed'][0]} : {$direct_cachedata['output_time_elapsed'][1]} : {$direct_cachedata['output_time_elapsed'][2]}</p>");

	if (!empty ($direct_cachedata['output_time_estimated']))
	{
$f_return .= ("\n<p class='pageextracontent' style='font-size:11px'><span style='font-weight:bold'>".(direct_local_get ("aphandler_time_estimated"))."</span><br />
{$direct_cachedata['output_time_estimated'][0]} : {$direct_cachedata['output_time_estimated'][1]} : {$direct_cachedata['output_time_estimated'][2]}</p>");
	}

	$f_return .= "\n<p class='pageextracontent' style='font-size:11px;font-weight:bold'>".(direct_local_get ("aphandler_hours"))." : ".(direct_local_get ("aphandler_minutes"))." : ".(direct_local_get ("aphandler_seconds"))."</p>\n</div>";

	return $f_return;
}

//f// direct_output_oset_default_done ()
/**
* direct_output_oset_default_done ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.01
*/
function direct_output_oset_default_done ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done ()- (#echo(__LINE__)#)"); }

	$f_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));
	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_title</p>\n<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if ($direct_cachedata['output_jsjump'] > 0)
		{
$f_embedded_code = ("<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>");

$f_return .= (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? $f_embedded_code : ("<p id='swgjsjump_point' class='pagecontent' style='font-weight:bold;text-align:center'><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params: { data:\"".(str_replace ('"','\"',$f_embedded_code))."\",id:'swgjsjump_point' } });
]]></script>"));

$f_return .= ("<script type='text/javascript'><![CDATA[
self.setTimeout (\"self.location.replace (\\\"{$direct_cachedata['output_pagetarget']}\\\")\",{$direct_cachedata['output_jsjump']});
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
* @since  v0.1.01
*/
function direct_output_oset_default_done_extended ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done_extended ()- (#echo(__LINE__)#)"); }

	$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default.php");
	$f_job_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));

	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_job_title</p>\n<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";
	if (isset ($direct_cachedata['output_job_entries'])) { $f_return .= direct_default_oset_done_job_entries_parse ($direct_cachedata['output_job_entries']); }
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
* @since  v0.1.01
*/
function direct_output_oset_default_error_critical ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_critical ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
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
* @since  v0.1.01
*/
function direct_output_oset_default_error_fatal ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_fatal ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error_fatal"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
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
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Debug checkpoint list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>";
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Error list</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>";
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
* @since  v0.1.01
*/
function direct_output_oset_default_error_login ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_login ()- (#echo(__LINE__)#)"); }

$f_return = ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>
<p class='pagecontent'>{$direct_cachedata['output_error']}</p>
<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent'><span style='font-weight:bold'>".(direct_local_get ("core_user_current")).":</span> {$direct_cachedata['output_current_user']}</p>
<p class='pagecontent'>".(direct_local_get ("core_access_rights_insufficient"))."</p>
<p class='pagecontent' style='font-weight:bold;text-align:center'><a href=\"{$direct_cachedata['output_link_login']}\" target='_self'>".(direct_local_get ("core_login_with_authorized_account"))."</a></p>");

	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p><ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
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
* @since  v0.1.01
*/
function direct_output_oset_default_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_standard ()- (#echo(__LINE__)#)"); }

	$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
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
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p><ul class='pagecontent' style='font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

if (isset ($direct_globals['@names']['output_formbuilder']))
{
	//f// direct_output_oset_default_form ()
/**
	* direct_output_oset_default_form ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.03
*/
	function direct_output_oset_default_form ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</p>\n";
		$f_form_id = uniqid ("swg");

		if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
		{
			$f_return .= "<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent' style='text-align:left'>";
			if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
			if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
			$f_return .= "</p>";
		}

$f_return .= ($direct_settings['iscript_form']." name='swg_form' id='swg_form'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."
<p class='pagecontent' style='text-align:center'><input type='submit' id='$f_form_id' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_form_id',type:'button' } });\n");

		if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'swg_form',id_button:'$f_form_id',type:'form' } });\n"; }
		$f_return .= "]]></script></p></form>";

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</p>"; }
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
	* @since  v0.1.03
*/
	function direct_output_oset_default_form_preview ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form_preview ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/$direct_cachedata[output_preview_function_file].php");
		$f_form_id = uniqid ("swg");

		if (function_exists ("direct_".$direct_cachedata['output_preview_function']))
		{
			$f_oset = "direct_".$direct_cachedata['output_preview_function'];

			$f_return = $f_oset ();
			$f_return .= "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</p>";

			if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
			{
				$f_return .= "<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent' style='text-align:left'>";
				if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
				if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
				$f_return .= "</p>";
			}

$f_return .= ($direct_settings['iscript_form']." name='swg_form' id='swg_form'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."
<p class='pagecontent' style='text-align:center'><input type='submit' id='$f_form_id' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'$f_form_id',type:'button' } });\n");

			if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'swg_form',id_button:'$f_form_id',type:'form' } });\n"; }
			$f_return .= "]]></script></p></form>";
		}

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</p>"; }
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
* @since  v0.1.01
*/
function direct_output_oset_default_redirect ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_redirect ()- (#echo(__LINE__)#)"); }

return ("<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_redirect"))."</p>
<p class='pagecontent'><span style='font-weight:bold'>".(direct_local_get ("core_redirect_url")).":</span> <a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>{$direct_cachedata['output_redirect']}</a></p>
<p id='swgjsjump_point' class='pagecontent' style='font-weight:bold;text-align:center'><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
djs_var.core_run_onload.push ({ func:'djs_swgDOM_replace',params:{ id:'swgjsjump_point',
data:\"<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
 \"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\"
} });
self.setTimeout (\"self.location.replace ('{$direct_cachedata['output_pagetarget']}')\",2000);
]]></script>");
}

//f// direct_output_oset_default_service_list ()
/**
* direct_output_oset_default_service_list ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.01
*/
function direct_output_oset_default_service_list ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_service_list ()- (#echo(__LINE__)#)"); }

	$f_filter_check = isset ($direct_cachedata['output_filter_tid']);
	if ($f_filter_check) { $f_filter_check = $direct_globals['basic_functions']->include_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_default_filter.php"); }
	$f_page_title = (isset ($direct_cachedata['output_services_title']) ? $direct_cachedata['output_services_title'] : direct_local_get ("core_service_list"));

	if (empty ($direct_cachedata['output_services']))
	{
		$f_return = "<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_page_title</p>";

		if ($f_filter_check)
		{
$f_return .= ("<span id='swg_default_service_list_filter_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
function djs_default_service_list_filter_replace (f_params)
{
djs_swgDOM_replace ({ id:'swg_default_service_list_filter_point',
data:(".(direct_output_oset_default_filter_table (true,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))."),
onReplace:{ func:'djs_default_service_list_filter_init',params:{ } } });
}
]]></script>");
		}

		$f_return .= "<p class='pagecontent'>".(direct_local_get ("core_service_list_empty"))."</p>";
	}
	else
	{
$f_return = ("<table class='pageborder1' style='width:100%;table-layout:auto'>
<thead><tr>
<td colspan='2' class='pagetitlecellbg' style='padding:$direct_settings[theme_td_padding];text-align:left'><span class='pagetitlecellcontent'>$f_page_title</span></td>
</tr></thead><tbody id='swg_default_service_list_filter_table'>");

		if ($direct_cachedata['output_pages'] > 1)
		{
$f_return .= ("<tr>
<td colspan='2' class='pageextrabg' style='padding:$direct_settings[theme_td_padding];text-align:center'><span class='pageextracontent' style='font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</span></td>
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
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:center;font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }

		if ($f_filter_check)
		{
$f_return .= ("<script type='text/javascript'><![CDATA[
function djs_default_service_list_filter_replace (f_params)
{
	var f_content = \"<tr>\\n<td colspan='2' class='pagebg' style='text-align:center'>\";

f_content += (".(direct_output_oset_default_filter_table (true,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text'])).");\n\n	");

	if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\$('#swg_default_service_list_filter_table tr:first-child').after (f_content + \"</td>\\n</tr>\");"; }
	else { $f_return .= "\$('#swg_default_service_list_filter_table tr:first-child').before (f_content + \"</td>\\n</tr>\");"; }

$f_return .= ("
	djs_run ({ func:'djs_default_service_list_filter_init',params:{ } });
}
]]></script>");
		}
	}

	if ($f_filter_check)
	{
$f_return .= ("<script type='text/javascript'><![CDATA[
function djs_default_service_list_filter_init (f_params)
{
	\$('#swg_default_service_list_filter_pointb').bind ('click',function () { djs_default_service_list_filter_process (encodeURIComponent (\$('#swg_default_service_list_filter_pointi').val ())); });

	djs_formbuilder_init ({ id:'swg_default_service_list_filter_pointi' });
	djs_formbuilder_init ({ id:'swg_default_service_list_filter_pointb',type:'button' });
}

function djs_default_service_list_filter_process (f_text) { self.location.replace ('".(direct_linker ("url1","s=filter;dsd=dtheme+1++dfid+{$direct_cachedata['output_filter_fid']}++dftext+[text]++tid+{$direct_cachedata['output_filter_tid']}++source+".$direct_cachedata['output_filter_source'],false))."'.replace (/\[text\]/g,f_text)); }

djs_var.core_run_onload.push ({ func:'djs_default_service_list_filter_replace',params: { } });
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'swg_default_service_list_filter_pointi' } });
djs_var.core_run_onload.push ({ func:'djs_formbuilder_init',params: { id:'swg_default_service_list_filter_pointb',type:'button' } });
]]></script>");
	}

	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>