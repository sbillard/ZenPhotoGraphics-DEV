<?php
/**
 * The configuration parameters for TinyMCE 4.x.
 *
 * base configuration file
 *
 * Note:
 *
 * The following variables are presumed to have been set up by the specific configuration
 * file before including this script:
 *
 * <ul>
 * 	<li>$MCEselector: the class(es) upon which tinyMCE will activate</li>
 * 	<li>$MCEplugins: the list of plugins to include in the configuration</li>
 * 	<li>$MCEtoolbars: toolbar(s) for the configuration</li>
 * 	<li>$MCEstatusbar: Status to true for a status bar, false for none</li>
 * 	<li>$MCEmenubar: Status to true for a status bar, false for none</li>
 * </ul>
 *
 * And the following variables are optional, if set they will be used, otherwise default
 * settings will be selected:
 *
 * <ul>
 * 	<li>$MCEcss: css file to be used by tinyMce</li>
 * 	<li>$MCEimage_advtab: set to <var>false</var> to disable the advanced image tab on the image insert popup.</li>
 * </ul>
 *
 * @author Stephen Billard (sbillard)
 */
$filehandler = zp_apply_filter('tinymce_zenpage_config', NULL);

if (isset($MCEcss)) {
	$MCEcss = getPlugin('tinymce/config/' . $MCEcss, true, true);
} else {
	$MCEcss = getPlugin('tinymce/config/content.css', true, true);
}


if (!getOption('tinymce_tinyzenpage')) {
	$MCEplugins = preg_replace('|\stinyzenpage|', '', $MCEplugins);
}
?>
<script type="text/javascript" src="<?php echo WEBPATH . "/" . ZENFOLDER . "/" . PLUGIN_FOLDER; ?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo WEBPATH . "/" . ZENFOLDER . "/" . PLUGIN_FOLDER; ?>/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo WEBPATH . "/" . ZENFOLDER; ?>/js/dirtyforms/tinymce.js" type="text/javascript"></script>

<script type="text/javascript">
// <!-- <![CDATA[
					tinymce.init({
					selector: "<?php echo $MCEselector; ?>",
									language: "<?php echo $locale; ?>",
									relative_urls: false,
<?php
if (!isset($MCEimage_advtab) || $MCEimage_advtab) {
	?>
						image_advtab: true,
	<?php
}
?>
					content_css: "<?php echo $MCEcss; ?>",
<?php
if ($filehandler) {
	?>
						elements : "<?php echo $filehandler; ?>",
										file_browser_callback : <?php echo $filehandler; ?>,
	<?php
}
?>
					plugins: ["<?php echo $MCEplugins; ?>"],
<?php
if (isset($MCEspecial)) {
	echo $MCEspecial . ',';
}
if (isset($MCEskin)) {
	?>
						skin: "<?php echo $MCEskin; ?>",
	<?php
}
if (empty($MCEtoolbars)) {
	?>
						toolbar: false,
	<?php
} else {
	foreach ($MCEtoolbars as $key => $toolbar) {
		?>
							toolbar<?php if (count($MCEtoolbars) > 1) echo $key; ?>: "<?php echo $toolbar; ?>",
		<?php
	}
}
?>

					statusbar: <?php echo ($MCEstatusbar) ? 'true' : 'false'; ?>,
									menubar: <?php echo ($MCEmenubar) ? 'true' : 'false'; ?>,
									setup: function(editor) {
									editor.on('blur', function(ed, e) {
									form = $(editor.getContainer()).closest('form');
													if (editor.isDirty()) {
									$(form).addClass('tinyDirty');
									} else {
									$(form).removeClass('tinyDirty');
									}
									});
									}


					});
					// ]]> -->
</script>
