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

djs_var['core_output_helper_ready'] = false;

function djs_core_helper_init (f_params)
{
	if ('id' in f_params)
	{
		if (djs_var.core_output_helper_ready)
		{
			var f_content,f_id = (('id_parent' in f_params) ? f_params.id : f_params.id + "_helper"),f_id_parent = (('id_parent' in f_params) ? f_params.id_parent : f_params.id),f_jquery_object;

			f_jquery_object = jQuery("#" + f_id);
			f_jquery_object.children('img').remove ();
			f_content = f_jquery_object.html ();
			f_jquery_object.remove ();

			jQuery("#" + f_id_parent).tooltip ({ content:"<aside>" + f_content + "</aside>",items:"#" + f_id_parent,position:{ at:'center top-5',collision:'flipfit',my:'center bottom' } });
		}
		else
		{
djs_load_functions ([
 { file:'ext_jquery/jquery.ui.core.min.js' },
 { file:'ext_jquery/jquery.ui.widget.min.js' },
 { file:'ext_jquery/jquery.ui.position.min.js' },
 { file:'ext_jquery/jquery.ui.tooltip.min.js' }
]).done (function ()
{
	djs_var.core_output_helper_ready = true;
	djs_core_helper_init (f_params);
});
		}
	}
}

//j// EOF