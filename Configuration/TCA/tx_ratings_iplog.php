<?php
defined('TYPO3_MODE') || die('Access denied.');

$result = [
    'ctrl' => [
        'title'     => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_iplog',
        'label'     => 'reference',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate DESC',
        'iconfile'  =>  'EXT:ratings/Resources/Public/Icons/icon_tx_ratings_iplog.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'reference,crdate,ip'
    ],
    'columns' => [
        'reference' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_iplog.reference',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => '*',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'default' => ''
            ]
        ],
        'crdate' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_iplog.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'readOnly' => $tx_ratings_debug_mode_disabled,
                'default' => 0
            ]
        ],
        'ip' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_iplog.ip',
            'config' => [
                'type' => 'input',
                'size' => '22',
                'max' => '16',
                'eval' => 'trim',
                'default' => ''
            ]
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'reference, crdate, ip']
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ]
];

return $result;

