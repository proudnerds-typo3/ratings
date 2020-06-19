<?php
defined('TYPO3_MODE') || die('Access denied.');

// New columns
$tempColumns = [
    'tx_ratings_enable' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tt_news.tx_ratings_enable',
        'config' => [
            'type'     => 'check',
            'items'    => [
                ['', '']
            ],
            'default'  => '1'
        ]
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_news', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_news', 'tx_ratings_enable');

