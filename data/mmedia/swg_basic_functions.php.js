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
$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : "");
if ($g_block == "djs_dialog") {
?>
djs_var['core_dialog_ready'] = false;

function djs_dialog (f_id,f_params)
{
	if (!djs_var['core_dialog_ready'])
	{
		djs_load_functions ({ file:'ext_jquery/jquery.ui.core.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.widget.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.mouse.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.position.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.draggable.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.resizable.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.dialog.min.js' });
		djs_var['core_dialog_ready'] = true;
	}

	if (f_id != null)
	{
		if (f_params == null) { f_params = { width:($(self).width () / 2) }; }
		else if (typeof (f_params['width']) == 'undefined') { f_params['width'] = ($(self).width () / 2); }

		$("#" + f_id).dialog (f_params);
	}
}
<?php } ?>

<?php if ($g_block == "") { ?>
function djs_load_functions (f_params)
{
	if (typeof (f_params['block']) == 'undefined') { djs_swgAJAX ({ async:false,cache:true,dataType:'script',url0:"<?php echo "s=cache&dsd=dfile+$direct_settings[path_mmedia]/[file]++dbid+".$direct_settings['product_buildid']; ?>".replace (/\[file\]/g,f_params.file) }); }
	else { djs_swgAJAX ({ async:false,cache:true,dataType:'script',url0:"<?php echo "s=cache&dsd=dfile+$direct_settings[path_mmedia]/[file]++dblock+[block]++dbid+".$direct_settings['product_buildid']; ?>".replace(/\[file\]/g,f_params.file).replace (/\[block\]/g,f_params.block) }); }
}

djs_var['core_run_onload'] = [ ];

function djs_run (f_params)
{
	if ((typeof (f_params['func']) != 'undefined')&&(typeof (f_params['params']) != 'undefined')&&(typeof (self[f_params.func]) != 'undefined'))
	{
		try { self[f_params.func] (f_params.params); }
		catch (f_unhandled_exception) { }
	}
}

function djs_run_onload ()
{
	if (typeof (djs_var['core_run_onload'][0]) != 'undefined')
	{
		for (var f_i = 0;f_i < djs_var['core_run_onload'].length;f_i++) { djs_run (djs_var['core_run_onload'][f_i]); }
	}
}
<?php } ?>

//j// EOF