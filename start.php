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
	define('MONDAY_VIDEO', '24492485');
	define('TUESDAY_VIDEO', '60763684');
	define('WEDNESDAY_VIDEO', '56093731');
	define('THURSDAY_VIDEO', '6428069');
	define('FRIDAY_VIDEO', '27244727');
	define('SATURDAY_VIDEO', '45119481');
	define('SUNDAY_VIDEO', 'dZX6Q-Bj_xg');

	// Register JS
	$s_js = elgg_get_simplecache_url('js', 'spiritweek/spiritweek');
	elgg_register_simplecache_view('js/spiritweek/spiritweek');
	elgg_register_js('elgg.spiritweek', $s_js);

	// If logged in..
	if (elgg_is_logged_in()) {
		// Determin if and which video we're playing and on which page
		switch (spiritweek_get_daily_video()) {
			case MONDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'home', 'spiritweek_route_general_handler', 1);
				break;
			case TUESDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'todo', 'spiritweek_route_todolist_handler', 1);
				break;
			case WEDNESDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'tagdashboards', 'spiritweek_route_tagdb_weekly_handler', 1);
				break;
			case THURSDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'tagdashboards', 'spiritweek_route_tagdb_smile_handler', 1);
				break;
			case FRIDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'photos', 'spiritweek_route_allphotos_handler', 1);
				break;
			case SATURDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'members', 'spiritweek_route_general_handler', 1);
				break;
			case SUNDAY_VIDEO:
				elgg_register_plugin_hook_handler('route', 'home', 'spiritweek_route_general_handler', 1);
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
function spiritweek_route_general_handler($hook, $type, $return, $params) {
	spiritweek_include_views();
	return $return;
}

/* Specific page hooks */
function spiritweek_route_todolist_handler($hook, $type, $return, $params) {
	if (count($return['segments']) && $return['segments'][0] && $return['segments'][0] == 'dashboard') {
		spiritweek_include_views();
	}
	return $return;
}

function spiritweek_route_allphotos_handler($hook, $type, $return, $params) {
	if (count($return['segments']) && $return['segments'][0] && $return['segments'][0] == 'all') {
		spiritweek_include_views();
	}
	return $return;
}

function spiritweek_route_tagdb_smile_handler($hook, $type, $return, $params) {
	if (count($return['segments'])
		 && ($return['segments'][0] && $return['segments'][0] == 'view')
		 && ($return['segments'][1] && $return['segments'][1] == '114109') // Specific live tagdb
	) {
		spiritweek_include_views();
	}
	return $return;
}

function spiritweek_route_tagdb_weekly_handler($hook, $type, $return, $params) {
	if (count($return['segments'])
		 && ($return['segments'][0] && $return['segments'][0] == 'view')
		 && ($return['segments'][1] && $return['segments'][1] == '113396') // Specific live tagdb
	) {
		spiritweek_include_views();
	}
	return $return;
}

// Convenience..
function spiritweek_include_views() {
	elgg_load_js('elgg.spiritweek');
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
	elgg_extend_view('page/elements/footer', 'spiritweek/popup');
}

/**
 * Get video for day based on current timestamp
 *
 * Start date: 1367208000 (4/29/2013 12:00:00 AM EST)
 * End date:   1367812800 (5/6/2013 12:00:00 AM EST)
 */
function spiritweek_get_daily_video() {
	$start = 1367208000;
	$end = 1367812800;

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
		'1367640000' => SATURDAY_VIDEO,  //  5/4/2013 12:00:00 AM EST
		'1367726400' => SUNDAY_VIDEO     // 5/5/2013 12:00:00 EST
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
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:monday_desc')
		),
		TUESDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:tuesday_name'),
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:tuesday_desc')
		),
		WEDNESDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:wednesday_name'),
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:wednesday_desc')
		),
		THURSDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:thursday_name'),
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:thursday_desc')
		),
		FRIDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:friday_name'),
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:friday_desc')
		),
		SATURDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:saturday_name'),
			'type' => 'vimeo',
			'desc' => elgg_echo('spiritweek:saturday_desc')
		),
		SUNDAY_VIDEO => array(
			'name' => elgg_echo('spiritweek:sunday_name'),
			'type' => 'youtube',
			'desc' => elgg_echo('spiritweek:sunday_desc')
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
	if (!elgg_get_plugin_setting('video_' . $video_id, 'spiritweek') && !elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != 34520) {
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

