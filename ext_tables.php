<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ratings_data');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ratings_iplog');

if (TYPO3_MODE=='BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_ratings_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ratings') . 'pi1/class.tx_ratings_pi1_wizicon.php';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ratings', 'Configuration/TypoScript/', 'Ratings');

