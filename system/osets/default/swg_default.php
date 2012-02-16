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

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("aphandler_working"))."</h1>";

	if (isset ($direct_cachedata['output_ajaxtarget']))
	{
$f_return = ("<script type='text/javascript'><![CDATA[
djs_var['core_aphandler_url'] = \"{$direct_cachedata['output_ajaxtarget']}\";

function djs_aphandler_call (f_params)
{
	djs_html5_progress (jQuery(\"#swg_core_aphandler_point\"));
	if ('url' in f_params) { djs_var.core_aphandler_url = f_params.url; }
	if (djs_var.core_aphandler_url) { djs_swgAJAX_replace ({ id:'swg_core_aphandler_point',onReplace:{ func:'djs_aphandler_call',params: { } },url:djs_var.core_aphandler_url }); }
}
]]></script>");
	}

	$f_return .= "<div id='swg_core_aphandler_point' class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='width:40%;margin:0px 30%;text-align:center'><p><strong>{$direct_cachedata['output_title']}</strong></p>\n<div><span style='width:90%'>";
	$f_return .= (isset ($direct_cachedata['output_percentage']) ? "<progress value=\"{$direct_cachedata['output_percentage']}\" max='100' style='width:100%'><strong>".(direct_local_get ("aphandler_progress")).":</strong> {$direct_cachedata['output_percentage']}%</progress>" : "<progress style='width:100%'><strong>".(direct_local_get ("aphandler_progress")).":</strong> ".(direct_local_get ("core_unknown"))."</progress>");
	$f_return .= "</span>";

	if (isset ($direct_cachedata['output_ajaxtarget']))
	{
$f_return .= ("<script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_load_functions ({ file:'swg_basic_functions.php.js',block:'djs_html5_progress' });
	djs_load_functions ({ file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' });
	djs_aphandler_call ({});
});
]]></script>");
	}

	$f_return .= "<br />\n<span style='font-style:10px'>";
	$f_return .= (isset ($direct_cachedata['output_text']) ? $direct_cachedata['output_text'] : direct_local_get ("aphandler_please_wait_a_second_js"));

$f_return .= ("</span></div>
<p class='pageextracontent' style='font-size:11px'><strong>".(direct_local_get ("aphandler_time_elapsed"))."</strong><br />
{$direct_cachedata['output_time_elapsed'][0]} : {$direct_cachedata['output_time_elapsed'][1]} : {$direct_cachedata['output_time_elapsed'][2]}</p>");

	if (!empty ($direct_cachedata['output_time_estimated']))
	{
$f_return .= ("\n<p class='pageextracontent' style='font-size:11px'><strong>".(direct_local_get ("aphandler_time_estimated"))."</strong><br />
{$direct_cachedata['output_time_estimated'][0]} : {$direct_cachedata['output_time_estimated'][1]} : {$direct_cachedata['output_time_estimated'][2]}</p>");
	}

	$f_return .= "\n<p class='pageextracontent' style='font-size:11px'><strong>".(direct_local_get ("aphandler_hours"))." : ".(direct_local_get ("aphandler_minutes"))." : ".(direct_local_get ("aphandler_seconds"))."</strong></p>\n</div>";

	return $f_return;
}

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
	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_title</h1>\n<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if ($direct_cachedata['output_jsjump'] > 0)
		{
$f_embedded_code = ("<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>");

$f_return .= (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? "\n".$f_embedded_code : ("\n<p id='swgjsjump_point' class='pagecontent' style='text-align:center'><strong><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p><script type='text/javascript'><![CDATA[
jQuery (function () { djs_swgDOM_replace ({ data:\"".(str_replace ('"','\"',$f_embedded_code))."\",id:'swgjsjump_point' }); });
]]></script>"));

$f_return .= ("<script type='text/javascript'><![CDATA[
self.setTimeout (\"self.location.replace (\\\"{$direct_cachedata['output_pagetarget']}\\\")\",{$direct_cachedata['output_jsjump']});
]]></script>");
		}
		else { $f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p>"; }
	}

	return $f_return;
}

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

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_job_title</h1>\n<p class='pagecontent'>{$direct_cachedata['output_job_desc']}</p>";
	if (isset ($direct_cachedata['output_job_entries'])) { $f_return .= direct_default_oset_done_job_entries_parse ($direct_cachedata['output_job_entries']); }
	if (isset ($direct_cachedata['output_pagetarget'])) { $f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p>"; }

	return $f_return;
}

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

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</h1>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

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

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error_fatal"))."</h1>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Debug checkpoint list</h2>\n<ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>";
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Error list</h2>\n<ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>";
		}
	}

	return $f_return."\n<p class='pagecontent' style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";
}

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

$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</h1>
<p class='pagecontent'>{$direct_cachedata['output_error']}</p>
<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent'><strong>".(direct_local_get ("core_user_current")).":</strong> {$direct_cachedata['output_current_user']}</p>
<p class='pagecontent'>".(direct_local_get ("core_access_rights_insufficient"))."</p>
<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_login']}\" target='_self'>".(direct_local_get ("core_login_with_authorized_account"))."</a></strong></p>");

	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul class='pagecontent' style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

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

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</h1>\n<p class='pagecontent'>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p class='pagecontent' style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p class='pagecontent' style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul class='pagecontent' style='font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	return $f_return;
}

if (isset ($direct_globals['@names']['output_formbuilder']))
{
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

		$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</h1>\n";
		$f_form_id = uniqid ("swg");

		if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
		{
			$f_return .= "<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent' style='text-align:left'>";
			if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
			if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
			$f_return .= "</p>\n";
		}

$f_return .= ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."
<p class='pagecontent' style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });\n");

		if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "\tdjs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });\n"; }
		$f_return .= "});\n]]></script></p></form>";

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</h1>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}

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
			$f_return .= "\n<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</h1>\n";

			if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
			{
				$f_return .= "<p class='pagehighlightborder2{$direct_settings['theme_css_corners']} pagecontent' style='text-align:left'>";
				if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
				if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
				$f_return .= "</p>\n";
			}

$f_return .= ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."
<p class='pagecontent' style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });\n");

			if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "\tdjs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });\n"; }
			$f_return .= "});\n]]></script></p></form>";
		}

/*i// LICENSE_WARNING
----------------------------------------------------------------------------
The sWG DataLinker has been published under the General Public License.
----------------------------------------------------------------------------
LICENSE_WARNING_END //i*/

		if ((isset ($direct_cachedata['output_formiview_id']))&&(isset ($direct_cachedata['output_formiview_url'])))
		{
			$direct_globals['basic_functions']->require_file ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</h1>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}

/**
	* direct_output_oset_default_options ()
	*
	* @uses   direct_debug()
	* @uses   USE_debug_reporting
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_options ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_options ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		if (isset ($direct_cachedata['output_formelements']))
		{
			$f_form_id = uniqid ("swg");
		
$f_return = ("<h1>".(direct_local_get ("core_options"))."</h1>
{$direct_settings['iscript_form']} name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->form_get ($direct_cachedata['output_formelements']))."
<p class='pagecontent' style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"".(direct_local_get ("core_continue","text"))."\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_load_functions ({ file:'swg_formbuilder.php.js' });
	djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });\n");

			if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "\tdjs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });\n"; }
			$f_return .= "});\n]]></script></p></form>";
		}

		return $f_return;
	}
}

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

return ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_redirect"))."</h1>
<p class='pagecontent'><strong>".(direct_local_get ("core_redirect_url")).":</strong> <a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>{$direct_cachedata['output_redirect']}</a></p>
<p id='swgjsjump_point' class='pagecontent' style='text-align:center'><strong><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p><script type='text/javascript'><![CDATA[
jQuery (function ()
{
djs_swgDOM_replace ({ data:\"<p class='pagecontent' style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
\"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\",id:'swgjsjump_point' });
});
self.setTimeout (\"self.location.replace ('{$direct_cachedata['output_pagetarget']}')\",2000);
]]></script>");
}

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
		$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_page_title</h1>\n";

		if ($f_filter_check)
		{
			if (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))
			{
$f_return .= (direct_output_oset_default_filter_table (false,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text'])."<script type='text/javascript'><![CDATA[
jQuery (function () { djs_default_service_list_filter_init ({ border:true }); });
]]></script>");
			}
			else
			{
$f_return .= ("<span id='swg_default_service_list_filter_point' style='display:none'><!-- iPoint // --></span><script type='text/javascript'><![CDATA[
jQuery (function ()
{
djs_swgDOM_replace ({ data:(".(direct_output_oset_default_filter_table (true,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))."),id:'swg_default_service_list_filter_point',onReplace:{ func:'djs_default_service_list_filter_init',params:{ border:true } } });
});
]]></script>");
			}
		}

		$f_return .= "<p class='pagecontent'>".(direct_local_get ("core_service_list_empty"))."</p>";
	}
	else
	{
$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_page_title</h1>
<table class='pageborder1' style='width:100%;table-layout:auto'>
<tbody id='swg_default_service_list_filter_table'>");

		if ($f_filter_check)
		{
			if (isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))
			{
$f_return .= ("<tr>\n<td colspan='2' class='pagebg' style='text-align:center'>".(direct_output_oset_default_filter_table (false,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text']))."<script type='text/javascript'><![CDATA[
jQuery (function () { djs_default_service_list_filter_init ({ border:false }); });
]]></script></td>\n</tr>");
			}
			else
			{
$f_embedded_code = ("<script type='text/javascript'><![CDATA[
jQuery (function ()
{
	var f_content = \"<tr>\\n<td colspan='2' class='pagebg' style='text-align:center'>\";

f_content += (".(direct_output_oset_default_filter_table (true,"swg_default_service_list_filter_point",(direct_local_get ("core_filter_search","text")),$direct_cachedata['output_filter_text'])).");\n\n");

				if ($direct_cachedata['output_pages'] > 1) { $f_embedded_code .= "\tdjs_swgDOM_insert_after ({ animate: false,data: f_content + \"</td>\\n</tr>\",id: 'swg_default_service_list_filter_table tr:first-child',onInsert: { func: 'djs_default_service_list_filter_init',params: { border:false } } });"; }
				else { $f_embedded_code .= "\tdjs_swgDOM_insert_before ({ animate: false,data: f_content + \"</td>\\n</tr>\",id: 'swg_default_service_list_filter_table tr:first-child',onInsert: { func: 'djs_default_service_list_filter_init',params: { border: false } } });"; }

				$f_embedded_code .= "\n});\n]]></script>";
			}
		}

		if ($direct_cachedata['output_pages'] > 1)
		{
$f_return .= ("<tr>
<td colspan='2' class='pageextrabg pageextracontent' style='padding:$direct_settings[theme_td_padding];text-align:center;font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</td>
</tr>");
		}

		$f_services_count = count ($direct_cachedata['output_services']);

		foreach ($direct_cachedata['output_services'] as $f_service_array)
		{
			if ($f_services_count > 1)
			{
				if (isset ($f_right_switch))
				{
					if ($f_right_switch)
					{
						$f_return .= "</td>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = false;
					}
					else
					{
						$f_return .= "</td>\n</tr><tr>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
						$f_right_switch = true;
					}
				}
				else
				{
					$f_return .= "<tr>\n<td class='pagebg pagecontent' style='width:50%;padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
					$f_right_switch = true;
				}
			}
			else
			{
				$f_return .= "<tr>\n<td colspan='2' class='pagebg pagecontent' style='padding:$direct_settings[theme_td_padding];text-align:left;vertical-align:middle'>";
				$f_right_switch = false;
			}

			if ($f_service_array[0]) { $f_service_array[0] = "<img src='{$f_service_array[0]}' alt='{$f_service_array[1]}' title='{$f_service_array[1]}' style='float:left;padding:0px 5px' />"; }

$f_return .= ($f_service_array[0]."<a href='{$f_service_array[2]}' target='_self'>{$f_service_array[1]}</a><br />
<span style='font-size:10px'>{$f_service_array[3]}</span>");
		}

		$f_return .= ($f_right_switch ? "</td>\n<td class='pagebg' style='width:50%;font-size:8px'>&#0160;</td>\n</tr></tbody>\n</table>" : "</td>\n</tr></tbody>\n</table>");
		if ($direct_cachedata['output_pages'] > 1) { $f_return .= "\n<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent' style='text-align:center;font-size:10px'>".(direct_output_pages_generator ($direct_cachedata['output_page_url'],$direct_cachedata['output_pages'],$direct_cachedata['output_page']))."</p>"; }
		if (($f_filter_check)&&(!isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']))) { $f_return .= $f_embedded_code; }
	}

	if ($f_filter_check)
	{
$f_return .= ("<script type='text/javascript'><![CDATA[
function djs_default_service_list_filter_init (f_params)
{
	if (f_params.border) { jQuery('#swg_default_service_list_filter_point').addClass ('pageborder1'); }
	jQuery('#swg_default_service_list_filter_pointb').on ('click',function () { djs_default_service_list_filter_process (encodeURIComponent (jQuery('#swg_default_service_list_filter_pointi').val ())); });

	djs_formbuilder_init ({ id:'swg_default_service_list_filter_pointi' });
	djs_formbuilder_init ({ id:'swg_default_service_list_filter_pointb',type:'button' });
}

function djs_default_service_list_filter_process (f_text) { self.location.replace ('".(direct_linker_dynamic ("url1","s=filter;dsd=dtheme+1++dfid+{$direct_cachedata['output_filter_fid']}++dftext+[text]++tid+{$direct_cachedata['output_filter_tid']}++source+".$direct_cachedata['output_filter_source'],false))."'.replace (/\[text\]/g,f_text)); }
]]></script>");
	}

	return $f_return;
}

/**
* direct_output_oset_default_selection_list ()
*
* @uses   direct_debug()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_selection_list ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_selection_list ()- (#echo(__LINE__)#)"); }

	$g_title = (isset ($direct_cachedata['output_selection_title']) ? $direct_cachedata['output_selection_title'] : direct_local_get ("core_selection_list"));
	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$g_title</h1>\n<p class='pagecontent'>";

	if (empty ($direct_cachedata['output_selection_list'])) { $f_return .= direct_local_get ("core_selection_list_empty"); }
	else
	{
		$f_first_check = true;

		foreach ($direct_cachedata['output_selection_list'] as $f_selected_id => $f_selected_title)
		{
			if ($f_first_check) { $f_first_check = false; }
			else { $f_return .= ", "; }

			$f_return .= $f_selected_title;
		}
	}

	$f_return .= " (<a href=\"".(direct_linker_dynamic ("url0",$direct_cachedata['output_selector_url']))."\" target='_self'>".(direct_local_get ("core_selector_activate"))."</a>)</p>";

	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>