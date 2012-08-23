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
* osets/default/swg_default_embedded.php
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
* @since      v0.1.03
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/**
* direct_output_oset_default_embedded_ajax_aphandler ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_aphandler ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_aphandler ()- (#echo(__LINE__)#)"); }

$f_return = ("<div id='swg_core_aphandler_point' class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='width:40%;margin:0px 30%;text-align:center'><p><strong>{$direct_cachedata['output_title']}</strong></p>
<div><span style='width:90%'><progress".(isset ($direct_cachedata['output_percentage']) ? " value=\"{$direct_cachedata['output_percentage']}\"" : "")." max='100' style='width:100%'><strong>".(direct_local_get ("aphandler_progress")).":</strong> ".(isset ($direct_cachedata['output_percentage']) ? $direct_cachedata['output_percentage']."%" : direct_local_get ("core_unknown"))."</progress></span><br />
<span style='font-size:10px'>".(isset ($direct_cachedata['output_text']) ? $direct_cachedata['output_text'] : direct_local_get ("aphandler_please_wait_a_second_js"))."</span></div>
<p style='font-size:11px'><strong>".(direct_local_get ("aphandler_time_elapsed"))."</strong><br />
{$direct_cachedata['output_time_elapsed'][0]} : {$direct_cachedata['output_time_elapsed'][1]} : {$direct_cachedata['output_time_elapsed'][2]}</p>");

	if (!empty ($direct_cachedata['output_time_estimated']))
	{
$f_return .= ("\n<p style='font-size:11px'><strong>".(direct_local_get ("aphandler_time_estimated"))."</strong><br />
{$direct_cachedata['output_time_estimated'][0]} : {$direct_cachedata['output_time_estimated'][1]} : {$direct_cachedata['output_time_estimated'][2]}</p>");
	}

	$f_return .= "\n<p style='font-size:11px'><strong>".(direct_local_get ("aphandler_hours"))." : ".(direct_local_get ("aphandler_minutes"))." : ".(direct_local_get ("aphandler_seconds"))."</strong></p>\n</div>";

	return $f_return;
}

/**
* direct_output_oset_default_embedded_ajax_error_critical ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_error_critical ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_error_critical ()- (#echo(__LINE__)#)"); }

	$f_return = "<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	$f_return .= "</div>";
	return $f_return;
}

/**
* direct_output_oset_default_embedded_ajax_error_fatal ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_error_fatal ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_error_fatal ()- (#echo(__LINE__)#)"); }

	$f_return = "<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error_fatal"))."</p>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Debug checkpoint list</p>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>";
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Error list</p>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>";
		}
	}

	$f_return .= "<p style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p></div>";
	return $f_return;
}

/**
* direct_output_oset_default_embedded_ajax_error_login ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_error_login ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_error_login ()- (#echo(__LINE__)#)"); }

$f_return = ("<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>
<p>{$direct_cachedata['output_error']}</p>
<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pagehighlightbg pageextracontent'><strong>".(direct_local_get ("core_user_current")).":</strong> {$direct_cachedata['output_current_user']}</p>
<p>".(direct_local_get ("core_access_rights_insufficient"))."</p>
<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_login']}\" target='_self'>".(direct_local_get ("core_login_with_authorized_account"))."</a></strong></p>");

	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	$f_return .= "</div>";
	return $f_return;
}

/**
* direct_output_oset_default_embedded_ajax_error_standard ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_ajax_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_error_standard ()- (#echo(__LINE__)#)"); }

	$f_return = "<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</p>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= "\n<p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</p>\n<ul style='font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>";
	}

	$f_return .= "</div>";
	return $f_return;
}

if (isset ($direct_globals['@names']['output_formbuilder']))
{
/**
	* direct_output_oset_default_embedded_ajax_options ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_embedded_ajax_options ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_options ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		if (isset ($direct_cachedata['output_formelements']))
		{
			if (isset ($direct_cachedata['output_ajax_javascript_requirements'])) { $direct_cachedata['output_ajax_javascript_requirements'][] = "file:'swg_formbuilder.php.js'"; }
			else { $direct_cachedata['output_ajax_javascript_requirements'] = array ("file:'swg_formbuilder.php.js'"); }

			$f_form_id = uniqid ("swg");

$f_return = ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->formGet ($direct_cachedata['output_formelements']))."
<p style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"".(direct_local_get ("core_continue","text"))."\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });\n");

			if (isset ($direct_cachedata['output_formsupport_ajax_dialog'])) { $f_return .= "djs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });\n"; }
			$f_return .= "]]></script></p></form>";
		}

		return $f_return;
	}
}

/**
* direct_output_oset_default_embedded_ajax_selection_list ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_embedded_ajax_selection_list ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_ajax_selection_list ()- (#echo(__LINE__)#)"); }

	$f_return = (((isset ($direct_cachedata['output_selection_title_hidden']))&&($direct_cachedata['output_selection_title_hidden'])) ? "<div>" : "<div><p class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_selection_title']}</p>\n");
	$f_return .= "<p>";

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

	$f_return .= " (<a href=\"javascript:djs_swgAJAX_replace_url0('swgAJAX_embed_{$direct_cachedata['output_tid']}_point','{$direct_cachedata['output_selector_url']}')\">".(direct_local_get ("core_selector_activate"))."</a>)</p></div>";

	return $f_return;
}

/**
* direct_output_oset_default_embedded_done ()
*
* @return string Valid XHTML code
* @since  v0.1.08
*/
function direct_output_oset_default_embedded_done ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_done ()- (#echo(__LINE__)#)"); }

	$f_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));
	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_title</h1>\n<p>{$direct_cachedata['output_job_desc']}</p>";

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if ($direct_cachedata['output_jsjump'] > 0)
		{
$f_embedded_code = ("<p style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>");

$f_return .= ((isset ($direct_settings['swg_clientsupport']['JSDOMManipulation']) ? $f_embedded_code : ("<p id='swgjsjump_point' style='text-align:center'><strong><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p><script type='text/javascript'><![CDATA[
jQuery (function () { djs_DOM_replace ({ data:\"".(str_replace ('"','\"',$f_embedded_code))."\",id:'swgjsjump_point' }); });
]]></script>"))."<script type='text/javascript'><![CDATA[
self.setTimeout (\"self.location.replace (\\\"{$direct_cachedata['output_pagetarget']}\\\")\",{$direct_cachedata['output_jsjump']});
]]></script>");
		}
		else { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p>"; }
	}

	return $f_return;
}

/**
* direct_output_oset_default_embedded_done_extended ()
*
* @return string Valid XHTML code
* @since  v0.1.08
*/
function direct_output_oset_default_embedded_done_extended ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_done_extended ()- (#echo(__LINE__)#)"); }

	$f_title = ($direct_cachedata['output_job'] ? (direct_local_get ("core_done")).": ".$direct_cachedata['output_job'] : direct_local_get ("core_done"));

$f_return = ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>$f_title</h1>
<p>{$direct_cachedata['output_job_desc']}</p>
<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}' style='font-size:10px'>".(direct_local_get ("core_detailed_information"))."</h2>
<p style='font-size:10px'>{$direct_cachedata['output_job_extension']}</p>");

	if (isset ($direct_cachedata['output_pagetarget'])) { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p>"; }

	return $f_return;
}

/**
* direct_output_oset_default_embedded_error_critical ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_critical ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_critical ()- (#echo(__LINE__)#)"); }

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</h1>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }
	$f_return .= "\n<p style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	return $f_return;
}

/**
* direct_output_oset_default_embedded_error_fatal ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_fatal ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_fatal ()- (#echo(__LINE__)#)"); }

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error_fatal"))."</h1>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}' target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	if (USE_debug_reporting)
	{
		if (!empty ($direct_cachedata['core_debug']))
		{
			$f_debug_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug']);
			$f_return .= ("\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Debug checkpoint list</h2>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_debug_array))."</li></ul>");
		}

		if (!empty ($direct_cachedata['core_error']))
		{
			$f_error_array = array_map ("direct_html_encode_special",$direct_cachedata['core_error']);
			$f_return .= ("\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Error list</h2>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_error_array))."</li></ul>");
		}
	}

	$f_return .= "<p style='text-align:center'>".(direct_local_get ("core_unable_to_proceed"))."</p>";
	return $f_return;
}

/**
* direct_output_oset_default_embedded_error_standard ()
*
* @return string Valid XHTML code
* @since  v0.1.06
*/
function direct_output_oset_default_embedded_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_error_standard ()- (#echo(__LINE__)#)"); }

	$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_error"))."</h1>\n<p>{$direct_cachedata['output_error']}</p>";
	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if ($direct_cachedata['output_link_back'])
	{
		$f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_back']}\" target='_self'>".(direct_local_get ("core_back"))."</a></strong>";
		if ($direct_cachedata['output_link_retry']) { $f_return .= "<br />\n<a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a>"; }
		$f_return .= "</p>";
	}
	elseif ($direct_cachedata['output_link_retry']) { $f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_retry']}\" target='_self'>".(direct_local_get ("core_try_again"))."</a></strong></p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<h2 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>Backtrace</h2>\n<ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}

	return $f_return;
}

if (isset ($direct_globals['@names']['output_formbuilder']))
{
/**
	* direct_output_oset_default_embedded_form ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_embedded_form ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_form ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		$f_return = "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</h1>\n";
		$f_form_id = uniqid ("swg");

		if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
		{
			$f_return .= "<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pagebg pagecontent' style='text-align:left'>";
			if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
			if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
			$f_return .= "</p>\n";
		}

$f_return .= ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->formGet ($direct_cachedata['output_formelements']))."
<p style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
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
			$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</h1>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}

/**
	* direct_output_oset_default_embedded_form_preview ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.08
*/
	function direct_output_oset_default_embedded_form_preview ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_form_preview ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }
		$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/$direct_cachedata[output_preview_function_file].php");
		$f_form_id = uniqid ("swg");

		if (function_exists ("direct_".$direct_cachedata['output_preview_function']))
		{
			$f_oset = "direct_".$direct_cachedata['output_preview_function'];

			$f_return = $f_oset ();
			$f_return .= "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formtitle']}</h1>\n";

			if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
			{
				$f_return .= "<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pagebg pagecontent' style='text-align:left'>";
				if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
				if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
				$f_return .= "</p>\n";
			}

$f_return .= ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->formGet ($direct_cachedata['output_formelements']))."
<p style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"{$direct_cachedata['output_formbutton']}\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
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
			$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/swgi_datalinker_iview.php");
			if (isset ($direct_cachedata['output_formiview_title'])) { $f_return .= "\n<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_formiview_title']}</h1>"; }
			$f_return .= "\n".(direct_datalinker_oset_iview_url ($direct_cachedata['output_formiview_url'],$direct_cachedata['output_formiview_id'],true));
		}

		return $f_return;
	}
}

/**
* direct_output_oset_default_embedded_redirect ()
*
* @return string Valid XHTML code
* @since  v0.1.10
*/
function direct_output_oset_default_embedded_redirect ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_redirect ()- (#echo(__LINE__)#)"); }

return ("<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>".(direct_local_get ("core_redirect"))."</h1>
<p><strong>".(direct_local_get ("core_redirect_url")).":</strong> <a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>{$direct_cachedata['output_redirect']}</a></p>
<p id='swgjsjump_point' style='text-align:center'><strong><span style='font-size:10px'>".(direct_local_get ("core_automated_redirection_unsupported"))."</span><br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p><script type='text/javascript'><![CDATA[
jQuery (function ()
{
djs_DOM_replace ({ data:\"<p style='font-size:10px;text-align:center'>(".(direct_local_get ("core_automated_redirection","text")).")<br />\\n\" +
\"<a href=\\\"{$direct_cachedata['output_pagetarget']}\\\" target='_self'>".(direct_local_get ("core_continue","text"))."</a></p>\",id:'swgjsjump_point' });
});
self.setTimeout (\"self.location.replace ('{$direct_cachedata['output_pagetarget']}')\",2000);
]]></script>");
}

/**
* direct_output_oset_default_embedded_selection_list ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_embedded_selection_list ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_embedded_selection_list ()- (#echo(__LINE__)#)"); }

	$f_return = (((isset ($direct_cachedata['output_selection_title_hidden']))&&($direct_cachedata['output_selection_title_hidden'])) ? "" : "<h1 class='pagecontenttitle{$direct_settings['theme_css_corners']}'>{$direct_cachedata['output_selection_title']}</h1>\n");
	$f_return .= "<p>";

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

$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>