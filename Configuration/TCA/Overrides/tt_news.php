<?php
defined('TYPO3_MODE') or die('Access denied.');

// New columns
$tempColumns = array (
    'tx_ratings_enable' => Array (
        'exclude' => 1,
        'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tt_news.tx_ratings_enable',
        'config' => array (
            'type'     => 'check',
            'items'    => array(
                array('', '')
            ),
            'default'  => '1'
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_news', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_news', 'tx_ratings_enable;;;;1-1-1');

