<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

$tx_ratings_sysconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ratings']);
$tx_ratings_debug_mode_disabled = !intval($tx_ratings_sysconf['debugMode']);


unset($tx_ratings_sysconf);
unset($tx_ratings_debug_mode_disabled);

?>
