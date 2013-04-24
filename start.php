<?php
/**
 * TGS Spirit Week
 *
 * @package Spirit Week
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

elgg_register_event_handler('init', 'system', 'spiritweek_init');

// Init podcasts
function spiritweek_init() {
	// Extend main CSS
	elgg_extend_view('css/elgg', 'css/spiritweek/css');

	// Register JS
	$s_js = elgg_get_simplecache_url('js', 'spiritweek/spiritweek');
	elgg_register_simplecache_view('js/spiritweek/spiritweek');
	elgg_register_js('elgg.spiritweek', $s_js);
	elgg_load_js('elgg.spiritweek');
}