<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

$tx_ratings_sysconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ratings']);
$tx_ratings_debug_mode_disabled = !intval($tx_ratings_sysconf['debugMode']);


$GLOBALS['TCA']['tx_ratings_iplog'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_ratings_iplog']['ctrl'],
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
//	'palettes' => array (
//		'1' => array('showitem' => '')
//	)
);

unset($tx_ratings_sysconf);
unset($tx_ratings_debug_mode_disabled);

?>
