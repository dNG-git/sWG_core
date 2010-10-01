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
if (typeof (djs_var['core_dialog_width']) == 'undefined') { djs_var['core_dialog_width'] = 0.75; }

function djs_dialog (f_id,f_params)
{
	if (!djs_var.core_dialog_ready)
	{
		djs_load_functions ({ file:'ext_jquery/jquery.ui.core.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.widget.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.mouse.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.position.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.draggable.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.resizable.min.js' });
		djs_load_functions ({ file:'ext_jquery/jquery.ui.dialog.min.js' });
		djs_load_functions ({ file:'swg_DOM.php.js',block:'djs_swgAJAX_replace' });
		djs_var['core_dialog_ready'] = true;
	}

	if ((f_id == null)&&(typeof (f_params['id']) != 'undefined'))
	{
		f_id = f_params.id + 'd';
		$("#" + f_params.id).append ("<div id='" + f_id + "' style='display:none'></div>");
	}

	if (f_id != null)
	{
		if (typeof (f_params['url']) != 'undefined')
		{
			f_self = $(self);

			if (typeof (f_params['title']) == 'undefined') { djs_swgDOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='ui-widget ui-state-highlight' style='width:100%;height:100%'></iframe>",id:f_id,onInserted:{ func:'djs_dialog_view',params:{ draggable:false,id:f_id,height:(f_self.height () * 0.95),modal:true,resizable:false,title:"<?php echo direct_local_get ("core_detailed_information","text"); ?>",width:(f_self.width () * 0.95) } } }); }
			else { djs_swgDOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='ui-widget ui-state-highlight' style='width:100%;height:100%'></iframe>",id:f_id,onInserted:{ func:'djs_dialog_view',params:{ draggable:false,id:f_id,height:(f_self.height () * 0.95),modal:true,resizable:false,title:f_params.title,width:(f_self.width () * 0.95) } } }); }
		}
		else
		{
			if (f_params == null) { f_params = { width:($(self).width () * djs_var['core_dialog_width']) }; }
			else if (typeof (f_params['width']) == 'undefined') { f_params['width'] = ($(self).width () * djs_var['core_dialog_width']); }

			f_params['id'] = f_id;
			djs_dialog_view (f_params);
		}
	}
}

function djs_dialog_init (f_params)
{
	if (typeof (f_params['id']) != 'undefined') { djs_dialog (f_params.id,f_params); }
}

function djs_dialog_view (f_params)
{
	if (typeof (f_params['id']) != 'undefined') { $("#" + f_params.id).dialog(f_params).bind ("dialogclose",function () { $("#" + f_params.id).remove (); }); }
}
<?php } ?>

<?php if ($g_block == "") { ?>
function djs_load_functions (f_params)
{
	if (typeof (f_params['block']) == 'undefined') { djs_swgAJAX ({ async:false,cache:true,dataType:'script',url0:"<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dbid+".$direct_settings['product_buildid']; ?>".replace (/\[file\]/g,f_params.file) }); }
	else { djs_swgAJAX ({ async:false,cache:true,dataType:'script',url0:"<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dblock+[block]++dbid+".$direct_settings['product_buildid']; ?>".replace(/\[file\]/g,f_params.file).replace (/\[block\]/g,f_params.block) }); }
}

djs_var['core_run_onload'] = [ ];

function djs_run (f_params,f_perm_params,f_is_perm_params)
{
	if ((typeof (f_params['func']) != 'undefined')&&(typeof (f_params['params']) != 'undefined')&&(typeof (self[f_params.func]) != 'undefined'))
	{
		if (f_perm_params != null)
		{
			if (!f_is_perm_params)
			{
				if (typeof (f_perm_params['perm_params']) == 'undefined') { f_perm_params = [ ]; }
				else { f_perm_params = f_perm_params.perm_params; }
			}

			for (var f_param in f_perm_params)
			{
				if (typeof (f_params.params[f_param]) == 'undefined') { f_params.params[f_param] = f_perm_params[f_param]; }
			}
		}

		try { self[f_params.func] (f_params.params); }
		catch (f_unhandled_exception) { }
	}
}

function djs_run_onload ()
{
	if (typeof (djs_var.core_run_onload[0]) != 'undefined')
	{
		for (var f_i = 0;f_i < djs_var.core_run_onload.length;f_i++) { djs_run (djs_var.core_run_onload[f_i]); }
	}
}
<?php } ?>

//j// EOF