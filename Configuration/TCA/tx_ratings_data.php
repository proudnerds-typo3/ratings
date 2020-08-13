<?php
defined('TYPO3_MODE') || die('Access denied.');

$result = [
    'ctrl' => [
        'title'     => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data',
        'label'     => 'reference',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete'    => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'default_sortby' => 'ORDER BY crdate DESC',
        'iconfile'  =>  'EXT:ratings/Resources/Public/Icons/icon_tx_ratings_data.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'reference,rating,vote_count'
    ],
    'columns' => [
        'crdate' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'readOnly' => $tx_ratings_debug_mode_disabled,
                'default' => 0
            ]
        ],
        'hidden' => [
            'label'  => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check'
            ]
        ],
        'reference' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.reference',
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
        'rating' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.rating',
            'config' => [
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'range' => [
                    'lower' => '1',
                    'upper' => '1000',
                ],
                'default' => 0,
                'slider' => [
                    'step' => 10,
                    'width' => 200,
                ],
            ]
        ],
        'vote_count' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.vote_count',
            'config' => [
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'range' => [
                    'lower' => '1',
                    'upper' => '1000',
                ],
                'default' => 0,
                'slider' => [
                    'step' => 10,
                    'width' => 200,
                ],
            ]
        ],
    ],

    'types' => [
        '0' => ['showitem' => 'hidden, crdate, reference, rating, vote_count']
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ]
];

return $result;

