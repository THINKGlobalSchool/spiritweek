<?php
/**
 * TGS Spirit Week Popup View
 *
 * @package Spirit Week
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$video_id = spiritweek_get_daily_video();

if ($video_id) {
	$link = elgg_view('output/url', array(
		'id' => $video_id,
		'text' => 'test',
		'href' => "#sw-lightbox",
	 	'class' => 'sw-lightbox',
	 ));

	$video = elgg_view('spiritweek/video', array(
		'video_id' => $video_id
	));

	$hide_label = elgg_echo('spiritweek:hidevideo');

	$hide_checkbox = elgg_view('input/checkbox', array(
		'name' => $video_id,
		'class' => 'sw-hide-video'
	));

	$content = <<<HTML
		$link
		<div class='hidden'>
			<div id='sw-lightbox'>
				$video
				<div>
					<strong>$hide_label</strong> $hide_checkbox
				</div>
			</div>
		</div>
HTML;
	echo $content;
}