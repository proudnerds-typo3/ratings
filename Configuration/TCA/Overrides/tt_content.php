<?php
defined('TYPO3_MODE') or die('Access denied.');


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['ratings' . '_pi1'] = 'layout,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['ratings' . '_pi1'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('ratings' . '_pi1', 'FILE:EXT:ratings/Configuration/FlexForms/flexform_ds.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tt_content.list_type_pi1',
        'ratings',
        'EXT:ratings/ext_icon.gif'
    ),
    'list_type',
    'ratings'
);

