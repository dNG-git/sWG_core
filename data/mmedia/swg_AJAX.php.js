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
	f_params['beforeSend'] = djs_swgAJAX_event_show;
	f_params['complete'] = djs_swgAJAX_event_hide_soon;
	f_params['error'] = djs_swgAJAX_event_error;
	if ((typeof (f_params['url']) == 'undefined')&&(typeof (f_params['url0']) != 'undefined')) { f_params['url'] = '<?php echo addslashes (direct_linker ("url0","[f_url]",false)); ?>'.replace (/\[f_url\]/g,f_params.url0); }
	jQuery.ajax (f_params);
}

function djs_swgAJAX_event_error (f_object,f_status,f_error) { self.setTimeout ('djs_swgAJAX_event_hide ()',750); }

function djs_swgAJAX_event_hide ()
{
	djs_var.core_swgAJAX_loading_counter--;
	if (djs_var.core_swgAJAX_loading_counter < 1) { $('#swgAJAX_loading').slideUp ('slow'); }
}

function djs_swgAJAX_event_hide_soon (f_object,f_status) { self.setTimeout ('djs_swgAJAX_event_hide ()',750); }

function djs_swgAJAX_event_show (f_object)
{
	if (djs_var['core_swgAJAX_loading_transfer_source'] == null) { var f_speed = 'medium'; }
	else { var f_speed = 'fast'; }

	if (djs_var.core_swgAJAX_loading_counter < 1) { $('#swgAJAX_loading').slideDown (f_speed,function () { if (djs_var['core_swgAJAX_loading_transfer_source'] != null) { djs_var['core_swgAJAX_loading_transfer_source'].effect ("transfer",{ className:"pageajaxloadingtransfereffect",to:"#swgAJAX_loading" },"slow"); djs_var['core_swgAJAX_loading_transfer_source'] = null; } }); }
	else if (djs_var['core_swgAJAX_loading_transfer_source'] != null) { djs_var['core_swgAJAX_loading_transfer_source'].effect ("transfer",{ className:"pageajaxloadingtransfereffect",to:"#swgAJAX_loading" },"slow"); djs_var['core_swgAJAX_loading_transfer_source'] = null; }

	djs_var.core_swgAJAX_loading_counter++;
}

function djs_swgAJAX_init (f_params)
{
var f_jquery_object = $('#swgAJAX_loading_point').replaceWith (
jQuery("<div id='swgAJAX_loading' style='position:absolute;display:none;width:250px;height:125px;top:0px;left:0px;z-index:256'><div class='ui-dialog-content ui-widget-content ui-corner-bottom' style='position:fixed;width:250px;height:125px;padding:2px 5px'><table style='cursor:wait;height:115px'>\n" +
	"<tbody><tr>\n" +
	"<td class='pageajaxloadingbg' style='text-align:center;vertical-align:middle'><p class='pageajaxloadingcontent' style='font-weight:bold'><?php echo direct_local_get ("core_loading","text"); ?></p>\n" +
	"<p class='pageajaxloadingcontent'><?php echo direct_local_get ("core_loading_ajax","text"); ?></p></td>\n" +
	"</tr></tbody>\n" +
	"</table></div></div>").bind ("click",function () { $('#swgAJAX_loading').slideUp ('slow'); })
);

	if (f_jquery_object != null)
	{
		var f_left = $(self).width ();

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

		$('#swgAJAX_loading').css ("left",f_left + 'px');
	}
}
<?php } ?>

<?php if ($g_block == "djs_swgAJAX_insert") { ?>
function djs_swgAJAX_insert_after (f_params)
{
	if ((typeof (f_params['id']) != 'undefined')&&((typeof (f_params['url']) != 'undefined')||(typeof (f_params['url0']) != 'undefined')))
	{
		if (typeof (f_params['id_inserted']) == 'undefined') { f_params['id_inserted'] = f_params.id; }
		if (typeof (f_params['id_transfer_source']) != 'undefined') { djs_var['core_swgAJAX_loading_transfer_source'] = $("#" + f_params.id_transfer_source); }
		if (typeof (f_params['onInsert']) == 'undefined') { f_params['onInsert'] = null; }
		if (typeof (f_params['onInserted']) == 'undefined') { f_params['onInserted'] = null; }

		f_params['success'] = function (f_data,f_status,f_object)
		{
			if ((typeof (f_data) != null)&&(typeof (f_data['getElementsByTagName']) != 'undefined')&&(f_data.getElementsByTagName('swgAJAX').length > 0))
			{
				var f_content = f_data.getElementsByTagName ('content');
				var f_content_hide = f_data.getElementsByTagName ('content_hide');
				var f_javascript = f_data.getElementsByTagName ('javascript');
				var f_jquery_object = $("#" + f_params.id);
				var f_title = f_data.getElementsByTagName ('title');

				if ((f_content_hide.length == 1)&&(f_content_hide[0].firstChild.nodeValue == '1')) { f_content_hide = true; }
				else { f_content_hide = false; }

				if (f_title.length == 1) { f_title = f_title[0].firstChild.nodeValue; }
				else { f_title = null; }

				if (f_javascript.length == 1) { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:{ func:'djs_swgAJAX_insert_javascript',params:{ data:f_javascript[0].firstChild.nodeValue,id:f_params.id,onInserted:f_params.onInsert,perm_params:{ title:f_title } } },onInserted:f_params.onInserted,perm_params:{ title:f_title } }); }
				else { djs_swgDOM_insert_after ({ data:f_content[0].firstChild.nodeValue,hide:f_content_hide,id:f_params.id,id_inserted:f_params.id_inserted,onInsert:f_params.onInsert,onInserted:f_params.onInserted,perm_params:{ title:f_title } }); }
			}
		}

		djs_swgAJAX (f_params);
	}
}
<?php } ?>

<?php if ($g_block == "") { ?>
function djs_swgAJAX_insert_javascript (f_params)
{
	if ((typeof (f_params['data']) != 'undefined')&&(typeof (f_params['id']) != 'undefined'))
	{
		$("#" + f_params.id).append ("<script type='text/javascript'>" + f_params.data + "</script>");
		if ((typeof (f_params['onInserted']) != 'undefined')&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}
<?php } ?>

<?php if ($g_block == "djs_swgAJAX_replace") { ?>
function djs_swgAJAX_replace (f_params)
{
	if ((typeof (f_params['id']) != 'undefined')&&((typeof (f_params['url']) != 'undefined')||(typeof (f_params['url0']) != 'undefined')))
	{
		if (typeof (f_params['id_replaced']) == 'undefined') { f_params['id_replaced'] = f_params.id; }
		if (typeof (f_params['onReplace']) == 'undefined') { f_params['onReplace'] = null; }
		if (typeof (f_params['onReplaced']) == 'undefined') { f_params['onReplaced'] = null; }

		f_params['success'] = function (f_data,f_status,f_object)
		{
			if ((typeof (f_data != null)&&(typeof (f_data['getElementsByTagName']) != 'undefined')&&(f_data.getElementsByTagName('swgAJAX').length > 0)))
			{
				f_params['data'] = f_data;
				djs_swgAJAX_replace_with (f_params);
			}
		}

		djs_swgAJAX (f_params);
	}
}

function djs_swgAJAX_replace_with (f_params)
{
	var f_content = f_params.data.getElementsByTagName ('content');
	var f_javascript = f_params.data.getElementsByTagName ('javascript');

	if (f_content.length == 1)
	{
		if (f_javascript.length == 1) { djs_swgDOM_replace ({ data:f_content[0].firstChild.nodeValue,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:{ func:'djs_swgAJAX_insert_javascript',params:{ data:f_javascript[0].firstChild.nodeValue,id:f_params.id_replaced } },onReplaced:f_params.onReplaced }); }
		else { djs_swgDOM_replace ({ data:f_content[0].firstChild.nodeValue,id:f_params.id,id_replaced:f_params.id_replaced,onReplace:f_params.onReplace,onReplaced:f_params.onReplaced }); }
	}
}

function djs_swgAJAX_replace_url0 (f_id,f_url0) { djs_swgAJAX_replace ({ id:f_id,url0:f_url0 }); }
<?php } ?>

//j// EOF