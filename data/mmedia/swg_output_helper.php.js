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

djs_var['core_output_helper_cache'] = { };

function djs_core_helper_init (f_params)
{
	jQuery("#" + f_params.id + " > img").attr ('title',"<?php echo direct_local_get ("core_detailed_information_hide"); ?>");

	if (f_params.hide)
	{
		if ('data' in f_params) { djs_var.core_output_helper_cache[f_params.id] = f_params.data; }
		else { djs_core_helper_hide (f_params.id); }
	}
	else { jQuery("#" + f_params.id).one ('click',function () { djs_core_helper_hide (f_params.id); }); }
}

function djs_core_helper_hide (f_id)
{
	djs_var.core_output_helper_cache[f_id] = jQuery ("#" + f_id);
	djs_DOM_replace ({ data:"<div id='" + f_id + "' style='display:none'><a href=\"javascript:djs_core_helper_show('" + f_id + "')\"><?php echo direct_local_get ("core_detailed_information_show"); ?></a></div>",id:f_id,speed:'slow' });
}

function djs_core_helper_show (f_id)
{
	djs_DOM_replace ({ data:djs_var.core_output_helper_cache[f_id],id:f_id,onReplace:{ func:'djs_core_helper_shown',params:{ id:f_id } },speed:'slow' });
	delete (djs_var.core_output_helper_cache[f_id]);
}

function djs_core_helper_shown (f_params) { jQuery("#" + f_params.id).one ('click',function () { djs_core_helper_hide (f_params.id); }); }

//j// EOF