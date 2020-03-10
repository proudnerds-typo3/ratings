<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * Plugin 'Ratings' for the 'ratings' extension.
 *
 * @author	Dmitry Dulepov [netcreators] <dmitry@typo3.org>
 * @package	TYPO3
 * @subpackage	tx_ratings
 */
class tx_ratings {
    public $cObj;

    public function main($content, $conf) {
        $pibaseObj = GeneralUtility::makeInstance(\Netcreators\Ratings\Controller\RegisterPluginController::class);
        $pibaseObj->cObj = $this->cObj;
        $content = $pibaseObj->main($content, $conf);

        return $content;
    }
}


if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ratings/class.tx_ratings.php'])	{
    /** @noinspection PhpIncludeInspection */
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/ratings/class.tx_ratings.php']);
}

