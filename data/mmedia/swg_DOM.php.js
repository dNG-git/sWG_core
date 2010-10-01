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
if ($g_block == "djs_swgDOM_attr_change_int") {
?>
function djs_swgDOM_attr_change_int (f_id,f_attr_element,f_attr_value) { $("#" + f_id).attr (f_attr_element,f_attr_value); }
<?php } ?>

<?php if ($g_block == "djs_swgDOM_css_change_px") { ?>
function djs_swgDOM_css_change_px (f_id,f_css_element,f_css_value,f_duration)
{
	var f_jquery_object = $("#" + f_id);

	if (f_css_value == '+')
	{
		f_duration = 0;
		f_css_value = parseInt (f_jquery_object.css (f_css_element));
		if (f_css_value) { f_css_value += 17; }
	}
	else if (f_css_value == '-')
	{
		f_duration = 0;
		f_css_value = parseInt (f_jquery_object.css (f_css_element));
		if ((f_css_value)&&(f_css_value > djs_var.core_swgDOM_css_change_px_min)) { f_css_value -= 17; }
	}
	else
	{
		if (f_duration == null) { f_duration = 1000; }
		f_css_value = parseInt (f_css_value);
	}

	if ((f_css_value)&&(f_jquery_object != null))
	{
		if (f_duration)
		{
			f_anim_object = { };
			f_anim_object[f_css_element] = f_css_value + "px";
			f_jquery_object.animate (f_anim_object,f_duration);
		}
		else { f_jquery_object.css (f_css_element,f_css_value + "px"); }
	}
}

if (typeof (djs_var['core_swgDOM_css_change_px_min']) == 'undefined') { djs_var['core_swgDOM_css_change_px_min'] = 111; }
else { djs_var['core_swgDOM_css_change_px_min'] = parseInt (djs_var['core_swgDOM_css_change_px_min']); }
<?php } ?>

<?php if ($g_block == "") { ?>
function djs_swgDOM_insert_after (f_params)
{
	if ((typeof (f_params['data']) != 'undefined')&&(typeof (f_params['id']) != 'undefined'))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		$("#" + f_params.id).after (f_jquery_object);
		if ((typeof (f_params['onInsert']) != 'undefined')&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == 'undefined')||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == 'undefined')||(f_params.onInserted == null)) { f_jquery_object.fadeIn ('fast'); }
			else { f_jquery_object.fadeIn ('fast',function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != 'undefined')&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_append (f_params)
{
	if ((typeof (f_params['data']) != 'undefined')&&(typeof (f_params['id']) != 'undefined'))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		$("#" + f_params.id).append (f_jquery_object);
		if ((typeof (f_params['onInsert']) != 'undefined')&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == 'undefined')||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == 'undefined')||(f_params.onInserted == null)) { f_jquery_object.fadeIn ('fast'); }
			else { f_jquery_object.fadeIn ('fast',function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != 'undefined')&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_before (f_params)
{
	if ((typeof (f_params['data']) != 'undefined')&&(typeof (f_params['id']) != 'undefined'))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		$("#" + f_params.id).before (f_jquery_object);
		if ((typeof (f_params['onInsert']) != 'undefined')&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == 'undefined')||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == 'undefined')||(f_params.onInserted == null)) { f_jquery_object.fadeIn ('fast'); }
			else { f_jquery_object.fadeIn ('fast',function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != 'undefined')&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_prepare (f_data)
{
	if (typeof (f_data) == 'object') { return f_data.hide (); }
	else { return jQuery(f_data).hide (); }
}

djs_var['swgDOM_replace_cache'] = { };

function djs_swgDOM_replace (f_params)
{
	if ((typeof (f_params['data']) != 'undefined')&&(typeof (f_params['id']) != 'undefined'))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data).attr ('id',f_params.id);

		if (typeof (f_params['id_replaced']) == 'undefined') { f_params['id_replaced'] = f_params.id; }
		if (typeof (f_params['onReplace']) == 'undefined') { f_params['onReplace'] = null; }
		if (typeof (f_params['onReplaced']) == 'undefined') { f_params['onReplaced'] = null; }

		djs_var.swgDOM_replace_cache[f_params.id] = { id:f_params.id_replaced,jquery_object:f_jquery_object,onReplace:f_params.onReplace,onReplaced:f_params.onReplaced };
		$("#" + f_params.id).fadeOut ('fast',djs_swgDOM_replace_with);
	}
}

function djs_swgDOM_replace_with ()
{
	var f_jquery_object = $(this);
	var f_id = f_jquery_object.attr ('id');

	if (typeof (djs_var.swgDOM_replace_cache[f_id]) != 'undefined')
	{
		var f_id_new = djs_var.swgDOM_replace_cache[f_id].id;

		if (f_id == f_id_new) { f_jquery_object.replaceWith (djs_var.swgDOM_replace_cache[f_id].jquery_object); }
		else { f_jquery_object.replaceWith (djs_var.swgDOM_replace_cache[f_id].jquery_object.attr ("id",f_id_new)); }

		if (djs_var.swgDOM_replace_cache[f_id].onReplace != null) { djs_run (djs_var.swgDOM_replace_cache[f_id].onReplace,djs_var.swgDOM_replace_cache[f_id],false); }

		if ((typeof (djs_var.swgDOM_replace_cache[f_id]['hide']) == 'undefined')||(!djs_var.swgDOM_replace_cache[f_id].hide))
		{
			if (djs_var.swgDOM_replace_cache[f_id].onReplaced == null)
			{
				delete (djs_var.swgDOM_replace_cache[f_id]);
				$("#" + f_id_new).fadeIn ('fast');
			}
			else
			{
				$("#" + f_id_new).fadeIn ('fast',function ()
				{
					djs_run (djs_var.swgDOM_replace_cache[f_id].onReplaced,djs_var.swgDOM_replace_cache[f_id],false);
					delete (djs_var.swgDOM_replace_cache[f_id]);
				});
			}
		}
		else if (djs_var.swgDOM_replace_cache[f_id].onReplaced != null)
		{
			djs_run (djs_var.swgDOM_replace_cache[f_id].onReplaced,djs_var.swgDOM_replace_cache[f_id],false);
			delete (djs_var.swgDOM_replace_cache[f_id]);
		}
	}
	else { f_jquery_object.fadeIn ('fast'); }
}
<?php } ?>

//j// EOF