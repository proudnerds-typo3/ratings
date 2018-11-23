<?php

defined('TYPO3_MODE') or die('Access denied.');

$tx_ratings_sysconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ratings']);
$tx_ratings_debug_mode_disabled = is_array($tx_ratings_sysconf) && !intval($tx_ratings_sysconf['debugMode']);

$GLOBALS['TCA']['tx_ratings_data']['ctrl']['hideTable'] = $tx_ratings_debug_mode_disabled;
$GLOBALS['TCA']['tx_ratings_data']['ctrl']['readOnly']  = $tx_ratings_debug_mode_disabled;

