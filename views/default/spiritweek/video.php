<?php
/**
 * TGS Spirit Week Video View
 *
 * @package Spirit Week
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['id'] The youtube video id
 */

$video_id = elgg_extract('video_id', $vars);

$title = elgg_echo('spiritweek:video_title');

$info = spirit_week_get_video_info($video_id);

$desc = $info['desc'];

$content = <<<HTML
	<h2>$title</h2>
	<object width="560" height="315">
		<param name="movie" value="http://www.youtube.com/v/{$video_id}"></param>
		<param name="allowFullScreen" value="true"></param>
		<param name="allowscriptaccess" value="always"></param>
		<embed src="http://www.youtube.com/v/{$video_id}" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
		</embed>
	</object>
HTML;

// Get this users spirit week metadata
$sw_meta = elgg_get_metadata(array(
	'guid' => elgg_get_logged_in_user_guid(),
	'metadata_name' => 'spiritweek_2013'
));

// If we've got metadata, unserialize it
if (count($sw_meta) == 1) {
	$user_sw_meta = unserialize($sw_meta[0]['value']);
} else {
	// New empty array
	$user_sw_meta = array();
}

// This video viewed metadata
$user_sw_meta[$video_id] = true;

// Create/update user spirit week metadata
create_metadata(elgg_get_logged_in_user_guid(), 'spiritweek_2013', serialize($user_sw_meta), '', 0, ACCESS_LOGGED_IN);

spiritweek_notify($video_id);

echo $content;