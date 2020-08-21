<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    $extensionConfiguration = '';

    if (
        defined('TYPO3_version') &&
        version_compare(TYPO3_version, '9.0.0', '>=')
    ) {
        $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
        )->get('ratings');
    } else { // before TYPO3 9
        $extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ratings']);
    }

    $tx_ratings_debug_mode_disabled = is_array($extensionConfiguration) && !intval($extensionConfiguration['debugMode']);

    $GLOBALS['TCA']['tx_ratings_data']['ctrl']['hideTable'] = $tx_ratings_debug_mode_disabled;
    $GLOBALS['TCA']['tx_ratings_data']['ctrl']['readOnly']  = $tx_ratings_debug_mode_disabled;
});

