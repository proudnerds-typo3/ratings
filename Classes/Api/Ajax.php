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
            echo $tsfe->getLL('bad_pid_value') . ' "' . htmlspecialchars($this->pid) . '"');
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
        $tableName = 'tx_ratings_data';
        $connection = $api->getConnectionForTable($tableName);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->setRestrictions(GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer::class)
        );
        
        if ($this->conf['disableIpCheck'] || !$api->isVoted($this->ref)) {
            try {
                // Do everything inside transaction
                $connection->beginTransaction();
                $statement = $queryBuilder
                    ->count('*')
                    ->from($tableName)
                    ->where(
                        $queryBuilder->expr()->eq(
                            'reference',
                            $queryBuilder->createNamedParameter(
                                $this->ref,
                                \PDO::PARAM_STR
                            )
                        )
                    );
                
                if ($this->conf['storagePid']) {
                    $statement->andWhere(
                        $queryBuilder->expr()->eq(
                            'pid',
                            $queryBuilder->createNamedParameter(
                                $this->conf['storagePid'],
                                \PDO::PARAM_INT
                            )
                        )
                    );
                }
                
                $count = $statement
                    ->execute()
                    ->fetchColumn(0);

                if ($count > 0) {
                    $queryBuilde->update($tableName)
                        ->set(
                            'vote_count',
                            queryBuilder->expr()->sum(
                                'vote_count',
                                $queryBuilder->createNamedParameter(
                                    1,
                                    \PDO::PARAM_INT
                                )
                            )
                        )
                        ->set(
                            'rating',
                            queryBuilder->expr()->sum(
                                'rating',
                                $queryBuilder->createNamedParameter(
                                    intval($this->rating),
                                    \PDO::PARAM_INT
                                )
                            )
                        )
                        ->set(
                            'tstamp',
                            time()
                        )
                        ->execute();
                } else {
                    $affectedRows = $queryBuilder
                        ->insert($tableName)
                        ->values([
                            'pid' => intval($this->conf['storagePid']),
                            'crdate' => time(),
                            'tstamp' => time(),
                            'reference' => $this->ref,
                            'vote_count' => 1,
                            'rating' => $this->rating,
                        ])
                        ->execute();
                }
                // Call hook if ratings is updated
                if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ratings']['updateRatings'])) {
                    foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ratings']['updateRatings'] as $userFunc) {
                        $params = [
                            'pObj' => &$this,
                            'pid' => $this->pid,
                            'ref' => $this->ref,
                        ];
                        GeneralUtility::callUserFunction($userFunc, $params, $this);
                    }
                }

                $tableName = 'tx_ratings_iplog';
                $queryBuilder = $api->getQueryBuilder($tableName);
                $affectedRows = $queryBuilder
                    ->insert($tableName)
                    ->values([
                        'pid' => intval($this->conf['storagePid']),
                        'crdate' => time(),
                        'tstamp' => time(),
                        'reference' => $this->ref,
                        'ip' => $api->getCurrentIp(),
                    ])
                    ->execute();
            }
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw $e;
        }

        // Get rating display
        $this->conf['mode'] = 'static';
        echo $api->getRatingDisplay($this->ref, $this->conf);
    }

    /**
     * @return TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}


