<?php
defined('TYPO3_MODE') || die('Access denied.');

$listType = 'ratings';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$listType] = 'layout,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$listType] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($listType, 'FILE:EXT:ratings/Configuration/FlexForms/flexform_ds.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tt_content.list_type',
        $listType,
        'EXT:ratings/ext_icon.gif'
    ],
    'list_type',
    'ratings'
);

