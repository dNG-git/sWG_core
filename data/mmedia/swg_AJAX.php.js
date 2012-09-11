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
$g_block = (isset ($direct_settings['dsd']['dblock']) ? $direct_settings['dsd']['dblock'] : "");
if ($g_block == "") {
?>
djs_var['core_swgAJAX_loading_counter'] = 0;
djs_var['core_swgAJAX_loading_transfer_source'] = null;

function djs_swgAJAX (f_params)
{
	if ((!('url' in f_params))&&('url0' in f_params)) { f_params['url'] = "<?php echo addslashes (direct_linker_dynamic ("url0","[f_url]",false)); ?>".replace (/\[f_url\]/g,f_params.url0); }
	return jQuery.ajax (f_params);
}

function djs_swgAJAX_event_hide ()
{
	if (djs_var.core_swgAJAX_loading_counter > 0) { djs_var.core_swgAJAX_loading_counter--; }
	if (djs_var.core_swgAJAX_loading_counter < 1) { jQuery('#swgAJAX_loading').slideUp ('slow'); }
}

function djs_swgAJAX_event_hide_soon (f_jqXHR,f_status) { self.setTimeout ('djs_swgAJAX_event_hide ()',750); }

function djs_swgAJAX_event_show (f_jqXHR)
{
	if (djs_var.core_swgAJAX_loading_transfer_source === null) { var f_speed = 'medium'; }
	else { var f_speed = 'fast'; }

	if (djs_var.core_swgAJAX_loading_counter < 1) { jQuery('#swgAJAX_loading').slideDown (f_speed,function () { if ((djs_var.core_swgAJAX_loading_transfer_source !== null)&&('effect' in djs_var.core_swgAJAX_loading_transfer_source)) { djs_var.core_swgAJAX_loading_transfer_source.effect ('transfer',{ className:'pageajaxloadingtransfereffect',to:'#swgAJAX_loading' },'slow'); djs_var.core_swgAJAX_loading_transfer_source = null; } }); }
	else if ((djs_var.core_swgAJAX_loading_transfer_source !== null)&&('effect' in djs_var.core_swgAJAX_loading_transfer_source)) { djs_var.core_swgAJAX_loading_transfer_source.effect ('transfer',{ className:'pageajaxloadingtransfereffect',to:'#swgAJAX_loading' },'slow'); djs_var.core_swgAJAX_loading_transfer_source = null; }

	djs_var.core_swgAJAX_loading_counter++;
}

function djs_swgAJAX_init (f_params)
{
var f_jquery_object = jQuery('#swgAJAX_loading_point').replaceWith (
jQuery("<div id='swgAJAX_loading' style='position:absolute;display:none;width:250px;height:125px;top:0px;left:0px;z-index:256'><div class='ui-dialog-content ui-widget-content ui-corner-bottom' style='position:fixed;width:250px;height:125px;padding:2px 5px'><table style='cursor:wait;height:115px'>\n" +
"<tbody><tr>\n" +
"<td class='pageajaxloadingbg' style='text-align:center;vertical-align:middle'><p class='pageajaxloadingcontent'><strong><?php echo direct_local_get ("core_loading","text"); ?></strong></p>\n" +
"<p class='pageajaxloadingcontent'><?php echo direct_local_get ("core_loading_ajax","text"); ?></p></td>\n" +
"</tr></tbody>\n" +
"</table></div></div>").on ({ ajaxStart:djs_swgAJAX_event_show,ajaxStop:djs_swgAJAX_event_hide_soon,click:djs_swgAJAX_event_hide })
);

	if (f_jquery_object !== null)
	{
		djs_browsersupport_set ({ 'key': 'JSDOMManipulation' });
		var f_left = jQuery(self).width ();

		if (f_params.position == 'center') { f_left = Math.ceil ((f_left - 250) / 2); }
		else if ((f_left > 250)&&(f_params.position == 'left'))
		{
			if (Math.ceil (f_left * 0.05) < f_left) { f_left = Math.ceil (f_left * 0.05); }
			else { f_left -= 250; }
		}
		else if ((f_left > 250)&&(f_params.position == 'right'))
		{
			if (Math.ceil (f_left - (f_left * 0.05) - 250) > 0) { f_left = Math.ceil (f_left - (f_left * 0.05) - 250); }
			else { f_left -= 250; }
		}
		else { f_left = 0; }

		jQuery('#swgAJAX_loading').css ('left',f_left + 'px');
	}
}
<?php
} if ($g_block == 'djs_swgAJAX_insert') {
?>
function djs_swgAJAX_insert_after (f_params)
{
	if (('id' in f_params)&&(('url' in f_params)||('url0' in f_params)))
	{
		if (!('id_inserted' in f_params)) { f_params['id_inserted'] = f_params.id; }
		if ('id_transfer_source' in f_params) { djs_var.core_swgAJAX_loading_transfer_source = jQuery ("#" + f_params.id_transfer_source); }
		if (!('onInsert' in f_params)) { f_params['onInsert'] = null; }
		if (!('onInserted' in f_params)) { f_params['onInserted'] = null; }

		djs_swgAJAX(f_params).done (function (f_reply,f_status,f_jqXHR)
		{
			if ((f_reply !== null)&&('getElementsByTagName' in f_reply)&&(f_reply.getElementsByTagName('swgAJAX').length > 0))
			{
				var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_reply),f_content = f_reply.getElementsByTagName('content')[0].firstChild.nodeValue,f_javascript = f_reply.getElementsByTagName ('javascript');
				if ('insert_children' in f_params) { f_content = jQuery(f_content).children (f_params.insert_children); }

				if (f_javascript.length == 1) { djs_DOM_insert_after ({ data:f_content,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:{ func:'djs_AJAX_insert_javascript',params:{ data:f_javascript[0].firstChild,id:f_params.id,onInserted:f_params.onInsert,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
				else { djs_DOM_insert_after ({ data:f_content,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:f_params.onInsert,onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
			}
		}).fail (function (f_jqXHR,f_status)
		{
			if (('responseXML' in f_jqXHR)&&('getElementsByTagName' in f_jqXHR.responseXML)&&(f_jqXHR.responseXML.getElementsByTagName('swgAJAX').length > 0))
			{
				var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_jqXHR.responseXML),f_content = f_jqXHR.responseXML.getElementsByTagName('content')[0].firstChild.nodeValue,f_javascript = f_jqXHR.responseXML.getElementsByTagName ('javascript');

				if (f_javascript.length == 1) { djs_DOM_insert_after ({ data:f_content,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:{ func:'djs_AJAX_insert_javascript',params:{ data:f_javascript[0].firstChild,id:f_params.id,onInserted:f_params.onInsert,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
				else { djs_DOM_insert_after ({ data:f_content,hide:f_ajax_values.content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:f_params.onInsert,onInserted:f_params.onInserted,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
			}
		});
	}
}
<?php
}

if ($g_block == "") { $direct_globals['basic_functions']->includeFile ($direct_settings['path_mmedia']."/ext_djs/djs_AJAX.min.js");; }

if ($g_block == "djs_swgAJAX_replace") {
?>
function djs_swgAJAX_replace (f_params)
{
	if (('id' in f_params)&&(('url' in f_params)||('url0' in f_params)))
	{
		if (!('id_replaced' in f_params)) { f_params['id_replaced'] = f_params.id; }
		if ('id_transfer_source' in f_params) { djs_var.core_swgAJAX_loading_transfer_source = jQuery ("#" + f_params.id_transfer_source); }
		if (!('onReplace' in f_params)) { f_params['onReplace'] = null; }
		if (!('onReplaced' in f_params)) { f_params['onReplaced'] = null; }

		djs_swgAJAX(f_params).done (function (f_reply,f_status,f_jqXHR)
		{
			if ((f_reply !== null)&&('getElementsByTagName' in f_reply)&&(f_reply.getElementsByTagName('swgAJAX').length > 0))
			{
				if ('replace_children' in f_params) { f_params['content'] = jQuery(f_reply.getElementsByTagName('content')[0].firstChild.nodeValue).children (f_params.replace_children); }
				else { f_params['content'] = f_reply.getElementsByTagName('content')[0].firstChild.nodeValue; }

				f_params['reply'] = f_reply;
				djs_swgAJAX_replace_with (f_params);
			}
		}).fail (function (f_jqXHR,f_status)
		{
			if (('responseXML' in f_jqXHR)&&('getElementsByTagName' in f_jqXHR.responseXML)&&(f_jqXHR.responseXML.getElementsByTagName('swgAJAX').length > 0))
			{
				f_params['content'] = f_jqXHR.responseXML.getElementsByTagName('content')[0].firstChild.nodeValue;
				f_params['reply'] = f_jqXHR.responseXML;

				djs_swgAJAX_replace_with (f_params);
			}
		});
	}
}

function djs_swgAJAX_replace_with (f_params)
{
	var f_ajax_values = djs_swgAJAX_parse_reply (f_params,f_params.reply),f_javascript = f_params.reply.getElementsByTagName ('javascript');

	if ('replace_children' in f_params)
	{
		jQuery("#" + f_params.id).empty().attr ('id',f_params.id_replaced);

		if (f_javascript.length == 1) { djs_DOM_insert_append ({ data:f_params.content,id:f_params.id_replaced,onInsert:{ func:'djs_AJAX_insert_javascript',params:{ data:f_javascript[0].firstChild,id:f_params.id,onInserted:f_params.onReplace } },onInserted:f_params.onReplaced }); }
		else { djs_DOM_insert_append ({ data:f_params.content,id:f_params.id_replaced,onInsert:f_params.onReplace,onInserted:f_params.onReplaced }); }
	}
	else if (f_javascript.length == 1) { djs_DOM_replace ({ data:f_params.content,hide:f_ajax_values.content_hide,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:{ func:'djs_AJAX_insert_javascript',params:{ data:f_javascript[0].firstChild,id:f_params.id,onInserted:f_params.onReplace,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } } },onReplaced:f_params.onReplaced,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
	else { djs_DOM_replace ({ data:f_params.content,hide:f_ajax_values.content_hide,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:f_params.onReplace,onReplaced:f_params.onReplaced,perm_params:{ modal:f_ajax_values.window_modal,title:f_ajax_values.title,width:f_ajax_values.width,window_closeable:f_ajax_values.window_closeable } }); }
}

<?php } ?>

function djs_swgAJAX_replace_url0 (f_id,f_url0) { djs_load_functions({ file:'swg_AJAX.php.js',block:'djs_swgAJAX_replace' }).done (function () { djs_swgAJAX_replace ({ id:f_id,url0:f_url0 }); }); }

//j// EOF