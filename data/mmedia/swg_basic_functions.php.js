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

<?php
$g_function = (isset ($direct_settings['dsd']['dfunction']) ? $direct_settings['dsd']['dfunction'] : "");
if ($g_function == "") {
?>
function djs_load_functions (f_module,f_function) { return djs_swgDOM_js_insert_url ("<?php echo direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/[module]++dfunction+[function]++dbid+".$direct_settings['product_buildid'],false,false); ?>".replace(/\[module\]/g,f_module).replace (/\[function\]/g,f_function)); }

djs_var['core_run_onload'] = new Array ();

function djs_run_onload ()
{
	if (djs_var['core_run_onload'][0])
	{
		for (var f_i = 0;f_i < djs_var['core_run_onload'].length;f_i++) { eval (djs_var['core_run_onload'][f_i] + ';'); }
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
<?php } ?>

<?php if ($g_function == "djs_iblock_switch_hide") { ?>
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
<?php } ?>

<?php if ($g_function == "djs_iblock_switch_show") { ?>
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
<?php } ?>

<?php if ($g_function == "djs_iblock_switch") { ?>
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

djs_load_functions ('swg_basic_functions.php.js','djs_iblock_switch_hide');
djs_load_functions ('swg_basic_functions.php.js','djs_iblock_switch_show');
<?php } ?>

<?php if ($g_function == "djs_diblock_switch") { ?>
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

djs_load_functions ('swg_basic_functions.php.js','djs_iblock_switch_hide');
djs_load_functions ('swg_basic_functions.php.js','djs_iblock_switch_show');
<?php } ?>

//j// EOF