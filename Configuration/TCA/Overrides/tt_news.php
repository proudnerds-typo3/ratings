<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('tt_news')) {
        $table = 'tt_news';

        // New columns
        $tempColumns = [
            'tx_ratings_enable' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:' . $table . '.tx_ratings_enable',
                'config' => [
                    'type'     => 'check',
                    'items'    => [
                        ['', '']
                    ],
                    'default'  => '1'
                ]
            ]
        ];

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns($table, $tempColumns, 1);
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes($table, 'tx_ratings_enable');
    }
});

