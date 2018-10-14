<?php

/**
 * Used to set the mod_rewrite option.
 * This script is accessed via a /page/setup_set-mod_rewrite?z=setup.
 * It will not be found unless mod_rewrite is working.
 *
 * @author Stephen Billard (sbillard)
 *
 * @package setup
 *
 */
require_once('setup-functions.php');
require_once(dirname(dirname(__FILE__)) . '/functions-basic.php');

zp_session_start();
$optionMutex = new zpMutex('oP', $_GET['limit']);
$optionMutex->lock();

list($usec, $sec) = explode(" ", microtime());
$start = (float) $usec + (float) $sec;

$fullLog = defined('TEST_RELEASE') && TEST_RELEASE || strpos(getOption('markRelease_state'), '-DEBUG') !== false;

setupLog(sprintf(gettext('Mod_rewrite setup started')), $fullLog);

$mod_rewrite = MOD_REWRITE;
if (is_null($mod_rewrite)) {
	$msg = gettext('The option “mod_rewrite” will be set to “enabled”.');
	setOption('mod_rewrite', 1);
} else if ($mod_rewrite) {
	$msg = gettext('The option “mod_rewrite” is “enabled”.');
} else {
	$msg = gettext('The option “mod_rewrite” is “disabled”.');
}
setOption('mod_rewrite_detected', 1);
setupLog(gettext('Notice: “Module mod_rewrite” is working.') . ' ' . $msg, $fullLog);

list($usec, $sec) = explode(" ", microtime());
$last = (float) $usec + (float) $sec;
/* and record that we finished */
setupLog(sprintf(gettext('Mod_rewrite setup completed in %1$.4f seconds'), $last - $start), $fullLog);

sendImage(false, 'mod_rewrite');
$optionMutex->unlock();
exitZP();
?>