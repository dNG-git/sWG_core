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

djs_var['core_output_helper_cache'] = { };

function djs_core_helper_init (f_params)
{
	if (f_params.hide) { djs_core_helper_hide (f_params.id); }
	else { $("#" + f_params.id).one ("click",function () { djs_core_helper_hide (f_params.id); }); }
}

function djs_core_helper_hide (f_id) { $("#" + f_id).fadeOut ('slow',djs_core_helper_hidden); }

function djs_core_helper_hidden ()
{
	var f_jquery_object = $(this);
	var f_id = f_jquery_object.attr ('id');
	djs_var.core_output_helper_cache[f_id] = f_jquery_object.replaceWith ("<div id='" + f_id + "' style='display:none'><a href=\"javascript:djs_core_helper_show('" + f_id + "');\"><?php echo direct_local_get ("core_detailed_information_show"); ?></a></div>");

	$("#" + f_id).fadeIn ('slow');
}

function djs_core_helper_show (f_id) { $("#" + f_id).fadeOut ('slow',djs_core_helper_shown); }

function djs_core_helper_shown ()
{
	var f_jquery_object = $(this);
	var f_id = f_jquery_object.attr ('id');

	if (typeof (djs_var.core_output_helper_cache[f_id]) != 'undefined')
	{
		f_jquery_object.replaceWith (djs_var.core_output_helper_cache[f_id]);
		delete (djs_var.core_output_helper_cache[f_id]);

		f_jquery_object = $("#" + f_id);
		f_jquery_object.one ("click",function () { djs_core_helper_hide (f_id); });
		f_jquery_object.fadeIn ('slow');
	}
	else { f_jquery_object.fadeIn ('slow'); }
}

$('.pagehelpericon > img').attr ('title',"<?php echo direct_local_get ("core_detailed_information_hide"); ?>");

//j// EOF