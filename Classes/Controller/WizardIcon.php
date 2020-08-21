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


namespace Netcreators\Ratings\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Class that adds the wizard icon.
 *
 * @category    Plugin
 * @package     TYPO3
 * @subpackage  ratings
 * @author      Franz Holzinger <franz@ttproducts.de>
 * @copyright   Causal Sàrl
 * @license     http://www.gnu.org/copyleft/gpl.html
 */
class WizardIcon
{
    /**
     * Processes the wizard items array.
     *
     * @param array $wizardItems The wizard items
     * @return array Modified array with wizard items
     */
    public function proc(array $wizardItems)
    {
        $wizardIcon = 'Resources/Public/Icons/PluginWizard.png';
        $languageFile = 'Resources/Private/Language/locallang.xlf';
        $params = '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=ratings_pi';

        $wizardItem = [
            'title' => $GLOBALS['LANG']->sL('LLL:EXT:ratings/' . $languageFile . ':plugins_title'),
            'description' => $GLOBALS['LANG']->sL('LLL:EXT:ratings/' . $languageFile . ':plugins_description'),
            'params' => $params
        ];

        if (version_compare(TYPO3_version, '7.5', '>=')) {
            $iconIdentifier = 'extensions-ratings-wizard';
            /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
            $iconRegistry = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Imaging\\IconRegistry');
            $iconRegistry->registerIcon(
                $iconIdentifier,
                'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\BitmapIconProvider',
                [
                    'source' => 'EXT:ratings/' . $wizardIcon,
                ]
            );
            $wizardItem['iconIdentifier'] = $iconIdentifier;
        } else {
            $wizardItem['icon'] = ExtensionManagementUtility::extRelPath('ratings') . $wizardIcon;
        }

        $wizardItems['plugins_tx_ratings'] = $wizardItem;

        return $wizardItems;
    }
}

