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
* osets/ajax_dialog/swg_default.php
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
* @subpackage osets_ajax_dialog
* @since      v0.1.09
* @license    http://www.direct-netware.de/redirect.php?licenses;mpl2
*             Mozilla Public License, v. 2.0
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/**
* direct_output_oset_default_done ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_done ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done ()- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "s"; }
	$f_return = "<p>{$direct_cachedata['output_job_desc']}</p>";

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if (!isset ($direct_cachedata['output_ajax_window_closeable'])) { $direct_cachedata['output_ajax_window_closeable'] = false; }

		if ($direct_cachedata['output_jsjump'] > 0)
		{
			if (!isset ($direct_cachedata['output_ajax_window_modal'])) { $direct_cachedata['output_ajax_window_modal'] = false; }

$f_return = ("<div>$f_return\n<p style='font-size:10px;text-align:center'>".(direct_local_get ("core_automated_redirection"))."<br />
<a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></p><script type='text/javascript'><![CDATA[
self.setTimeout (\"self.location.href = \\\"{$direct_cachedata['output_pagetarget']}\\\"\",{$direct_cachedata['output_jsjump']});
]]></script></div>");
		}
		else { $f_return = "<div>$f_return\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p></div>"; }
	}

	return $f_return;
}

/**
* direct_output_oset_default_done_extended ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_done_extended ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_done_extended ()- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "m"; }

	$f_return = "<div><p>{$direct_cachedata['output_job_desc']}</p>";
	if (isset ($direct_cachedata['output_job_entries'])) { $f_return .= direct_default_oset_done_job_entries_parse ($direct_cachedata['output_job_entries']); }

	if (isset ($direct_cachedata['output_pagetarget']))
	{
		if (!isset ($direct_cachedata['output_ajax_window_closeable'])) { $direct_cachedata['output_ajax_window_closeable'] = false; }
		$f_return .= "\n<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_pagetarget']}\" target='_self'>".(direct_local_get ("core_continue"))."</a></strong></p>";
	}

	$f_return .= "</div>";
	return $f_return;
}

/**
* direct_output_oset_default_error_login ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_error_login ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_login ()- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['output_ajax_window_closeable'])) { $direct_cachedata['output_ajax_window_closeable'] = false; }

$f_return = ("<div><p>{$direct_cachedata['output_error']}</p>
<p class='ui-state-error{$direct_settings['theme_css_corners']}' style='padding:$direct_settings[theme_td_padding];font-size:11px'><strong>".(direct_local_get ("core_user_current")).":</strong> {$direct_cachedata['output_current_user']}</p>
<p>".(direct_local_get ("core_access_rights_insufficient"))."</p>
<p style='text-align:center'><strong><a href=\"{$direct_cachedata['output_link_login']}\" target='_self'>".(direct_local_get ("core_login_with_authorized_account"))."</a></strong></p>");

	if ($direct_cachedata['output_error_extradata']) { $f_return .= "\n<p style='font-size:11px'>{$direct_cachedata['output_error_extradata']}</p>"; }

	if (!empty ($direct_cachedata['core_debug_backtrace']))
	{
		if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "l"; }

		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<p class='ui-state-highlight{$direct_settings['theme_css_corners']}' style='padding:$direct_settings[theme_td_padding]'>Backtrace</p><ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}
	elseif (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "m"; }

	$f_return .= "</div>";
	return $f_return;
}

/**
* direct_output_oset_default_error_standard ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_error_standard ()
{
	global $direct_cachedata,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_error_standard ()- (#echo(__LINE__)#)"); }

	if ((!isset ($direct_cachedata['output_ajax_window_closeable']))&&(($direct_cachedata['output_link_back'])||($direct_cachedata['output_link_retry']))) { $direct_cachedata['output_ajax_window_closeable'] = false; }

	$f_return = "<div><p>{$direct_cachedata['output_error']}</p>";
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
		if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "l"; }

		$f_backtrace_array = array_map ("direct_html_encode_special",$direct_cachedata['core_debug_backtrace']);
		$f_return .= ("\n<p class='ui-state-highlight{$direct_settings['theme_css_corners']}' style='padding:$direct_settings[theme_td_padding]'>Backtrace</p><ul style='text-align:left;font-size:10px'>\n<li>".(implode ("</li>\n<li>",$f_backtrace_array))."</li></ul>");
	}
	elseif (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "m"; }

	$f_return .= "</div>";
	return $f_return;
}

if (isset ($direct_globals['@names']['output_formbuilder']))
{
/**
	* direct_output_oset_default_form_preview ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.09
*/
	function direct_output_oset_default_form_preview ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form_preview ()- (#echo(__LINE__)#)"); }

		$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/osets/$direct_settings[theme_oset]/$direct_cachedata[output_preview_function_file].php");

		$f_oset = "direct_".$direct_cachedata['output_preview_function'];
		$f_return = ((function_exists ($f_oset)) ? "<div>".($f_oset ())."</div>" : "");

		return $f_return;
	}

/**
	* direct_output_oset_default_form_results ()
	*
	* @return string Valid XHTML code
	* @since  v0.1.09
*/
	function direct_output_oset_default_form_results ()
	{
		global $direct_cachedata,$direct_globals,$direct_settings;
		if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_form_results ()- (#echo(__LINE__)#)"); }

		if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = "m"; }
		if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

		$f_return = "<div>";

		if (($direct_cachedata['output_credits_information'])||($direct_cachedata['output_credits_payment_data']))
		{
			$f_return .= "<p class='pagehighlightborder{$direct_settings['theme_css_corners']} pagebg pagecontent' style='text-align:left'>";
			if ($direct_cachedata['output_credits_information']) { $f_return .= $direct_cachedata['output_credits_information']; }
			if ($direct_cachedata['output_credits_payment_data']) { $f_return .= ($direct_cachedata['output_credits_information'] ? "<br />\n<span style='font-size:10px'>{$direct_cachedata['output_credits_payment_data']}</span>" : $direct_cachedata['output_credits_payment_data']); }
			$f_return .= "</p>";
		}

		$f_return .= ($direct_globals['output_formbuilder']->formGetResults ($direct_cachedata['output_formelements']))."</div>";
		return $f_return;
	}
}

/**
* direct_output_oset_default_options ()
*
* @return string Valid XHTML code
* @since  v0.1.09
*/
function direct_output_oset_default_options ()
{
	global $direct_cachedata,$direct_globals,$direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_output_oset_default_options ()- (#echo(__LINE__)#)"); }

	if (!isset ($direct_cachedata['output_ajax_width'])) { $direct_cachedata['output_ajax_width'] = (isset ($direct_cachedata['output_formelements']) ? "l" : "s"); }
	if (!isset ($direct_globals['output_formbuilder'])) { direct_class_init ("output_formbuilder"); }

	$f_return = "<div>";
	if ($direct_globals['output']->optionsCheck ("optionsmenu")) { $f_return .= "<ul class='pageborder{$direct_settings['theme_css_corners']} pageextrabg pageextracontent' style='text-align:center;list-style-type:none'>".($direct_globals['output']->optionsGenerator ("v","optionsmenu"))."</ul>"; }

	if (isset ($direct_cachedata['output_formelements']))
	{
		$f_form_id = uniqid ("swg");
	
$f_return .= ($direct_settings['iscript_form']." name='$f_form_id' id='$f_form_id'>".(direct_linker ("form",$direct_cachedata['output_formtarget'])).($direct_globals['output_formbuilder']->formGet ($direct_cachedata['output_formelements']))."
<p style='text-align:center'><input type='submit' id='{$f_form_id}b' value=\"".(direct_local_get ("core_continue","text"))."\" class='pagecontentinputbutton' /><script type='text/javascript'><![CDATA[
jQuery (function ()
{
	djs_load_functions({ file:'swg_formbuilder.php.js' }).done (function ()
	{
		djs_formbuilder_init ({ id:'{$f_form_id}b',type:'button' });
		djs_formbuilder_init ({ id:'$f_form_id',id_button:'{$f_form_id}b',type:'form' });
	});
});
]]></script></p></form>");
	}

	$f_return .= "</div>";
	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
if (!isset ($direct_settings['theme_td_padding'])) { $direct_settings['theme_td_padding'] = "5px"; }

//j// EOF
?>