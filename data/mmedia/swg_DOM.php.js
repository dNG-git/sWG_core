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

function djs_swgDOM_insert_after (f_params)
{
	if ((typeof (f_params['data']) != "undefined")&&(typeof (f_params['id']) != "undefined"))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		jQuery("#" + f_params.id).after (f_jquery_object);
		if ((typeof (f_params['onInsert']) != "undefined")&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == "undefined")||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == "undefined")||(f_params.onInserted == null)) { f_jquery_object.fadeIn ("fast"); }
			else { f_jquery_object.fadeIn ("fast",function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != "undefined")&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_append (f_params)
{
	if ((typeof (f_params['data']) != "undefined")&&(typeof (f_params['id']) != "undefined"))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		jQuery("#" + f_params.id).append (f_jquery_object);
		if ((typeof (f_params['onInsert']) != "undefined")&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == "undefined")||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == "undefined")||(f_params.onInserted == null)) { f_jquery_object.fadeIn ("fast"); }
			else { f_jquery_object.fadeIn ("fast",function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != "undefined")&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_before (f_params)
{
	if ((typeof (f_params['data']) != "undefined")&&(typeof (f_params['id']) != "undefined"))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data);
		if (f_params.id != f_params.id_inserted) { f_jquery_object.attr ("id",f_params.id_inserted); }

		jQuery("#" + f_params.id).before (f_jquery_object);
		if ((typeof (f_params['onInsert']) != "undefined")&&(f_params.onInsert != null)) { djs_run (f_params.onInsert,f_params,false); }

		if ((typeof (f_params['hide']) == "undefined")||(!f_params.hide))
		{
			if ((typeof (f_params['onInserted']) == "undefined")||(f_params.onInserted == null)) { f_jquery_object.fadeIn ("fast"); }
			else { f_jquery_object.fadeIn ("fast",function () { djs_run (f_params.onInserted,f_params,false); }); }
		}
		else if ((typeof (f_params['onInserted']) != "undefined")&&(f_params.onInserted != null)) { djs_run (f_params.onInserted,f_params,false); }
	}
}

function djs_swgDOM_insert_prepare (f_data)
{
	if (typeof (f_data) == "object") { return f_data.hide (); }
	else { return jQuery(f_data).hide (); }
}

djs_var['swgDOM_replace_cache'] = { };

function djs_swgDOM_replace (f_params)
{
	if ((typeof (f_params['data']) != "undefined")&&(typeof (f_params['id']) != "undefined"))
	{
		var f_jquery_object = djs_swgDOM_insert_prepare (f_params.data).attr ("id",f_params.id);

		if (typeof (f_params['id_replaced']) == "undefined") { f_params['id_replaced'] = f_params.id; }
		if (typeof (f_params['onReplace']) == "undefined") { f_params['onReplace'] = null; }
		if (typeof (f_params['onReplaced']) == "undefined") { f_params['onReplaced'] = null; }
		if (typeof (f_params['speed']) == "undefined") { f_params['speed'] = "fast"; }

		djs_var.swgDOM_replace_cache[f_params.id] = { id:f_params.id_replaced,jquery_object:f_jquery_object,onReplace:f_params.onReplace,onReplaced:f_params.onReplaced,speed:f_params.speed };

		jQuery("body").append ("<div id='" + f_params.id_replaced + "phdiv' style='position:absolute;top:0px;left:0px;width:1px;height:" + (jQuery(self.document).height ()) + "px;z-index:-256'>&#0160;</div>");
		jQuery("#" + f_params.id).fadeOut (f_params.speed,djs_swgDOM_replace_with);
	}
}

function djs_swgDOM_replace_with ()
{
	var f_jquery_object = jQuery(this);
	var f_id = f_jquery_object.attr ("id");

	if (typeof (djs_var.swgDOM_replace_cache[f_id]) != "undefined")
	{
		var f_params = djs_var.swgDOM_replace_cache[f_id];

		delete (djs_var.swgDOM_replace_cache[f_id]);
		var f_id_new = f_params.id;

		if (f_id == f_id_new) { f_jquery_object.replaceWith (f_params.jquery_object); }
		else { f_jquery_object.replaceWith (f_params.jquery_object.attr ("id",f_id_new)); }

		if (f_params.onReplace != null) { djs_run (f_params.onReplace,f_params,false); }

		if ((typeof (f_params['hide']) == "undefined")||(!f_params.hide))
		{
			if (f_params.onReplaced == null) { jQuery("#" + f_id_new).fadeIn (f_params.speed,function () { jQuery("#" + f_id_new + "phdiv").remove (); }); }
			else
			{
				jQuery("#" + f_id_new).fadeIn (f_params.speed,function ()
				{
					jQuery("#" + f_id_new + "phdiv").remove ();
					djs_run (f_params.onReplaced,f_params,false);
				});
			}
		}
		else if (f_params.onReplaced != null) { djs_run (f_params.onReplaced,f_params,false); }
	}
	else { f_jquery_object.fadeIn ("fast"); }
}

//j// EOF