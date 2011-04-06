/**
 * jQuery-Plugin "pngFix"
 * Version: 1.2, 09.03.2009 - customized by direct Netware Group
 * by Andreas Eberhard, andreas.eberhard@gmail.com
 *                      http://jquery.andreaseberhard.de/
 *
 * Copyright (c) 2007 Andreas Eberhard
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
(function ($)
{
	jQuery.fn.pngFix = function (settings)
	{
		settings = jQuery.extend ({ blankgif:"blank.gif" },settings);

		var jQueryObject;
		var pngImgSrc;

		$(this).find("*").each (function ()
		{
			jQueryObject = $(this);

			switch (this.nodeName.toLowerCase ())
			{
			case "input":
			case "img":
			{
				pngImgSrc = jQueryObject.attr ("src");
				if ((pngImgSrc)&&(pngImgSrc.toLowerCase().indexOf (".png") != -1)) { jQueryObject.css({ "filter": "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + pngImgSrc + "')","width": this.width + "px","height": this.height + "px" }).attr ("src",settings.blankgif); }

				break;
			}
			default:
			{
				if (jQueryObject.find("a:first").length < 1)
				{
					pngImgSrc = jQueryObject.css ("background");
					if ((pngImgSrc)&&(pngImgSrc.test (/url\((.+?)\)/gi))) { jQueryObject.css({ "background-image": (pngImgSrc.replace (/^(.*?)url\((.+?)\)(.*?)$/gi,"$1 $3")),"filter": "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + pngImgSrc.replace (/url\((.+?)\)/gi,"$1") + ",sizingMethod='scale')" }); }
					pngImgSrc = jQueryObject.css ("background-image");
					if ((pngImgSrc)&&(pngImgSrc.toLowerCase().indexOf (".png") != -1)) { jQueryObject.css({ "background-image": "none","filter": "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + pngImgSrc.replace (/url\((.+?)\)/gi,"$1") + ",sizingMethod='scale')" }); }
				}
			}
			}
		});

		return jQuery;
	};
})(jQuery);