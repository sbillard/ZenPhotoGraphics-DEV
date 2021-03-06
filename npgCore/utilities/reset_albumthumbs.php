<?php
/**
 * Use this utility to reset your album thumbnails to either "random" or from an ordered field query
 *
 * @author Stephen Billard (sbillard)
 *
 * @package admin
 */
define('OFFSET_PATH', 3);

require_once(dirname(__DIR__) . '/admin-globals.php');
require_once(dirname(__DIR__) . '/template-functions.php');

admin_securityChecks(MANAGE_ALL_ALBUM_RIGHTS, $return = currentRelativeURL());

if (isset($_REQUEST['thumbtype']) || isset($_REQUEST['thumbselector'])) {
	XSRFdefender('reset_thumbs');
}

$buffer = '';

printAdminHeader('admin', 'thumbs');
echo '</head>';
?>

<body>
	<?php printLogoAndLinks(); ?>
	<div id="main">
		<?php printTabs(); ?>
		<div id="content">
			<?php npgFilters::apply('admin_note', 'reste_thumbs', ''); ?>
			<h1><?php echo (gettext('Reset your album thumbnails')); ?></h1>
			<div class="tabbox">
				<?php
				if (isset($_REQUEST['thumbtype'])) {
					$key = sanitize_numeric($_REQUEST['thumbtype'], 3);
					$sql = 'UPDATE ' . prefix('albums') . ' SET `thumb`=' . $key;
					$text = $_albumthumb_selector[$key]['desc'];
					if (query($sql)) {
						?>
						<div class="messagebox fade-message">
							<h2>
								<?php printf(gettext("Thumbnails all set to <em>%s</em>."), $text); ?></h2>
						</div>
						<?php
					} else {
						?>
						<div class="errorbox fade-message">
							<h2>
								<?php echo gettext("Thumbnail reset query failed"); ?></h2>
						</div>
						<?php
					}
				}
				$current = getOption('AlbumThumbSelect');

				$selections = array();
				foreach ($_albumthumb_selector as $key => $selection) {
					$selections[$selection['desc']] = $key;
				}
				?>
				<form name="set_random" action="">
					<input type="hidden" name="tab" value="resetthumbs">
					<?php XSRFToken('reset_thumbs') ?>
					<div id="set_all">
						<?php applyButton(array('buttonText' => BURST_BLUE . ' ' . gettext("Set all albums to"), array('buttonClass' => 'fixedwidth'))); ?>
						<select id="thumbtype" name="thumbtype">
							<?php
							generateListFromArray(array($current), $selections, false, true);
							?>
						</select>
					</div>
				</form>
			</div>
		</div><!-- content -->
		<?php printAdminFooter(); ?>
	</div><!-- main -->
</body>
<?php echo "</html>"; ?>




