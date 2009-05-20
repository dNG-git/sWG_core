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
$Id$
#echo(sWGcoreVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/

var djs_swgDOM_elements_editable = false;
var djs_swgDOM_content_editable = false;
var djs_swgDOM_head_node = null;

djs_var['core_swgDOM_needActiveX'] = false;
djs_var['core_swgDOM_usesXMLHttpRequest'] = false;

if ((typeof (self.document.getElementById) != 'undefined')&&(typeof (self.document.getElementsByTagName) != 'undefined'))
{
	if ((typeof (self.DOMParser) == 'function')||(typeof (self.DOMParser) == 'object')) { djs_swgDOM = true; }
	else if (typeof (self.ActiveXObject) == 'function')
	{
		djs_swgDOM = true;
		djs_var['core_swgDOM_needActiveX'] = true;
	}
	else if ((typeof (self.XMLHttpRequest) == 'function')||(typeof (self.XMLHttpRequest) == 'object'))
	{
		djs_swgDOM = true;
		djs_var['core_swgDOM_usesXMLHttpRequest'] = true;
	}
}

if (djs_swgDOM)
{
	if ((typeof (self.document.createElement) != 'undefined')&&(typeof (self.document.getElementsByTagName('head')[0].getAttribute) != 'undefined')&&(typeof (self.document.getElementsByTagName('head')[0].setAttribute) != 'undefined')&&(typeof (self.document.getElementsByTagName('head')[0].removeAttribute) != 'undefined')) { djs_swgDOM_elements_editable = true; }
	if (typeof (self.document.getElementsByTagName('head')[0].firstChild.nodeValue) != 'undefined') { djs_swgDOM_content_editable = true; }
}

if (typeof (djs_var['lang_charset']) == 'undefined') { djs_var['lang_charset'] = 'UTF-8'; }

function djs_swgDOM_create_js_node ()
{
	var f_return = false;

	if (djs_swgDOM_elements_editable)
	{
		if (djs_swgDOM_head_node == null)
		{
			djs_swgDOM_head_node = top.document.getElementsByTagName ('head');
			if (djs_swgDOM_head_node != null) { djs_swgDOM_head_node = djs_swgDOM_head_node[0]; }
		}

		if (djs_swgDOM_head_node != null)
		{
			f_return = top.document.createElement ("script");
			f_return.setAttribute ("language","JavaScript1.5");
			f_return.setAttribute ("type","text/javascript");
		}
	}

	return f_return;
}

function djs_swgDOM_css_change_px (f_id,f_css_element,f_css_value)
{
	if (djs_swgDOM)
	{
	// Only continue if the basic test had been completed successfully
	if (djs_swgDOM_elements_editable)
	{
		var f_object = self.document.getElementById (f_id);

		if ((typeof (f_object) != 'undefined')&&(typeof (f_object.style) != 'undefined'))
		{
			f_css_element = f_css_element.replace (/\W+/g,"");
			if (typeof (f_object.style[f_css_element]) == 'undefined') { f_object = null; }
		}

		if ((typeof (f_object) != 'undefined')&&(f_object != null))
		{
			var f_css_value_temp = 0;

			if (f_css_value == '+')
			{
				f_css_value_temp = parseInt (f_object.style[f_css_element]);
				if (f_css_value_temp) { f_object.style[f_css_element] = ((f_css_value_temp + 17) + "px"); }
			}
			else if (f_css_value == '-')
			{
				f_css_value_temp = parseInt (f_object.style[f_css_element]);

				if (f_css_value_temp)
				{
					if (f_css_value_temp > 111) { f_object.style[f_css_element] = ((f_css_value_temp - 17) + "px"); }
				}
			}
			else
			{
				f_css_value_temp = parseInt (f_css_value);
				if (f_css_value_temp) { f_object.style[f_css_element] = f_css_value_temp + "px"; }
			}
		}
	}
	}
}

function djs_swgDOM_get (f_doc_root_id)
{
	var f_return = null;

	if (djs_swgDOM)
	{
		var f_doc_root = self.document.getElementById (f_doc_root_id);
		if (djs_swgDOM_structure_check (f_doc_root)) { f_return = f_doc_root; }
	}

	return f_return;
}

function djs_swgDOM_insert (f_data,f_doc_root_id)
{
	var f_return = false;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		var f_doc_root = self.document.getElementById (f_doc_root_id);

		if (djs_swgDOM_structure_check (f_doc_root))
		{
			f_data = djs_swgDOM_parse_string (f_data);
			if (typeof (f_data) == 'object') { f_return = djs_swgDOM_structure_insert_xml (f_doc_root_id,f_data); }
		}
	}
	else
	{
		f_return = true;
		self.document.writeln (f_data);
	}

	return f_return;
}

function djs_swgDOM_insert_js (f_data)
{
	var f_return = false;
	var f_js_root = djs_swgDOM_create_js_node ();

	if (f_js_root)
	{
		try { f_js_root.appendChild (top.document.createTextNode (f_data)); }
		catch (f_handled_exception) { f_js_root.text += f_data; }

		djs_swgDOM_head_node.appendChild (f_js_root);
		f_return = true;
	}

	return f_return;
}

function djs_swgDOM_insert_js_url (f_url)
{
	var f_return = false;
	var f_js_root = djs_swgDOM_create_js_node ();

	if (f_js_root)
	{
		f_js_root.setAttribute ("src",f_url);
		djs_swgDOM_head_node.appendChild (f_js_root);
		f_return = true;
	}

	return f_return;
}

function djs_swgDOM_parse_string (f_data)
{
	var f_return;

	if (djs_swgDOM)
	{
		if (djs_var['core_swgDOM_needActiveX'])
		{
			var f_dom_parser;

			if (typeof (djs_var['core_swgDOM_ActiveX_element']) == 'string')
			{
				try { f_dom_parser = new self.ActiveXObject (djs_var['core_swgDOM_ActiveX_element']); }
				catch (f_unhandled_exception) { }
			}
			else
			{
var f_ActiveX_elements = new Array (
"MSXML2.DOMDocument.3.0", // msxml3.dll
"MSXML2.DOMDocument.6.0", // msxml6.dll
"MSXML2.DOMDocument.5.0", // msxml5.dll
"MSXML2.DOMDocument.4.0", // msxml4.dll
"MSXML2.DOMDocument.2.6", // msxml2.dll
"MSXML.DOMDocument" // http://support.microsoft.com/kb/269238
);

				for (var f_i = 0;f_i < f_ActiveX_elements.length;f_i++)
				{
					if (typeof (f_dom_parser) == 'undefined')
					{
						try
						{
							f_dom_parser = new self.ActiveXObject (f_ActiveX_elements[f_i]);
							djs_var['core_swgDOM_ActiveX_element'] = f_ActiveX_elements[f_i];
						}
						catch (f_unhandled_exception) { }
					}
				}
			}

			if (typeof (f_dom_parser) == 'object')
			{
				try
				{
					f_dom_parser.async = false;
					f_dom_parser.resolveExternals = false;
					if (f_dom_parser.loadXML (f_data)) { f_return = f_dom_parser.documentElement; }
				}
				catch (f_unhandled_exception) { }
			}
		}
		else if ((djs_swgAJAX)&&(djs_var['core_swgDOM_usesXMLHttpRequest']))
		{
			var f_ajax_helper = djs_swgAJAX_init ();

			try
			{
				f_ajax_helper.open ('GET',('data:application/xml:charset=' + djs_var['lang_charset'] + ',' + (escape (f_data))),false);
				f_return = f_ajax_helper.responseXML;
			}
			catch (f_unhandled_exception) { }
		}
		else
		{
			try { f_return = (new self.DOMParser ()).parseFromString (f_data,'application/xml'); }
			catch (f_unhandled_exception) { }
		}
	}

	if (typeof (f_return) == 'undefined') { f_return = false; }
	return f_return;
}

function djs_swgDOM_replace (f_data,f_doc_root_id)
{
	var f_return = false;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		var f_doc_root = self.document.getElementById (f_doc_root_id);

		if (djs_swgDOM_structure_check (f_doc_root))
		{
			f_data = djs_swgDOM_parse_string (f_data);
			if (typeof (f_data) == 'object') { f_return = djs_swgDOM_structure_replace_xml (f_doc_root_id,f_data); }
		}
	}

	return f_return;
}

function djs_swgDOM_structure_check (f_xml_data)
{
	var f_return = false;

	if (djs_swgDOM)
	{
		if (typeof (f_xml_data) == 'object')
		{
			if ((f_xml_data != null)&&(typeof (f_xml_data.nodeType) != 'undefined'))
			{
				if ((f_xml_data.nodeType == 1)||(f_xml_data.nodeType == 4)||(f_xml_data.nodeType == 8)||(f_xml_data.nodeType == 9)) { f_return = true; }
			}
		}
	}

	return f_return;
}

function djs_swgDOM_structure_insert_xml (f_doc_root_id,f_xml_data)
{
	var f_return = false;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		var f_doc_root = self.document.getElementById (f_doc_root_id);

		if (f_doc_root)
		{
		if (f_doc_root.nodeType)
		{
			if (djs_swgDOM_structure_check (f_xml_data))
			{
				if (f_xml_data.nodeType == 9) { f_return = djs_swgDOM_structure_insert_xml (f_doc_root_id,f_xml_data.documentElement); }
				else
				{
					f_return = true;

					var f_node_new = self.document.createElement (f_xml_data.nodeName);
					f_node_new = djs_swgDOM_structure_insert_xml_walker (f_node_new,f_xml_data);

					try { f_doc_root.appendChild (f_node_new); }
					catch (f_handled_exception) { f_return = false; }
				}
			}
		}
		}
	}

	return f_return;
}

function djs_swgDOM_structure_insert_xml_get (f_xml_data)
{
	var f_return;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		if (djs_swgDOM_structure_check (f_xml_data))
		{
			if (f_xml_data.nodeType == 9) { f_return = djs_swgDOM_structure_insert_xml_get (f_xml_data.documentElement); }
			else
			{
				f_return = self.document.createElement (f_xml_data.nodeName);
				f_return = djs_swgDOM_structure_insert_xml_walker (f_return,f_xml_data);
			}
		}
	}

	if (typeof (f_return) == 'undefined') { f_return = false; }
	return f_return;
}

function djs_swgDOM_structure_insert_xml_walker (f_return,f_xml_data)
{
	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		if (djs_swgDOM_structure_check (f_xml_data))
		{
			if (f_xml_data.attributes) { djs_swgDOM_style_parse (f_return,f_xml_data.attributes); }

			if (f_xml_data.childNodes)
			{
			if (f_xml_data.childNodes.length > 0)
			{
				var f_node_new_child;

				for (var f_i = 0;f_i < f_xml_data.childNodes.length;f_i++)
				{
					if (f_xml_data.childNodes[f_i].nodeType == 1)
					{
						f_node_new_child = self.document.createElement (f_xml_data.childNodes[f_i].nodeName);
						f_return.appendChild (f_node_new_child);
						djs_swgDOM_structure_insert_xml_walker (f_node_new_child,f_xml_data.childNodes[f_i]);
					}
					else if (f_xml_data.childNodes[f_i].nodeType == 3)
					{
						f_node_new_child = self.document.createTextNode (f_xml_data.childNodes[f_i].nodeValue);
						f_return.appendChild (f_node_new_child);
					}
				}
			}
			}
		}
	}

	return f_return;
}

function djs_swgDOM_structure_delete (f_doc_root_id)
{
	var f_return = false;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		var f_node = self.document.getElementById (f_doc_root_id);

		if (f_node)
		{
		if (f_node.cloneNode)
		{
			var f_doc_root = f_node.parentNode;
			f_return = true;

			try { f_doc_root.removeChild (f_node); }
			catch (f_handled_exception) { f_return = false; }
		}
		}
	}

	return f_return;
}

function djs_swgDOM_structure_replace_xml (f_doc_root_id,f_xml_data)
{
	var f_return = false;

	if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
	{
		var f_node_old = self.document.getElementById (f_doc_root_id);

		if (f_node_old)
		{
		if (f_node_old.nodeType)
		{
			if (djs_swgDOM_structure_check (f_xml_data))
			{
				if (f_xml_data.nodeType == 9) { f_return = djs_swgDOM_structure_replace_xml (f_doc_root_id,f_xml_data.documentElement); }
				else
				{
					var f_node_new = djs_swgDOM_structure_insert_xml_get (f_xml_data);
					var f_doc_root = f_node_old.parentNode;
					f_return = true;

					try { f_doc_root.replaceChild (f_node_new,f_node_old); }
					catch (f_handled_exception) { f_return = false; }
				}
			}
		}
		}
	}

	return f_return;
}

if ((djs_swgDOM_content_editable)&&(djs_swgDOM_elements_editable))
{
	function djs_swgDOM_style_parse (f_return,f_attributes)
	{
		if (typeof (f_attributes) == 'object')
		{
			if (f_attributes.length > 0)
			{
				var f_css_class = "";
				var f_dom_border = "";
				var f_dom_cell_padding = "";
				var f_dom_cell_spacing = "";
				var f_dom_id = "";

				for (var f_i = 0;f_i < f_attributes.length;f_i++)
				{
					if (f_attributes[f_i].nodeName.toLowerCase () == 'class') { f_css_class = f_attributes[f_i].nodeValue; }
					else if (f_attributes[f_i].nodeName.toLowerCase () == 'border') { f_dom_border = f_attributes[f_i].nodeValue; }
					else if (f_attributes[f_i].nodeName.toLowerCase () == 'cellpadding') { f_dom_cell_padding = f_attributes[f_i].nodeValue; }
					else if (f_attributes[f_i].nodeName.toLowerCase () == 'cellspacing') { f_dom_cell_spacing = f_attributes[f_i].nodeValue; }
					else if (f_attributes[f_i].nodeName.toLowerCase () == 'id') { f_dom_id = f_attributes[f_i].nodeValue; }
					else if (f_attributes[f_i].nodeName.toLowerCase () == 'style') { djs_swgDOM_style_parse_css (f_return,f_attributes[f_i].nodeValue) }
					else { f_return.setAttribute (f_attributes[f_i].nodeName,f_attributes[f_i].nodeValue); }
				}

				if (f_css_class.length > 0)
				{
					f_return.setAttribute ('class',f_css_class);
					if (typeof (f_return.className) != 'undefined') { f_return.className = f_css_class; }
				}

				if (f_dom_border.length > 0)
				{
					f_return.setAttribute ('border',f_dom_border);
					if (typeof (f_return.border) != 'undefined') { f_return.border = f_dom_border; }
				}

				if (f_dom_cell_padding.length > 0)
				{
					f_return.setAttribute ('cellpadding',f_dom_cell_padding);
					if (typeof (f_return.cellPadding) != 'undefined') { f_return.cellPadding = f_dom_cell_padding; }
				}

				if (f_dom_cell_spacing.length > 0)
				{
					f_return.setAttribute ('cellspacing',f_dom_cell_spacing);
					if (typeof (f_return.cellSpacing) != 'undefined') { f_return.cellSpacing = f_dom_cell_spacing; }
				}

				if (f_dom_id.length > 0)
				{
					f_return.setAttribute ('id',f_dom_id);
					if (typeof (f_return.id) != 'undefined') { f_return.id = f_dom_id; }
				}
			}
		}

		return f_return;
	}

	function djs_swgDOM_style_parse_css (f_return,f_css_style)
	{
		if (djs_swgDOM_structure_check (f_return))
		{
			f_return.setAttribute ('style',f_css_style);

			if ((typeof (f_return.style) == 'object')&&(f_css_style.length > 2))
			{
				var f_css_style_elements = f_css_style.split (";");
				var f_css_style_element;
				var f_css_style_charPos;
				var f_css_style_element_new;

				for (var f_i = 0;f_i < f_css_style_elements.length;f_i++)
				{
					f_css_style_element = f_css_style_elements[f_i].split (":",2);

					if (f_css_style_element.length == 2)
					{
						f_css_style_element[0] = f_css_style_element[0].replace ("/(;|\s)/","");
						f_css_style_charPos = f_css_style_element[0].indexOf ('-');

						while (f_css_style_charPos > -1)
						{
							if ((f_css_style_charPos > 0)&&(f_css_style_charPos < (2 + f_css_style_charPos)))
							{
								f_css_style_element_new = f_css_style_element[0].substring (0,f_css_style_charPos);
								f_css_style_element_new += (f_css_style_element[0].substring ((1 + f_css_style_charPos),(2 + f_css_style_charPos))).toUpperCase ();
								f_css_style_element_new += f_css_style_element[0].substring (2 + f_css_style_charPos);

								f_css_style_element[0] = f_css_style_element_new;
								f_css_style_charPos = f_css_style_element[0].indexOf ('-');
							}
							else { f_css_style_charPos = -1; }
						}

						f_css_style_element[1] = f_css_style_element[1].replace ("/'/","\"");
						f_css_style_element[1] = f_css_style_element[1].replace ("/\\/","");

						try
						{
							f_css_style_element[0] = f_css_style_element[0].replace (/\W+/g,"");
							f_return.style[f_css_style_element[0]] = f_css_style_element[1];
						}
						catch (f_unhandled_exception) { }
					}
				}
			}
		}

		return f_return;
	}
}

//j// EOF