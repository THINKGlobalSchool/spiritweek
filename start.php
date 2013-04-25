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

	// Define videos
	define('MONDAY_VIDEO', '9bZkp7q19f0');
	define('TUESDAY_VIDEO', 'FdKFnOsWaSg');
	define('WEDNESDAY_VIDEO', 'HNtBphqE_LA');
	define('THURSDAY_VIDEO', 'QAEkuVgt6Aw');
	define('FRIDAY_VIDEO', 'QD-Cg64GuvI');

	// Register JS
	$s_js = elgg_get_simplecache_url('js', 'spiritweek/spiritweek');
	elgg_register_simplecache_view('js/spiritweek/spiritweek');
	elgg_register_js('elgg.spiritweek', $s_js);

	// If logged in..
	if (elgg_is_logged_in()) {
		// Determin if and which video we're playing and on which page
		switch (spiritweek_get_daily_video()) {
			case MONDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'groups', 'spiritweek_route_handler', 1);
				break;
			case TUESDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'pages', 'spiritweek_route_handler', 1);
				break;
			case WEDNESDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'polls', 'spiritweek_route_handler', 1);
				break;
			case THURSDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'books', 'spiritweek_route_handler', 1);
				break;
			case FRIDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'forums', 'spiritweek_route_handler', 1);
				break;
		}
	}

	// elgg_set_ignore_access(true);
	// elgg_unset_plugin_setting('video_' . MONDAY_VIDEO, 'spiritweek');
	// elgg_unset_plugin_setting('video_' . TUESDAY_VIDEO, 'spiritweek');
	// elgg_unset_plugin_setting('video_' . WEDNESDAY_VIDEO, 'spiritweek');
	// elgg_unset_plugin_setting('video_' . THURSDAY_VIDEO, 'spiritweek');
	// elgg_unset_plugin_setting('video_' . FRIDAY_VIDEO, 'spiritweek');
	// elgg_set_ignore_access(false);
}

// General route hook
function spiritweek_route_handler($hook, $type, $return, $params) {
	spiritweek_include_exterals();
	elgg_extend_view('page/elements/footer', 'spiritweek/popup');
	return $return;
}

// Convenience..
function spiritweek_include_exterals() {
	elgg_load_js('elgg.spiritweek');
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
}

/**
 * Get video for day based on current timestamp
 *
 * Start date: 1367208000 (4/29/2013 12:00:00 AM EST)
 * End date:   1367640000 (5/4/2013 12:00:00 AM EST)
 */
function spiritweek_get_daily_video() {
	$start = 1367208000;
	$end = 1367640000;

	// Check for debug param
	if (get_input('SW_TIME_DEBUG', false)) {
		$time = get_input('SW_TIME_DEBUG');
	} else {
		$time = time(); // Use actual time
	}

	// Videos/dates
	$date_videos = array(
		'1367208000' => MONDAY_VIDEO,    // 4/29/2013 12:00:00 AM EST
		'1367294400' => TUESDAY_VIDEO,   // 4/30/2013 12:00:00 AM EST
		'1367380800' => WEDNESDAY_VIDEO, // 5/1/2013 12:00:00 AM EST
		'1367467200' => THURSDAY_VIDEO,  // 5/2/2013 12:00:00 AM EST
		'1367553600' => FRIDAY_VIDEO,    // 5/3/2013 12:00:00 AM EST
	);

	$dv_r = array_reverse($date_videos, true);

	foreach ($dv_r as $d => $v) {
		if ($time >= $d && ($time >= $start && $time <= $end)) {
			return $v;
			break;
		}
	}

	return false;
}

/**
 * Get title/description for given video
 *
 * @param 
 */
function spirit_week_get_video_info($video_id) {
	$video_desc = array(
		MONDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:monday_name'),
			'desc' => elgg_echo('spiritweek:monday_desc')
		),
		TUESDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:tuesday_name'),
			'desc' => elgg_echo('spiritweek:tuesday_desc')
		),
		WEDNESDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:wednesday_name'),
			'desc' => elgg_echo('spiritweek:wednesday_desc')
		),
		THURSDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:thursday_name'),
			'desc' => elgg_echo('spiritweek:thursday_desc')
		),
		FRIDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:friday_name'),
			'desc' => elgg_echo('spiritweek:friday_desc')
		)
	);

	return $video_desc[$video_id];
}

/**
 * Spiritweek notification
 * - Sends an email to admins if this is the first time a video has been viewed
 */
function spiritweek_notify($video_id) {
	// Check if this video has been viewed once
	if (!elgg_get_plugin_setting('video_' . $video_id, 'spiritweek') && !elgg_is_admin_logged_in()) {
		// First view!! Set viewed and notify
		elgg_set_plugin_setting('video_' . $video_id, 'viewed', 'spiritweek');

		$admins	= elgg_get_admins();

		global $CONFIG;

		$user = elgg_get_logged_in_user_entity();

		$info = spirit_week_get_video_info($video_id);

		// Notify admins
		foreach($admins as $admin) {
			if ($admin) {
				notify_user( 
					$admin->guid, $CONFIG->site->guid, 
					elgg_echo('spiritweek:firstviewsubject'), 
					elgg_echo('spiritweek:firstviewbody', array(
						$user->name, 
						$info['name']
					)),
					NULL, 
					'email'
				);
			}
		}
	}
}

