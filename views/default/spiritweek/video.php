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

$content = <<<HTML
	<object width="560" height="315">
		<param name="movie" value="http://www.youtube.com/v/{$video_id}&autoplay=1"></param>
		<param name="allowFullScreen" value="true"></param>
		<param name="allowscriptaccess" value="always"></param>
		<embed src="http://www.youtube.com/v/{$video_id}&autoplay=1" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true">
		</embed>
	</object>
HTML;

echo $content;