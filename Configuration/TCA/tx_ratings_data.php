<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

$result = array (
    'ctrl' => array (
        'title'     => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data',
        'label'     => 'reference',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate DESC',
        'iconfile'  =>  'EXT:ratings/Resources/Public/Icons/icon_tx_ratings_data.gif'
    ),
    'interface' => array (
        'showRecordFieldList' => 'reference,rating,vote_count'
    ),
    'columns' => array (
        'reference' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.reference',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => '*',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            )
        ),
        'rating' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.rating',
            'config' => array (
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'range' => array (
                    'upper' => '1000',
                    'lower' => '1'
                ),
                'default' => 0
            )
        ),
        'vote_count' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/Resources/Private/Language/locallang_tca.xlf:tx_ratings_data.vote_count',
            'config' => array (
                'type' => 'input',
                'size' => '4',
                'max' => '4',
                'eval' => 'int',
                'checkbox' => '0',
                'range' => array (
                    'upper' => '1000',
                    'lower' => '1'
                ),
                'default' => 0
            )
        ),
    ),

    'types' => array (
        '0' => array('showitem' => 'reference;;;;1-1-1, rating, vote_count')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);

return $result;

