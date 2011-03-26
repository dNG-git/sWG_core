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
$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : '');
if ($g_block == "") {
?>
function djs_browsersupport_set (f_params)
{
	if (f_params == null) { f_params = { "name": "BrowserSupport","key": "JS" }; }
	else if (typeof (f_params['name']) == "undefined") { f_params['name'] = "BrowserSupport"; }

	var f_cookie_value = djs_cookie_get (f_params.name);

	if (f_cookie_value == null) { djs_cookie_set (f_params.name,f_params.key,f_params); }
	else
	{
		f_cookie_value = ' ' + f_cookie_value + ' ';
		if (f_cookie_value.indexOf (' ' + f_params.key + ' ') < 0) { djs_cookie_set (f_params.name,(f_cookie_value.substr (1) + f_params.key),f_params); }
	}
}

djs_var['core_cookies'] = null;

function djs_cookie_get (f_name)
{
	if ((typeof (f_name) == 'object')&&(typeof (f_name['name']) != "undefined")) { f_name = f_name['name']; }
	var f_return = null;

	if ((djs_var.core_cookies == null)&&(typeof (self.document.cookie) != "undefined"))
	{
		djs_var.core_cookies = { };

		if (self.document.cookie.length)
		{
			var f_cookie = null;
			var f_cookies = self.document.cookie.split (";");

			for (f_i = 0; f_i < f_cookies.length; f_i++)
			{
				f_cookie = f_cookies[f_i].split ('=');
				if (f_cookie[1].length < 1) { f_cookie[1] = ''; }
				djs_var.core_cookies[f_cookie[0].replace(/^\s+|\s+$/g,'')] = decodeURIComponent (f_cookie[1].replace (/^\s+|\s+$/g,''));
			}
		}
	}

	if ((djs_var.core_cookies != null)&&(typeof (djs_var.core_cookies[f_name]) != "undefined")) { f_return = djs_var.core_cookies[f_name]; }
	return f_return
}

function djs_cookie_set (f_name,f_value,f_params)
{
	if (djs_var.core_cookies == null) { djs_cookie_get (f_name); }

	if (djs_var.core_cookies != null)
	{
		if (f_params == null) { f_params = { }; }
		if (typeof (f_params['expires']) == "undefined") { f_params['expires'] = 604800000; }

		if (f_params.expires == null) { f_params.expires = null; }
		else if (f_params.expires == -1) { f_params.expires = "Sat, 01-Jan-00 01:00:00 GMT"; }
		else if (typeof (f_params.expires) != 'string') { f_params.expires = new Date (f_params.expires + <?php echo $direct_cachedata['core_time']; ?>000).toGMTString (); }

		if (typeof (f_params['domain']) == "undefined") { f_params['domain'] = "<?php echo $direct_settings['swg_cookie_server']; ?>"; }
		if (typeof (f_params['path']) == "undefined") { f_params['path'] = "<?php echo $direct_settings['swg_cookie_path']; ?>"; }

		var f_cookie_options = "";
		if (f_params.path.length) { f_cookie_options += "; PATH=" + f_params.path; }
		if (f_params.domain.length) { f_cookie_options += "; DOMAIN=" + f_params.domain; }
		if (f_params.expires != null) { f_cookie_options += "; EXPIRES=" + f_params.expires; }

		djs_var.core_cookies[f_name] = f_value;
		self.document.cookie = f_name + "=" + (encodeURIComponent (f_value)) + f_cookie_options;
	}
}

djs_var['core_dialog_ready'] = false;
if (typeof (djs_var['core_dialog_width']) == "undefined") { djs_var['core_dialog_width'] = 0.75; }

function djs_dialog (f_id,f_params)
{
	if (!djs_var.core_dialog_ready)
	{
		djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.widget.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.mouse.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.position.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.draggable.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.resizable.min.js" });
		djs_load_functions ({ file:"ext_jquery/jquery.ui.dialog.min.js" });
		djs_load_functions ({ file:"swg_DOM.php.js",block:"djs_swgAJAX_replace" });
		djs_var.core_dialog_ready = true;
	}

	if (f_id == null)
	{
		if (typeof (f_params['id']) == "undefined")
		{
			f_id = "swg" + (Math.random().toString().replace (/\./g,"_")) + "d";
			$("body").append ("<div id='" + f_id + "' style='display:none'></div>");
		}
		else
		{
			f_id = f_params.id + "d";
			$("#" + f_params.id).append ("<div id='" + f_id + "' style='display:none'></div>");
		}
	}

	if (f_id != null)
	{
		if (typeof (f_params['url']) != "undefined")
		{
			f_self = $(self);

			if (typeof (f_params['title']) == "undefined") { djs_swgDOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='ui-widget ui-state-highlight' style='width:100%;height:100%'></iframe>",id:f_id,onInserted:{ func:"djs_dialog_view",params:{ draggable:false,id:f_id,height:(f_self.height () * 0.95),modal:true,resizable:false,title:"<?php echo direct_local_get ("core_detailed_information","text"); ?>",width:(f_self.width () * 0.95) } } }); }
			else { djs_swgDOM_insert_append ({ data:"<iframe src=\"" + (f_params.url.replace (/\&/g,"&amp;")) + "\" class='ui-widget ui-state-highlight' style='width:100%;height:100%'></iframe>",id:f_id,onInserted:{ func:"djs_dialog_view",params:{ draggable:false,id:f_id,height:(f_self.height () * 0.95),modal:true,resizable:false,title:f_params.title,width:(f_self.width () * 0.95) } } }); }
		}
		else
		{
			if (f_params == null) { f_params = { width:($(self).width () * djs_var.core_dialog_width) }; }
			else if (typeof (f_params['width']) == "undefined") { f_params['width'] = ($(self).width () * djs_var.core_dialog_width); }

			f_params.id = f_id;
			djs_dialog_view (f_params);
		}
	}
}

function djs_dialog_init (f_params)
{
	if (typeof (f_params['id']) != "undefined") { djs_dialog (f_params.id,f_params); }
}

function djs_dialog_view (f_params)
{
	if (typeof (f_params['id']) != "undefined")
	{
		if ((typeof (f_params['buttons']) == "undefined")&&((typeof (f_params['window_closeable']) == "undefined")||(f_params['window_closeable']))) { f_params['buttons'] = { "<?php echo direct_local_get ("core_close","text"); ?>": function () { $(this).dialog ("close"); } } }
		$("#" + f_params.id).dialog(f_params).bind ("dialogclose",function () { $("#" + f_params.id).remove (); });
	}
}
<?php
} if ($g_block == "djs_html5_progress") {
?>
djs_var['core_html5_progress_ready'] = false;

function djs_html5_progress (f_jquery_object)
{
	if (f_jquery_object == null) { f_jquery_object = $("progress"); }
	else { f_jquery_object = f_jquery_object.find ("progress"); }

	var f_jquery_check = false;

	if (!djs_var.core_html5_progress_ready)
	{
		if (typeof (f_jquery_object.get()[0]['value']) != "undefined") { djs_var.core_html5_progress_ready = true; }
		else
		{
			djs_load_functions ({ file:"ext_jquery/jquery.ui.core.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.widget.min.js" });
			djs_load_functions ({ file:"ext_jquery/jquery.ui.progressbar.min.js" });
			djs_var.core_html5_progress_ready = true;
			f_jquery_check = true;
		}
	}
	else if (typeof (f_jquery_object.get()[0]['value']) == "undefined") { f_jquery_check = true; }

	if (f_jquery_check)
	{
		f_jquery_object.each (function ()
		{
			var f_jquery_object = $(this);
			var f_jquery_progressbar = f_jquery_object.parent ()
			var f_jquery_value = f_jquery_object.attr ("value");

			f_jquery_progressbar.css("display","inline-block").css ("width",(f_jquery_progressbar.css ("width")));
			f_jquery_object.remove ();

			if (f_jquery_value == null) { f_jquery_progressbar.progressbar ({ value:0 }); }
			else { f_jquery_progressbar.progressbar ({ value:f_jquery_value }); }
		});
	}
}
<?php
} if ($g_block == "") {
?>
function djs_load_functions (f_params)
{
	if (typeof (f_params['block']) == "undefined") { djs_swgAJAX ({ async:false,cache:true,dataType:"script",url0:"<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dbid+".$direct_settings['product_buildid']; ?>".replace (/\[file\]/g,f_params.file) }); }
	else { djs_swgAJAX ({ async:false,cache:true,dataType:"script",url0:"<?php echo "s=cache;dsd=dfile+$direct_settings[path_mmedia]/[file]++dblock+[block]++dbid+".$direct_settings['product_buildid']; ?>".replace(/\[file\]/g,f_params.file).replace (/\[block\]/g,f_params.block) }); }
}

djs_var['core_run_onload'] = [ ];

function djs_run (f_params,f_perm_params,f_is_perm_params)
{
	if ((typeof (f_params['func']) != "undefined")&&(typeof (f_params['params']) != "undefined")&&(typeof (self[f_params.func]) != "undefined"))
	{
		if (f_perm_params != null)
		{
			if (!f_is_perm_params)
			{
				if (typeof (f_perm_params['perm_params']) == "undefined") { f_perm_params = [ ]; }
				else { f_perm_params = f_perm_params.perm_params; }
			}

			for (var f_param in f_perm_params)
			{
				if (typeof (f_params.params[f_param]) == "undefined") { f_params.params[f_param] = f_perm_params[f_param]; }
			}
		}

		try { self[f_params.func] (f_params.params); }
		catch (f_unhandled_exception) { }
	}
}

function djs_run_onload ()
{
	djs_var.core_run_onload.unshift ({ func:"djs_browsersupport_set",params:null });
	for (var f_i = 0;f_i < djs_var.core_run_onload.length;f_i++) { djs_run (djs_var.core_run_onload[f_i]); }
}
<?php } ?>

//j// EOF