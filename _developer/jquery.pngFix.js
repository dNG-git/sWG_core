/**
 * jQuery-Plugin "pngFix"
 * Version: 1.2, 09.03.2009 - customized by direct Netware Group
 * by Andreas Eberhard, andreas.eberhard@gmail.com
 *                      http://jquery.andreaseberhard.de/
 *
 * Copyright (c) 2007 Andreas Eberhard
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 */
(function ($) {
	jQuery.fn.pngFix = function (settings) {
		settings = jQuery.extend ({ blankgif: 'blank.gif' },settings);

		if (jQuery.browser.msie && parseInt (jQuery.browser.version) < 7) {
			//fix images with png-source
			jQuery(this).find("img[src*=.png]").each (function () {
				var bgIMG = jQuery(this).attr ('src');
				jQuery(this).attr ('src',settings.blankgif);
				jQuery(this).css ('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + bgIMG + '\', sizingMethod=\'scale\');');
			});

			// fix css background pngs
			jQuery(this).find("*").each (function () {
				var bgIMG = jQuery(this).css ('background-image');
				if (bgIMG.indexOf (".png") != -1) {
					var bgIMGie = bgIMG.split('url("')[1].split('")')[0];
					jQuery(this).css ('background-image','none');
					jQuery(this).css ('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + bgIMGie + '\', sizingMethod=\'scale\');');
				}
			});

			//fix input with png-source
			jQuery(this).find("input[src*=.png]").each (function () {
				var bgIMG = jQuery(this).attr ('src');
				jQuery(this).attr ('src',settings.blankgif);
				jQuery(this).css ('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + bgIMG + '\', sizingMethod=\'scale\');');
			});
		}

		return jQuery;
	};
})(jQuery);