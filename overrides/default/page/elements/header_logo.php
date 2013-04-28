<?php
/**
 * TGS Spirit Week Logo
 *
 * @package Spirit Week
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$site_url = elgg_get_site_url();
?>
<style>

/** Override logo **/
.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 20px 10px 10px 10px;
	background: url(<?php echo elgg_get_site_url(); ?>mod/spiritweek/graphics/bottom-blue.png) no-repeat !important;
}


.elgg-right-sidebar {
	position: relative;
	padding: 20px 10px 10px 10px;
	float: left;
	width: 400px;
	margin: 0 0 10px 0;
	background:url("<?php echo elgg_get_site_url(); ?>mod/spiritweek/graphics/bottom-blue.png") no-repeat !important;
}

/** Override logo **/
/*.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 20px 10px 10px 10px;
	background: url(<?php echo elgg_get_site_url(); ?>mod/spiritweek/graphics/bottom-red.png) no-repeat !important;
}


.elgg-right-sidebar {
	position: relative;
	padding: 20px 10px 10px 10px;
	float: left;
	width: 400px;
	margin: 0 0 10px 0;
	background:url("<?php echo elgg_get_site_url(); ?>mod/spiritweek/graphics/bottom-red.png") no-repeat !important;
}
*/

.elgg-home-right{
	background:none !important;
}

</style>
<!-- 
<h1>
	<a class="elgg-heading-site" href="<?php // echo $site_url; ?>">
		<?php // echo $site_name; ?>
	</a>
</h1>
-->
<a href="<?php echo $site_url; ?>"><img class='spot-logo' src="<?php echo elgg_get_site_url(); ?>mod/spiritweek/graphics/sw-logo-blue.png" border="0" alt="Think Spot Logo"></img></a>
