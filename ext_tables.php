<?php
if (!defined ('TYPO3_MODE')) die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ratings_data');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ratings_iplog');

if (
    TYPO3_MODE == 'BE'
) {
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['Netcreators\\Ratings\\Controller\\Plugin\\WizardIcon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ratings') . 'Classes/Controller/WizardIcon.php';
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ratings', 'Configuration/TypoScript/', 'Ratings');

