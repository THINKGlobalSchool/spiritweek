<?php
/**
 * TGS Spirit Week JS
 *
 * @package Spirit Week
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
?>

elgg.provide('elgg.spiritweek');

/**	
 * Helper to check for local storage support
 */
elgg.spiritweek.supportsLocalStorage = function() {
	try {
		return 'localStorage' in window && window['localStorage'] !== null;
	} catch (e) {
		return false;
	}
}

/**
 * SW JS init
 */
elgg.spiritweek.init = function() {
	// Create fancybox for spirit videos
	$(".sw-lightbox").fancybox({
		'onClosed' : function() {
			// Remove the video div on close
			$('div#sw-lightbox').remove();
		}
	});

	// init
	$.fancybox.init();

	if ($('a.sw-lightbox').length) {
		if (elgg.spiritweek.supportsLocalStorage()) {
			if (!localStorage.getItem('elgg.spiritweek.hide.' + $('a.sw-lightbox').attr('id'))) {
				// trigger click
				$("a.sw-lightbox").click();
			}
		} else {
			// trigger click
			$("a.sw-lightbox").click();
		}
	}

	$('input.sw-hide-video').bind('click', function(event) {
		if ($(this).is(':checked')) {
			if (elgg.spiritweek.supportsLocalStorage()) {
				localStorage.setItem('elgg.spiritweek.hide.' + $(this).attr('name'), 1);
			}
		} else {
			if (elgg.spiritweek.supportsLocalStorage()) {
				localStorage.removeItem('elgg.spiritweek.hide.' + $(this).attr('name'));
			}
		}
	});
}

// Elgg SW init
elgg.register_hook_handler('init', 'system', elgg.spiritweek.init);