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
 * Podcasts JS init
 */
elgg.spiritweek.init = function() {
	console.log('spiritweek');
}

// Elgg podcasts init
elgg.register_hook_handler('init', 'system', elgg.spiritweek.init);