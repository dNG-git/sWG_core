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
if ($g_block == "") {
?>
djs_var['core_swgAJAX_loading_counter'] = 0;
djs_var['core_swgAJAX_loading_transfer_source'] = null;

function djs_swgAJAX (f_params)
{
	if ((!("url" in f_params))&&("url0" in f_params)) { f_params['url'] = "<?php echo addslashes (direct_linker_dynamic ("url0","[f_url]",false)); ?>".replace (/\[f_url\]/g,f_params.url0); }
	return jQuery.ajax (f_params);
}

function djs_swgAJAX_event_hide ()
{
	if (djs_var.core_swgAJAX_loading_counter > 0) { djs_var.core_swgAJAX_loading_counter--; }
	if (djs_var.core_swgAJAX_loading_counter < 1) { jQuery("#swgAJAX_loading").slideUp ("slow"); }
}

function djs_swgAJAX_event_hide_soon (f_jqXHR,f_status) { self.setTimeout ("djs_swgAJAX_event_hide ()",750); }

function djs_swgAJAX_event_show (f_jqXHR)
{
	if (djs_var.core_swgAJAX_loading_transfer_source === null) { var f_speed = "medium"; }
	else { var f_speed = "fast"; }

	if (djs_var.core_swgAJAX_loading_counter < 1) { jQuery("#swgAJAX_loading").slideDown (f_speed,function () { if (djs_var.core_swgAJAX_loading_transfer_source !== null) { djs_var.core_swgAJAX_loading_transfer_source.effect ("transfer",{ className:"pageajaxloadingtransfereffect",to:"#swgAJAX_loading" },"slow"); djs_var.core_swgAJAX_loading_transfer_source = null; } }); }
	else if (djs_var.core_swgAJAX_loading_transfer_source !== null) { djs_var.core_swgAJAX_loading_transfer_source.effect ("transfer",{ className:"pageajaxloadingtransfereffect",to:"#swgAJAX_loading" },"slow"); djs_var.core_swgAJAX_loading_transfer_source = null; }

	djs_var.core_swgAJAX_loading_counter++;
}

function djs_swgAJAX_init (f_params)
{
var f_jquery_object = jQuery("#swgAJAX_loading_point").replaceWith (
jQuery("<div id='swgAJAX_loading' style='position:absolute;display:none;width:250px;height:125px;top:0px;left:0px;z-index:256'><div class='ui-dialog-content ui-widget-content ui-corner-bottom' style='position:fixed;width:250px;height:125px;padding:2px 5px'><table style='cursor:wait;height:115px'>\n" +
"<tbody><tr>\n" +
"<td class='pageajaxloadingbg' style='text-align:center;vertical-align:middle'><p class='pageajaxloadingcontent' style='font-weight:bold'><?php echo direct_local_get ("core_loading","text"); ?></p>\n" +
"<p class='pageajaxloadingcontent'><?php echo direct_local_get ("core_loading_ajax","text"); ?></p></td>\n" +
"</tr></tbody>\n" +
"</table></div></div>").on("ajaxStop",djs_swgAJAX_event_hide_soon).on("ajaxStart",djs_swgAJAX_event_show).on ("click",djs_swgAJAX_event_hide)
);

	if (f_jquery_object !== null)
	{
		djs_browsersupport_set ({ "key": "JSDOMManipulation" });
		var f_left = jQuery(self).width ();

		if (f_params.position == "center") { f_left = Math.ceil ((f_left - 250) / 2); }
		else if ((f_left > 250)&&(f_params.position == "left"))
		{
			if (Math.ceil (f_left * 0.05) < f_left) { f_left = Math.ceil (f_left * 0.05); }
			else { f_left -= 250; }
		}
		else if ((f_left > 250)&&(f_params.position == "right"))
		{
			if (Math.ceil (f_left - (f_left * 0.05) - 250) > 0) { f_left = Math.ceil (f_left - (f_left * 0.05) - 250); }
			else { f_left -= 250; }
		}
		else { f_left = 0; }

		jQuery("#swgAJAX_loading").css ("left",f_left + "px");
	}
}
<?php
} if ($g_block == "djs_swgAJAX_insert") {
?>
function djs_swgAJAX_insert_after (f_params)
{
	if (("id" in f_params)&&(("url" in f_params)||("url0" in f_params)))
	{
		if (!("id_inserted" in f_params)) { f_params['id_inserted'] = f_params.id; }
		if ("id_transfer_source" in f_params) { djs_var.core_swgAJAX_loading_transfer_source = jQuery("#" + f_params.id_transfer_source); }
		if (!("onInsert" in f_params)) { f_params['onInsert'] = null; }
		if (!("onInserted" in f_params)) { f_params['onInserted'] = null; }

		f_params['success'] = function (f_data,f_status,f_jqXHR)
		{
			if ((f_data !== null)&&("getElementsByTagName" in f_data)&&(f_data.getElementsByTagName("swgAJAX").length > 0))
			{
				var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_data);
				var f_content = f_data.getElementsByTagName ("content");
				var f_javascript = f_data.getElementsByTagName ("javascript");

				f_jqXHR.done (function ()
				{
					if (f_javascript.length == 1) { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:{ func:"djs_swgAJAX_insert_javascript",params:{ data:f_javascript[0].firstChild.nodeValue,id:f_params.id,onInserted:f_params.onInsert,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
					else { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:f_params.onInsert,onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
				});
			}
		}

		f_params['error'] = function (f_jqXHR)
		{
			if (("responseXML" in f_jqXHR)&&("getElementsByTagName" in f_jqXHR.responseXML)&&(f_jqXHR.responseXML.getElementsByTagName("swgAJAX").length > 0))
			{
				var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_jqXHR.responseXML);
				var f_content = f_jqXHR.responseXML.getElementsByTagName ("content");
				var f_javascript = f_jqXHR.responseXML.getElementsByTagName ("javascript");

				f_jqXHR.fail (function ()
				{
					if (f_javascript.length == 1) { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:{ func:"djs_swgAJAX_insert_javascript",params:{ data:f_javascript[0].firstChild.nodeValue,id:f_params.id,onInserted:f_params.onInsert,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
					else { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:f_params.onInsert,onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
				});
			}
		}

		djs_swgAJAX (f_params);
	}
}
<?php
} if ($g_block == "") {
?>
function djs_swgAJAX_insert_javascript (f_params)
{
	if (("data" in f_params)&&("id" in f_params))
	{
		jQuery("#" + f_params.id).append ("<script type='text/javascript'>" + f_params.data + "</script>");
		if (("onInserted" in f_params)&&(f_params.onInserted !== null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgAJAX_parse_reply (f_params,f_data)
{
	var f_return = { content_hide:false,title:null,width:-1,width_max:-1,window_closeable:true,window_modal:true };

	var f_content_hide = f_data.getElementsByTagName ("content_hide");
	var f_jquery_object = jQuery("#" + f_params.id);
	var f_title = f_data.getElementsByTagName ("title");
	var f_width = f_data.getElementsByTagName ("width");
	var f_window_closeable = f_data.getElementsByTagName ("window_closeable");
	var f_window_modal = f_data.getElementsByTagName ("window_modal");

	if ((f_content_hide.length == 1)&&(f_content_hide[0].firstChild.nodeValue == "1")) { f_return.content_hide = true; }
	if (f_title.length == 1) { f_return.title = f_title[0].firstChild.nodeValue; }
	if (!("width_max" in f_params)) { f_return.width_max = jQuery(self).width (); }

	if (f_width.length == 1)
	{
		switch (f_width[0].firstChild.nodeValue)
		{
		case "s":
		{
			f_return.width = Math.round (f_return.width_max * 0.3);
			break;
		}
		case "m":
		{
			f_return.width = Math.round (f_return.width_max * 0.55);
			break;
		}
		case "l":
		{
			f_return.width = Math.round (f_return.width_max * 0.8);
			break;
		}
		default: { f_return.width = f_width[0].firstChild.nodeValue; }
		}
	}
	else if ("width" in f_params) { f_return.width = f_params.width; }
	else { f_return.width = Math.round (f_return.width_max * 0.8); }

	if ((f_window_closeable.length == 1)&&(f_window_closeable[0].firstChild.nodeValue == "0")) { f_return.window_closeable = false; }

	if ("modal" in f_params) { f_return.window_modal = f_params.modal; }
	else if ((f_window_modal.length == 1)&&(f_window_modal[0].firstChild.nodeValue == "0")) { f_return.window_modal = false; }

	return f_return;
}
<?php
} if ($g_block == "djs_swgAJAX_replace") {
?>
function djs_swgAJAX_replace (f_params)
{
	if (("id" in f_params)&&(("url" in f_params)||("url0" in f_params)))
	{
		if (!("id_replaced" in f_params)) { f_params['id_replaced'] = f_params.id; }
		if ("id_transfer_source" in f_params) { djs_var.core_swgAJAX_loading_transfer_source = jQuery("#" + f_params.id_transfer_source); }
		if (!("onReplace" in f_params)) { f_params['onReplace'] = null; }
		if (!("onReplaced" in f_params)) { f_params['onReplaced'] = null; }

		f_params['success'] = function (f_data,f_status,f_jqXHR)
		{
			if ((f_data !== null)&&("getElementsByTagName" in f_data)&&(f_data.getElementsByTagName("swgAJAX").length > 0))
			{
				f_params['data'] = f_data;
				f_jqXHR.done (function () { djs_swgAJAX_replace_with (f_params); });
			}
		}

		f_params['error'] = function (f_jqXHR)
		{
			if (("responseXML" in f_jqXHR)&&("getElementsByTagName" in f_jqXHR.responseXML)&&(f_jqXHR.responseXML.getElementsByTagName("swgAJAX").length > 0))
			{
				f_params['data'] = f_jqXHR.responseXML;
				f_jqXHR.fail (function () { djs_swgAJAX_replace_with (f_params); });
			}
		}

		djs_swgAJAX (f_params);
	}
}

function djs_swgAJAX_replace_with (f_params)
{
	var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_params.data);
	var f_content = f_params.data.getElementsByTagName ("content");
	var f_javascript = f_params.data.getElementsByTagName ("javascript");

	if (f_content.length == 1)
	{
		if (f_javascript.length == 1) { djs_swgDOM_replace ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:{ func:"djs_swgAJAX_insert_javascript",params:{ data:f_javascript[0].firstChild.nodeValue,id:f_params.id,onInserted:f_params.onReplace,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onReplaced:f_params.onReplaced,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
		else { djs_swgDOM_replace ({ data:f_content[0].firstChild.nodeValue,hide:f_ajax_values.content_hide,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:f_params.onReplace,onReplaced:f_params.onReplaced,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
	}
}

function djs_swgAJAX_replace_url0 (f_id,f_url0) { djs_swgAJAX_replace ({ id:f_id,url0:f_url0 }); }
<?php } ?>

//j// EOF