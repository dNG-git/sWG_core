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
$Id: swg_AJAX.js,v 1.10 2008/12/15 18:21:37 s4u Exp $
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/

djs_var['core_swgAJAX_needActiveX'] = false;

if ((typeof (self.XMLHttpRequest) == 'function')||(typeof (self.XMLHttpRequest) == 'object')) { djs_swgAJAX = true; }
else if (typeof (self.ActiveXObject) == 'function')
{
	djs_swgAJAX = true;
	djs_var['core_swgAJAX_needActiveX'] = true;
}

function djs_swgAJAX_call (f_identifier,f_handler,f_request_mode,f_request_data,f_swgAJAX_loading_timeout)
{
	if ((djs_swgAJAX)&&(djs_swgDOM))
	{
		djs_var[f_identifier] = djs_swgAJAX_init ();

		if (typeof (djs_var[f_identifier]) == 'object')
		{
			djs_var[f_identifier].onreadystatechange = f_handler;

			try
			{
				djs_var[f_identifier].open (f_request_mode,f_request_data,true);
				djs_var[f_identifier].send (null);
				djs_swgAJAX_loading_event (f_identifier,'view',f_swgAJAX_loading_timeout);
			} catch (e) {}
		}
	}
}

function djs_swgAJAX_init ()
{
	var f_return;

	if (djs_swgAJAX)
	{
		if (djs_var['core_swgAJAX_needActiveX'])
		{
			if (typeof (djs_var['core_swgAJAX_ActiveX_element']) == 'string')
			{
				try { f_return = new self.ActiveXObject (djs_var['core_swgAJAX_ActiveX_element']); }
				catch (f_unhandled_exception) { }
			}
			else
			{
var f_ActiveX_elements = new Array (
"MSXML2.XMLHTTP.3.0", // msxml3.dll
"MSXML2.XMLHTTP.6.0", // msxml6.dll
"MSXML2.XMLHTTP.5.0", // msxml5.dll
"MSXML2.XMLHTTP.4.0", // msxml4.dll
"MSXML2.XMLHTTP.2.6", // msxml2.dll
"Microsoft.XMLHTTP" // http://support.microsoft.com/kb/269238
);

				for (var f_i = 0;f_i < f_ActiveX_elements.length;f_i++)
				{
					if (typeof (f_return) == 'undefined')
					{
						try
						{
							f_return = new self.ActiveXObject (f_ActiveX_elements[f_i]);
							djs_var['core_swgAJAX_ActiveX_element'] = f_ActiveX_elements[f_i];
						}
						catch (f_unhandled_exception) { }
					}
				}
			}
		}
		else { f_return = new self.XMLHttpRequest (); }
	}

	if (typeof (f_return) == 'undefined') { f_return = false; }
	return f_return;
}

djs_var['core_swgAJAX_loading_counter'] = 0;
djs_var['core_swgAJAX_loading_counter_processes'] = new Array ();

function djs_swgAJAX_loading_event (f_object,f_event,f_timeout)
{
	if ((djs_swgAJAX)&&(djs_swgDOM))
	{
	// Only continue if the basic test had been completed successfully
	if ((djs_var['core_swgAJAX_loading_position'] != '')&&(djs_swgDOM_elements_editable))
	{
		if (typeof (djs_var['core_swgAJAX_loading_counter_processes'][f_object]) == 'undefined') { djs_var['core_swgAJAX_loading_counter_processes'][f_object] = 0; }

		if (f_event == 'view')
		{
			djs_var['core_swgAJAX_loading_counter_processes'][f_object]++;
			djs_var['core_swgAJAX_loading_counter']++;
			if (f_timeout > 0) { self.setTimeout ('djs_swgAJAX_loading_event (\'' + f_object + '\',\'timeout\',0)',f_timeout); }
		}
		else
		{
			if (djs_var['core_swgAJAX_loading_counter_processes'][f_object] > 0) { djs_var['core_swgAJAX_loading_counter_processes'][f_object]--; }
			if (djs_var['core_swgAJAX_loading_counter'] > 0) { djs_var['core_swgAJAX_loading_counter']--; }
		}

		if (djs_var['core_swgAJAX_loading_counter'] == 1) { djs_swgAJAX_loading_view (); }
		else if (f_event == 'hide') { self.setTimeout ('djs_swgAJAX_loading_hide ()',2000); }
		else { djs_swgAJAX_loading_hide (); }
	}
	}
}

function djs_swgAJAX_loading_hide ()
{
	if ((djs_swgAJAX)&&(djs_swgDOM))
	{
	// Only continue if the basic test had been completed successfully
	if ((djs_var['core_swgAJAX_loading_position'] != '')&&(djs_swgDOM_elements_editable))
	{
		if (typeof (self.document.getElementById('swgAJAX_loading').firstChild.style.opacity) != 'undefined') { djs_iblock_fade_out ('swgAJAX_loading',(self.document.getElementById('swgAJAX_loading').firstChild.style.opacity * 100)); }
		else { self.document.getElementById('swgAJAX_loading').style.display = 'none'; }
	}
	}
}

function djs_swgAJAX_loading_view ()
{
	if ((djs_swgAJAX)&&(djs_swgDOM))
	{
	// Only continue if the basic test had been completed successfully
	if ((djs_var['core_swgAJAX_loading_position'] != '')&&(djs_swgDOM_elements_editable))
	{
		// Let us find out the window width. First we try the JavaScript standard element.
		if (typeof (self.innerWidth) == 'number') { var f_left = self.innerWidth; }
		// Great ... looks like we have some non standard conform browser :(
		else if (typeof (self.document.documentElement.clientWidth) == 'number') { var f_left = self.document.documentElement.clientWidth; }
		// Still nothing? Ok, we will select the screen size
		else { var f_left = screen.availWidth; }

		// Well ... there are two elements containing the window width - maybe it is the other one?
		if ((!f_left)&&(typeof (self.document.body.clientWidth) == 'number'))
		{
			if (self.document.body.clientWidth) { f_left = self.document.body.clientWidth; }
		}

		if (djs_var['core_swgAJAX_loading_position'] == 'center') { f_left = Math.ceil ((f_left - 250) / 2); }
		else if ((f_left > 250)&&(djs_var['core_swgAJAX_loading_position'] == 'left'))
		{
			if (Math.ceil (f_left * 0.05) < f_left) { f_left = Math.ceil (f_left * 0.05); }
			else { f_left -= 250; }
		}
		else if ((f_left > 250)&&(djs_var['core_swgAJAX_loading_position'] == 'right'))
		{
			if (Math.ceil (f_left - (f_left * 0.05) - 250) > 0) { f_left = Math.ceil (f_left - (f_left * 0.05) - 250); }
			else { f_left -= 250; }
		}
		else { f_left = 0; }

		self.document.getElementById('swgAJAX_loading').style.left = f_left + 'px';

		if (typeof (self.document.getElementById('swgAJAX_loading').firstChild.style.opacity) != 'undefined')
		{
			self.document.getElementById('swgAJAX_loading').firstChild.style.opacity = 0;
			self.setTimeout ('djs_iblock_fade_in (\'swgAJAX_loading\',0)',30);
		}

		self.document.getElementById('swgAJAX_loading').style.display = 'block';
	}
	}
}

function djs_swgAJAX_response (f_identifier,f_target_id,f_target_url)
{
	var f_result_code = 0;

	if (((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))&&(typeof (djs_var[f_identifier]) == 'object'))
	{
		if (djs_var[f_identifier].readyState == 4)
		{
			djs_swgAJAX_loading_event (f_identifier,'hide');
			f_result_code = djs_var[f_identifier].status;

			if ((f_result_code == 200)&&(f_target_id != '')) { djs_swgDOM_structure_replace_xml (f_target_id,djs_var[f_identifier].responseXML); }
			if ((f_result_code == 205)&&(f_target_url != '')) { self.document.location.replace (f_target_url); }
		}
	}

	return f_result_code;
}

function djs_swgAJAX_response_ripoint (f_identifier,f_target_id,f_target_url)
{
	var f_result_code = 0;

	if (((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))&&(typeof (djs_var[f_identifier]) == 'object'))
	{
		if (djs_var[f_identifier].readyState == 4)
		{
			djs_swgAJAX_loading_event (f_identifier,'hide');
			f_result_code = djs_var[f_identifier].status;

			if ((f_result_code == 200)&&(f_target_id != ''))
			{
				f_xml_data = djs_var[f_identifier].responseXML;

				if ((djs_swgDOM_structure_check (f_xml_data))&&(typeof (f_xml_data.firstChild) == 'object'))
				{
					if (typeof (f_xml_data.firstChild.setAttribute) != 'undefined') { f_xml_data.firstChild.setAttribute ('id',f_target_id); }
					if (typeof (f_xml_data.firstChild.id) != 'undefined') { f_xml_data.firstChild.id = f_target_id; }
				}

				djs_swgDOM_structure_replace_xml (f_target_id,f_xml_data);
			}

			if ((f_result_code == 205)&&(f_target_url != '')) { self.document.location.replace (f_target_url); }
		}
	}

	return f_result_code;
}

//j// EOF