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

<?php
$direct_settings['theme_css_corners'] = (isset ($direct_settings['theme_css_corners_class']) ? " ".$direct_settings['theme_css_corners_class'] : " ui-corner-all");
$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : "");

if ($g_block == "") {
?>
function djs_browsersupport_set (f_params)
{
	if (f_params === null) { f_params = { 'name': 'BrowserSupport','key': 'JS' }; }
	else if (!('name' in f_params)) { f_params['name'] = 'BrowserSupport'; }

	var f_cookie_value = djs_cookie_get (f_params.name);

	if (f_cookie_value === null) { djs_cookie_set (f_params.name,f_params.key,f_params); }
	else
	{
		f_cookie_value = ' ' + f_cookie_value + ' ';
		if (f_cookie_value.indexOf (' ' + f_params.key + ' ') < 0) { djs_cookie_set (f_params.name,(f_cookie_value.substr (1) + f_params.key),f_params); }
	}
}

djs_var['core_cookies'] = null;

function djs_cookie_get (f_name)
{
	if ((typeof (f_name) == 'object')&&('name' in f_name)) { f_name = f_name['name']; }
	var f_return = null;

	if ((djs_var.core_cookies === null)&&('cookie' in self.document))
	{
		djs_var.core_cookies = { };

		if (self.document.cookie.length)
		{
			var f_cookie = null;
			var f_cookies = self.document.cookie.split (';');

			for (f_i = 0; f_i < f_cookies.length; f_i++)
			{
				f_cookie = f_cookies[f_i].split ('=');
				if (f_cookie[1].length < 1) { f_cookie[1] = ''; }
				djs_var.core_cookies[f_cookie[0].replace(/^\s+|\s+$/g,'')] = decodeURIComponent (f_cookie[1].replace (/^\s+|\s+$/g,''));
			}
		}
	}

	if ((djs_var.core_cookies !== null)&&(f_name in djs_var.core_cookies)) { f_return = djs_var.core_cookies[f_name]; }
	return f_return
}

function djs_cookie_set (f_name,f_value,f_params)
{
	if (djs_var.core_cookies === null) { djs_cookie_get (f_name); }

	if (djs_var.core_cookies !== null)
	{
		if (f_params === null) { f_params = { }; }
		if (!('expires' in f_params)) { f_params['expires'] = 604800000; }

		if (f_params.expires === null) { f_params.expires = null; }
		else if (f_params.expires == -1) { f_params.expires = 'Sat, 01-Jan-00 01:00:00 GMT'; }
		else if (typeof (f_params.expires) != 'string') { f_params.expires = new Date (f_params.expires + <?php echo $direct_cachedata['core_time']; ?>000).toGMTString (); }

		if (!('domain' in f_params)) { f_params['domain'] = "<?php echo $direct_settings['swg_cookie_server']; ?>"; }
		if (!('path' in f_params)) { f_params['path'] = "<?php echo $direct_settings['swg_cookie_path']; ?>"; }

		var f_cookie_options = '';
		if (f_params.path.length) { f_cookie_options += "; PATH=" + f_params.path; }
		if (f_params.domain.length) { f_cookie_options += "; DOMAIN=" + f_params.domain; }
		if (f_params.expires !== null) { f_cookie_options += "; EXPIRES=" + f_params.expires; }

		djs_var.core_cookies[f_name] = f_value;
		self.document.cookie = f_name + "=" + (encodeURIComponent (f_value)) + f_cookie_options;
	}
}

djs_var['core_dialog_ready'] = false;
if (!('core_dialog_width' in djs_var)) { djs_var['core_dialog_width'] = 0.75; }

function djs_dialog (f_id,f_params)
{
	if (djs_var.core_dialog_ready)
	{
		if (f_id === null)
		{
			if (!('id' in f_params))
			{
				f_id = "swg" + (Math.random().toString().replace (/\./g,"_")) + "d";
				jQuery('body').append ("<div id='" + f_id + "' style='display:none'></div>");
			}
			else
			{
				f_id = f_params.id + "d";
				jQuery("#" + f_params.id).append ("<div id='" + f_id + "' style='display:none'></div>");
			}
		}

		if (f_id !== null)
		{
			if ('ajax_url' in f_params)
			{
				if ('id' in f_params) { djs_swgAJAX_replace ({ id:f_id,id_transfer_source:f_params.id,onReplace:{ func:'djs_dialog_init',params:{ id:f_id } },url:f_params.ajax_url }); }
				else { djs_swgAJAX_replace ({ id:f_id,onReplace:{ func:'djs_dialog_init',params:{ id:f_id } },url:f_params.ajax_url }); }
			}
			else if ('url' in f_params)
			{
				f_self = jQuery(self);

				if ('width' in f_params) { f_params.width = Math.floor (f_self.width () * f_params.width); }
				else { f_params['width'] = Math.floor (f_self.width () * 0.95); }

				if ('height' in f_params) { f_params.height = Math.floor (f_self.height () * f_params.height); }
				else { f_params['height'] = Math.floor (f_self.height () * 0.95); }

				if ('title' in f_params) { djs_DOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='pageembeddedborder<?php echo $direct_settings['theme_css_corners']; ?> pageembeddedbg pageextracontent' style='width:100%;height:100%'></iframe>",id:f_id,onInsert:{ func:'djs_dialog_view',params:{ draggable:false,id:f_id,height:f_params.height,modal:true,resizable:false,title:f_params.title,width:f_params.width } } }); }
				else { djs_DOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='pageembeddedborder<?php echo $direct_settings['theme_css_corners']; ?> pageembeddedbg pageextracontent' style='width:100%;height:100%'></iframe>",id:f_id,onInsert:{ func:'djs_dialog_view',params:{ draggable:false,id:f_id,height:f_params.height,modal:true,resizable:false,title:"<?php echo direct_local_get ("core_detailed_information","text"); ?>",width:f_params.width } } }); }
			}
			else
			{
				if (f_params === null) { f_params = { width:Math.floor (jQuery(self).width () * djs_var.core_dialog_width) }; }
				else if (!('width' in f_params)) { f_params['width'] = Math.floor (jQuery(self).width () * djs_var.core_dialog_width); }

				f_params.id = f_id;
				djs_dialog_view (f_params);
			}
		}
	}
	else
	{
djs_load_functions ([
 { file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' },
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.widget.min.js' },
 { file:'ext_jquery/jquery.ui.button.min.js' },
 { file:'ext_jquery/jquery.ui.mouse.min.js' },
 { file:'ext_jquery/jquery.ui.position.min.js' },
 { file:'ext_jquery/jquery.ui.draggable.min.js' },
 { file:'ext_jquery/jquery.ui.resizable.min.js' },
 { file:'ext_jquery/jquery.ui.dialog.min.js' }
]).done (function ()
{
	djs_var['basic_formbuilder_button_ready'] = true;
	djs_var['basic_formbuilder_resizeable_ready'] = true;
	djs_var.core_dialog_ready = true;

	djs_dialog (f_id,f_params);
});
	}
}

function djs_dialog_init (f_params)
{
	if ('id' in f_params) { djs_dialog (f_params.id,f_params); }
}

function djs_dialog_view (f_params)
{
	if ('id' in f_params)
	{
		if ((!('buttons' in f_params))&&((!('window_closeable' in f_params))||(f_params.window_closeable))) { f_params['buttons'] = { "<?php echo direct_local_get ("core_close","text"); ?>": function () { jQuery(this).dialog ('close'); } }; }
		jQuery("#" + f_params.id).dialog(f_params).on ('dialogclose',function () { jQuery("#" + f_params.id).remove (); });
	}
}

djs_var['core_functions_ready'] = { };

function djs_load_functions (f_params)
{
	var f_return = null;

	if (jQuery.isArray (f_params)) { jQuery.each (f_params,(function () { f_return = djs_load_functions_file (this,f_return); })); }
	else { f_return = djs_load_functions_file (f_params,f_return); }

	return f_return;
}

function djs_load_functions_file (f_params,f_deferred)
{
	var f_continue_check = true,f_return = null;

	if ((!('cache' in f_params))||(f_params.cache))
	{
		if ('block' in f_params) { var f_cache_id = f_params.file + ":" + f_params.block; }
		else { var f_cache_id = f_params.file; }

		if (f_cache_id in djs_var.core_functions_ready)
		{
			f_continue_check = false;

			if (f_deferred === null) { f_return = djs_var.core_functions_ready[f_cache_id]; }
			else
			{
				f_return = jQuery.Deferred ();
				f_deferred.done (function () { djs_var.core_functions_ready[f_cache_id].done (function () { f_return.resolve (); }); });
			}
		}
	}

	if (f_continue_check)
	{
		var f_params_ajax = { cache:true,dataType:'script' };

		if ('block' in f_params) { f_params_ajax['url0'] = "<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dblock+[block]++dbid+".$direct_settings['product_buildid']; ?>".replace(/\[file\]/g,f_params.file).replace (/\[block\]/g,f_params.block); }
		else { f_params_ajax['url0'] = "<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dbid+".$direct_settings['product_buildid']; ?>".replace (/\[file\]/g,f_params.file); }

		if (f_deferred === null)
		{
			djs_var.core_functions_ready[f_cache_id] = djs_swgAJAX (f_params_ajax);
			f_return = djs_var.core_functions_ready[f_cache_id];
		}
		else
		{
			f_return = jQuery.Deferred ();
			f_deferred.done (function () { djs_var.core_functions_ready[f_cache_id] = djs_swgAJAX(f_params_ajax).done (function () { f_return.resolve (); }); });
		}
	}

	return f_return;
}
<?php
	$direct_globals['basic_functions']->includeFile ($direct_settings['path_mmedia']."/ext_djs/djs_runner.min.js");
}

if ($g_block == "djs_tid_keepalive") {
?>
djs_var['core_tid_keepalives'] = { };

function djs_tid_keepalive (f_tid,f_recall)
{
	if (f_recall === undefined) { f_recall = false; }

	if (f_recall) { djs_swgAJAX ({ cache:true,url0:'s=task;a=keepalive;dsd=tid+' + f_tid }).done (function () { self.setTimeout ("djs_tid_keepalive ('" + f_tid + "',true)",300000); }); }
	else if (!(f_tid in djs_var.core_tid_keepalives))
	{
		djs_var.core_tid_keepalives[f_tid] = true;
		self.setTimeout ("djs_tid_keepalive ('" + f_tid + "',true)",300000);
	}
}
<?php
} if ($g_block == "") {
?>
jQuery (function () { djs_browsersupport_set (null); });
<?php } ?>

//j// EOF