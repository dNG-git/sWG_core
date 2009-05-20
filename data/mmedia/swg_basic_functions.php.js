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
$Id: swg_basic_functions.php.js,v 1.11 2008/12/15 18:17:13 s4u Exp $
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/

djs_var['core_run_onload'] = new Array ();

function djs_run_onload ()
{
	if (djs_var['core_run_onload'][0])
	{
		for (var f_i = 0;f_i < djs_var['core_run_onload'].length;f_i++) { eval (djs_var['core_run_onload'][f_i] + ';'); }
	}
}

djs_var['core_swgAJAX_loading_position'] = '';

function djs_swgAJAX_loading_writeln (f_position)
{
	if (djs_swgAJAX)
	{
	// Only continue if the basic test had been completed successfully
	djs_var['core_swgAJAX_loading_position'] = f_position;

djs_swgDOM_replace ("<div id='swgAJAX_loading' onclick='javascript:djs_swgAJAX_loading_hide();' style='position:absolute;display:none;width:250px;height:125px;top:0px;left:0px;z-index:256'><div style='position:fixed;cursor:wait'><table cellspacing='0' summary='' style='width:250px;height:125px;table-layout:fixed'>\n" +
"<tbody>\n" +
"<tr style='height:110px'>\n" +
"<td style='width:15px;line-height:0px'><img src='<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_01.png",true,false); ?>' width='15' height='110' alt='' title='' /></td>\n" +
"<td valign='middle' align='center' style='width:220px;background-image:url(<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_02.png",true,false); ?>);background-color:#E0E0E0'><p class='pageajaxloadingcontent' style='font-weight:bold'><?php echo direct_local_get ("core_loading","text"); ?></p>\n" +
"<p class='pageajaxloadingcontent'><?php echo direct_local_get ("core_loading_ajax","text"); ?></p></td>\n" +
"<td style='width:15px;line-height:0px'><img src='<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_03.png",true,false); ?>' width='15' height='110' alt='' title='' /></td>\n" +
"</tr>\n" +
"<tr style='height:15px'>\n" +
"<td style='width:15px;line-height:0px'><img src='<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_04.png",true,false); ?>' width='15' height='15' alt='' title='' /></td>\n" +
"<td style='width:220px;line-height:0px'><img src='<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_05.png",true,false); ?>' width='220' height='15' alt='' title='' /></td>\n" +
"<td style='width:15px;line-height:0px'><img src='<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_output_ajaxloading_06.png",true,false); ?>' width='15' height='15' alt='' title='' /></td>\n" +
"</tr>\n" +
"</tbody>\n" +
"</table></div></div>",'swgAJAX_loading_point');
	}
}

function djs_iblock_init (f_iblock_id,f_mode)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if ((typeof (self.document.getElementById(f_iblock_id).style.display) != 'undefined')&&(self.document.getElementById(f_iblock_id).style.display != 'none')) { djs_var[f_iblock_id + '_style_display'] = self.document.getElementById(f_iblock_id).style.display; }
		else if (typeof (djs_var[f_iblock_id + '_style_display']) == 'undefined') { djs_var[f_iblock_id + '_style_display'] = 'block'; }

		if (f_mode) { self.document.getElementById(f_iblock_id).style.display = djs_var[f_iblock_id + '_style_display']; }
		else { self.document.getElementById(f_iblock_id).style.display = 'none'; }
	}
	}
}

function djs_diblock_init (f_diblock_id,f_mode)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_content_editable)
	{
		if (f_mode)
		{
			self.document.getElementById(f_diblock_id + '_title').firstChild.nodeValue = "<?php echo direct_local_get ("core_detailed_information_hide","text"); ?>";
			djs_iblock_init (f_diblock_id,f_mode);
		}
		else
		{
			self.document.getElementById(f_diblock_id + '_title').firstChild.nodeValue = "<?php echo direct_local_get ("core_detailed_information_show","text"); ?>";
			djs_iblock_init (f_diblock_id,f_mode);
		}
	}
	}
}

function djs_iblock_fade_in (f_iblock_id,f_percentage)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if ((self.document.getElementById(f_iblock_id).style.display != 'none')&&(self.document.getElementById(f_iblock_id).firstChild.style.opacity >= (f_percentage / 100)))
		{
			if ((self.document.getElementById(f_iblock_id).firstChild.style.opacity < 0.8)&&(f_percentage < 80))
			{
				f_percentage += 20;
				self.document.getElementById(f_iblock_id).firstChild.style.opacity = (f_percentage / 100);
				self.setTimeout ('djs_iblock_fade_in (\'' + f_iblock_id + '\',' + f_percentage + ')',60);
			}
			else { self.document.getElementById(f_iblock_id).firstChild.style.opacity = 1; }
		}
	}
	}
}

function djs_iblock_fade_out (f_iblock_id,f_percentage)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if ((self.document.getElementById(f_iblock_id).style.display != 'none')&&(self.document.getElementById(f_iblock_id).firstChild.style.opacity <= (f_percentage / 100)))
		{
			if ((self.document.getElementById(f_iblock_id).firstChild.style.opacity > 0.2)&&(f_percentage > 20))
			{
				f_percentage -= 20;
				self.document.getElementById(f_iblock_id).firstChild.style.opacity = (f_percentage / 100);
				self.setTimeout ('djs_iblock_fade_out (\'' + f_iblock_id + '\',' + f_percentage + ')',60);
			}
			else
			{
				if (typeof (djs_var[f_iblock_id + '_style_display']) == 'undefined') { djs_var[f_iblock_id + '_style_display'] = self.document.getElementById(f_iblock_id).style.display; }
				self.document.getElementById(f_iblock_id).style.display = 'none';
			}
		}
	}
	}
}

function djs_iblock_switch_hide (f_iblock_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if (self.document.getElementById(f_iblock_id).style.display != 'none')
		{
			if (typeof (self.document.getElementById(f_iblock_id).firstChild.style.opacity) != 'undefined') { djs_iblock_fade_out (f_iblock_id,(self.document.getElementById(f_iblock_id).firstChild.style.opacity * 100)); }
			else
			{
				if (typeof (djs_var[f_iblock_id + '_style_display']) == 'undefined') { djs_var[f_iblock_id + '_style_display'] = self.document.getElementById(f_iblock_id).style.display; }
				self.document.getElementById(f_iblock_id).style.display = 'none';
			}
		}
	}
	}
}

function djs_iblock_switch_show (f_iblock_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		if (self.document.getElementById(f_iblock_id).style.display == 'none')
		{
			if (typeof (self.document.getElementById(f_iblock_id).firstChild.style.opacity) != 'undefined')
			{
				self.document.getElementById(f_iblock_id).firstChild.style.opacity = 0;
				self.setTimeout ('djs_iblock_fade_in (\'' + f_iblock_id + '\',0)',30);
			}

			if (typeof (djs_var[f_iblock_id + '_style_display']) == 'undefined') { djs_var[f_iblock_id + '_style_display'] = 'block'; }
			self.document.getElementById(f_iblock_id).style.display = djs_var[f_iblock_id + '_style_display'];
		}
	}
	}
}

function djs_iblock_switch (f_iblock_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		if (self.document.getElementById(f_iblock_id).style.display == 'none') { djs_iblock_switch_show (f_iblock_id); }
		else { djs_iblock_switch_hide (f_iblock_id); }
	}
	}
}

function djs_diblock_switch (f_diblock_id)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		if (self.document.getElementById(f_diblock_id).style.display == 'none')
		{
			self.document.getElementById(f_diblock_id + '_title').firstChild.nodeValue = "<?php echo direct_local_get ("core_detailed_information_hide","text"); ?>";
			djs_iblock_switch_show (f_diblock_id);
		}
		else
		{
			self.document.getElementById(f_diblock_id + '_title').firstChild.nodeValue = "<?php echo direct_local_get ("core_detailed_information_show","text"); ?>";
			djs_iblock_switch_hide (f_diblock_id);
		}
	}
	}
}

//j// EOF