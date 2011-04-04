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
		var pngImg;

		// fix css background pngs
		$(this).find("*").each (function ()
		{
			pngImg = $(this).css("background-image");
			if (pngImg.toLowerCase().indexOf (".png") != -1) { $(this).css("background-image","none");this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + pngImg.replace (/url\((.+?)\)/gi,"$1") + ")"; }
		});

		//fix images with png-source
		for (var i=0;i < document.images.length;i++)
		{
			pngImg = document.images[i];

			if (pngImg.src.toLowerCase().indexOf (".png") != -1)
			{
				pngImg.runtimeStyle.width = pngImg.width + "px";
				pngImg.runtimeStyle.height = pngImg.height + "px";

				pngImg.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + pngImg.src + "')";
				pngImg.src = settings.blankgif;
			}
		}

		//fix input with png-source
		$(this).find("input[src*=.png]").each (function ()
		{
			pngImg = $(this).attr ("src");
			$(this).attr("src",settings.blankgif).css ("filter","progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + pngImg + "')");
		});

		return jQuery;
	};
})(jQuery);