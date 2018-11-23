<?php

defined('TYPO3_MODE') or die('Access denied.');

/** @var \Netcreators\Ratings\Eid\AjaxStarter $eid */
$eid = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netcreators\\Ratings\\Eid\\AjaxStarter');
echo $eid->run();

