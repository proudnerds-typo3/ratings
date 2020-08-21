<?php

namespace Netcreators\Ratings\Eid;


class AjaxStarter {

    public function run ()
    {
        \JambageCom\Div2007\Utility\FrontendUtility::init();

        $eIDutility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Utility\EidUtility::class);
        $eIDutility->initTCA();

            // Make instance and call main():
        /** @var Ajax $SOBE */
        $SOBE = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Netcreators\Ratings\Api\Ajax::class);

        $result = $SOBE->main();
    }
}
