<?php

namespace Netcreators\Ratings\Controller;

/***************************************************************
*  Copyright notice
*
*  (c) 2008 Dmitry Dulepov [netcreators] <dmitry@typo3.org>
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;


define('TX_RATINGS_MIN', 0);
define('TX_RATINGS_MAX', 100);

/**
 * Plugin 'Ratings' for the 'ratings' extension.
 *
 * @author	Dmitry Dulepov [netcreators] <dmitry@typo3.org>
 * @package	TYPO3
 * @subpackage	tx_ratings
 */
class RegisterPluginController extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
    /**
     * The backReference to the mother cObj object set at call time
     *
     * @var ContentObjectRenderer
     */
    public $cObj;

    /**
     * Should be same as classname of the plugin, used for CSS classes, variables
     *
     * @var string
     */
    public $prefixId = 'tx_ratings';

    /**
     * Should normally be set in the main function with the TypoScript content passed to the method.
     *
     * $conf['LOCAL_LANG'][_key_] is reserved for Local Language overrides.
     * $conf['CODE.']['10.']['userFunc'] reserved for setting up the USER / USER_INT object. See TSref where CODE is the code of the plugin
     *
     * @var array
     */
    public $conf = array();

    /**
    * The main method of the PlugIn
    *
    * @param string $content: The PlugIn content
    * @param array $conf: The PlugIn configuration
    * @return string The content that is displayed on the website
    */
    public function main($content, $conf) {
        $this->mergeConfiguration($conf);

        if (!isset($this->conf['storagePid'])) {
            $this->pi_loadLL();
            return $this->pi_wrapInBaseClass($this->pi_getLL('no_ts_template'));
        }

        /* @var $api tx_ratings_api */
        $api = GeneralUtility::makeInstance(\Netcreators\Ratings\Api\Api::class);

        // adds possibility to change ref and so use this plugin with other plugins and not only pages
        if ($conf['flexibleRef']) {
            $conf['ref'] = $this->cObj->cObjGetSingle($conf['flexibleRef'], $conf['flexibleRef.']);
        }

        $content.= $api->getRatingDisplay($conf['ref'] ? $this->cObj->stdWrap($conf['ref'], $conf['ref' . '.']) : 'pages_' . $GLOBALS['TSFE']->id, $this->conf);

        return $this->pi_wrapInBaseClass($content);
    }


    /**
    * Merges TS configuration with configuration from flexform (latter takes precedence).
    *
    * @param	array		$conf	Configuration from TS
    * @return	void
    */
    public function mergeConfiguration($conf) {
        $this->conf = $conf;

        $this->fetchConfigValue('storagePid');
        $this->conf['storagePid'] = intval($this->conf['storagePid']);
        if ($this->conf['storagePid'] == 0) {
            $this->conf['storagePid'] = $GLOBALS['TSFE']->id;
        }
        $this->fetchConfigValue('templateFile');
    }

    /**
    * Fetches configuration value from flexform. If value exists, value in
    * <code>$this->conf</code> is replaced with this value.
    *
    * @param	string		$param	Parameter name. If <code>.</code> is found, the first part is section name, second is key (applies only to $this->conf)
    * @return	void
    */
    public function fetchConfigValue($param) {
        $section = '';
        if (strchr($param, '.')) {
            list($section, $param) = explode('.', $param, 2);
        }
        $value = trim($this->pi_getFFvalue($this->cObj->data['pi_flexform'], $param, ($section ? 's' . ucfirst($section) : 'sDEF')));
        if (!is_null($value) && $value != '') {
            if ($section) {
                $this->conf[$section . '.'][$param] = $value;
            }
            else {
                $this->conf[$param] = $value;
            }
        }
    }
}


