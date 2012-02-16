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
* osets/default/swgi_default.php
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
* @since      v0.1.07
* @license    http://www.direct-netware.de/redirect.php?licenses;w3c
*             W3C (R) Software License
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Functions and classes

/**
* direct_datacenter_oset_object_parse ()
*
* @param  array $f_object DataCenter object
* @uses   direct_debug()
* @uses   direct_local_get()
* @uses   USE_debug_reporting
* @return string Valid XHTML code
* @since  v0.1.07
*/
function direct_default_oset_done_job_entries_parse ($f_job_entries)
{
	global $direct_settings;
	if (USE_debug_reporting) { direct_debug (5,"sWG/#echo(__FILEPATH__)# -direct_default_oset_done_job_entries_parse (+f_job_entries)- (#echo(__LINE__)#)"); }

	$f_job_title = "";
	$f_return = "";

	if (!empty ($f_job_entries))
	{
		foreach ($f_job_entries as $f_jobs_array)
		{
			if (isset ($f_jobs_array['name']))
			{
				if ($f_jobs_array['name'] != $f_job_title)
				{
					$f_job_title = $f_jobs_array['name'];
					$f_return .= "<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent'><strong>$f_job_title</strong>";
				}

				$f_entries = "";
				if (!isset ($f_jobs_array['entries'])) { $f_jobs_array['entries'] = array ($f_jobs_array); }

				foreach ($f_jobs_array['entries'] as $f_entry_array)
				{
					if (isset ($f_entry_array['status']))
					{
						if ($f_entries) { $f_entries .= "<br />\n"; }
						$f_entries .= "<strong><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/status_icon_{$f_entry_array['status']}.png",true,false))."' alt='".(direct_local_get ("core_done_status_".$f_entry_array['status']))."' title='".(direct_local_get ("core_done_status_".$f_entry_array['status']))."' style='vertical-align:middle' /> ".(direct_local_get ("core_done_status_".$f_entry_array['status']));
						$f_entries .= (isset ($f_entry_array['identifier']) ? ":</strong> {$f_entry_array['identifier']}" : "</strong>");
						if (isset ($f_entry_array['details'])) { $f_entries .= " <span style='font-size:10px'>({$f_entry_array['details']})</span>"; }
					}
				}

				if ($f_entries) { $f_return .= "<br /><br />\n".$f_entries; }
				$f_return .= "</p>";
			}
			else
			{
				if (!isset ($f_jobs_array['entries'])) { $f_jobs_array['entries'] = array ($f_jobs_array); }

				foreach ($f_jobs_array['entries'] as $f_entry_array)
				{
					if (isset ($f_entry_array['status']))
					{
						$f_return .= "<p class='pageborder2{$direct_settings['theme_css_corners']} pageextracontent'><strong><img src='".(direct_linker_dynamic ("url0","s=cache;dsd=dfile+$direct_settings[path_themes]/$direct_settings[theme]/status_icon_{$f_entry_array['status']}.png",true,false))."' alt='".(direct_local_get ("core_done_status_".$f_entry_array['status']))."' title='".(direct_local_get ("core_done_status_".$f_entry_array['status']))."' style='vertical-align:middle' /> ".(direct_local_get ("core_done_status_".$f_entry_array['status']));
						$f_return .= (isset ($f_entry_array['identifier']) ? ":</strong> {$f_entry_array['identifier']}" : "</strong>");
						if (isset ($f_entry_array['name'])) { $f_return .= " <strong>({$f_entry_array['name']})</strong>"; }
						if (isset ($f_entry_array['details'])) { $f_return .= " <span style='font-size:10px'>({$f_entry_array['details']})</span>"; }
						$f_return .= "</p>";
					}
				}
			}
		}
	}

	return $f_return;
}

//j// Script specific commands

$direct_settings['theme_css_corners'] = ((isset ($direct_settings['theme_css_corners_class'])) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");

//j// EOF
?>