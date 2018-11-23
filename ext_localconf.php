<?php
defined('TYPO3_MODE') or die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43('ratings', 'Classes/Controller/RegisterPluginController.php', '_pi1', 'list_type', false);

// eID
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['tx_ratings_ajax'] = 'EXT:ratings/Resources/Public/Scripts/Php/EidRunner.php';

// Extra markers hook for tt_news
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tt_news']['extraItemMarkerHook']['ratings'] = \Netcreators\Ratings\Hooks\TtNews::class;

