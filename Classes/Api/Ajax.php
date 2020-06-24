<?php

namespace Netcreators\Ratings\Api;

/***************************************************************
*  Copyright notice
*
*  (c) 2007 Dmitry Dulepov (dmitry@typo3.org)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Comment management script.
 */
class Ajax {
    protected $ref;
    protected $pid;
    protected $rating;
    protected $conf;

    /**
    * Initializes the class
    *
    */
    public function __construct()
    {
        $data_str = GeneralUtility::_GP('data');
        $data = unserialize(base64_decode($data_str));
        $tsfe = $this->getTypoScriptFrontendController();
        $tsfe->readLLfile('EXT:ratings/Resources/Private/Language/locallang_ajax.xlf');

        // Sanity check
        $this->rating = GeneralUtility::_GP('rating');
        if (!MathUtility::canBeInterpretedAsInteger($this->rating)) {
            echo $tsfe->getLL('bad_rating_value');
            exit;
        }
        $this->ref = GeneralUtility::_GP('ref');
        if (trim($this->ref) == '') {
            echo $tsfe->getLL('bad_ref_value');
            exit;
        }
        $check = GeneralUtility::_GP('check');
        if (md5($this->ref . $this->rating . $data_str . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']) != $check) {
            echo $tsfe->getLL('wrong_check_value');
            exit;
        }
        $this->conf = $data['conf'];
        if (!is_array($this->conf)) {
            echo $tsfe->getLL('bad_conf_value');
            exit;
        }
        $this->pid = $data['pid'];
        if (!MathUtility::canBeInterpretedAsInteger($this->pid)) {
            echo $tsfe->getLL('bad_pid_value');
            exit;
        }
    }

    /**
    * Main processing function of eID script
    *
    * @return	void
    */
    public function main()
    {
        $this->updateRating();
    }

    /**
    * Updates rating data and outputs new result
    *
    * @return	void
    */
    protected function updateRating()
    {
        $api = GeneralUtility::makeInstance(\Netcreators\Ratings\Api\Api::class);
        $databaseHandle = $this->getDatabaseConnection();

        if ($this->conf['disableIpCheck'] || !$api->isVoted($this->ref)) {

            // Do everything inside transaction
            $databaseHandle->sql_query('START TRANSACTION');
            $dataWhere = 'pid=' . intval($this->conf['storagePid']) .
                        ' AND reference=' . $databaseHandle->fullQuoteStr($this->ref, 'tx_ratings_data') .
                        $api->enableFields('tx_ratings_data');
            list($row) = $databaseHandle->exec_SELECTgetRows('COUNT(*) AS t',
                    'tx_ratings_data', $dataWhere);
            if ($row['t'] > 0) {
                $databaseHandle->exec_UPDATEquery(
                    'tx_ratings_data',
                    $dataWhere,
                    array(
                        'vote_count' => 'vote_count+1',
                        'rating' => 'rating+' . intval($this->rating),
                        'tstamp' => time(),
                    ), 'vote_count,rating');
            }
            else {
                $databaseHandle->exec_INSERTquery(
                    'tx_ratings_data',
                    array(
                        'pid' => $this->conf['storagePid'],
                        'crdate' => time(),
                        'tstamp' => time(),
                        'reference' => $this->ref,
                        'vote_count' => 1,
                        'rating' => $this->rating,
                    )
                );
            }
            // Call hook if ratings is updated
            if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ratings']['updateRatings'])) {
                foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ratings']['updateRatings'] as $userFunc) {
                    $params = array(
                        'pObj' => &$this,
                        'pid' => $this->pid,
                        'ref' => $this->ref,
                    );
                    GeneralUtility::callUserFunction($userFunc, $params, $this);
                }
            }

            $databaseHandle->exec_INSERTquery(
                'tx_ratings_iplog',
                array(
                    'pid' => $this->conf['storagePid'],
                    'crdate' => time(),
                    'tstamp' => time(),
                    'reference' => $this->ref,
                    'ip' => $api->getCurrentIp(),
                )
            );
            $databaseHandle->sql_query('COMMIT');
        }

        // Get rating display
        $this->conf['mode'] = 'static';
        echo $api->getRatingDisplay($this->ref, $this->conf);
    }

    /**
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}


