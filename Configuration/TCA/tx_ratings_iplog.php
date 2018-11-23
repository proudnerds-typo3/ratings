<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

$result = array (

    'ctrl' => array (
        'title'     => 'LLL:EXT:ratings/locallang_db.xml:tx_ratings_iplog',
        'label'     => 'reference',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate DESC',
        'iconfile'          => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('ratings').'icon_tx_ratings_iplog.gif'
    ),
    'interface' => array (
        'showRecordFieldList' => 'reference,crdate,ip'
    ),
    'columns' => array (
        'reference' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/locallang_db.xml:tx_ratings_iplog.reference',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => '*',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            )
        ),
        'crdate' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/locallang_db.xml:tx_ratings_iplog.crdate',
            'config' => array (
                'type' => 'input',
                'size' => '22',
                'max' => '16',
                'eval' => 'datetime',
                'readOnly' => $tx_ratings_debug_mode_disabled,
            )
        ),
        'ip' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:ratings/locallang_db.xml:tx_ratings_iplog.ip',
            'config' => array (
                'type' => 'input',
                'size' => '22',
                'max' => '16',
                'eval' => 'trim',
            )
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'reference;;;;1-1-1, crdate, ip')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);


return $result;

