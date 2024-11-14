<?php

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

$GLOBALS['SiteConfiguration']['site']['columns'] += [
    'matomoIntegrationTagManagerContainerIds' => [
        'label' => Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tagManagerContainerIds',
        'description' => Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tagManagerContainerIds.description',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
];

$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',
    --div--;' . Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tabName,
    --palette--;;matomoIntegrationInstallation,
    --palette--;;matomoIntegrationOptions,
    --palette--;;matomoIntegrationTagManager,
';

$GLOBALS['SiteConfiguration']['site']['palettes'] += [
    'matomoIntegrationInstallation' => [
        'label' => Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':installation',
        'showitem' => 'matomoIntegrationUrl, matomoIntegrationSiteId',
    ],
    'matomoIntegrationOptions' => [
        'label' => Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':options',
        'showitem' => 'matomoIntegrationOptions, --linebreak--, matomoIntegrationErrorPagesTemplate',
    ],
    'matomoIntegrationTagManager' => [
        'label' => Brotkrueml\MatomoIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tagManager',
        'showitem' => 'matomoIntegrationTagManagerContainerIds, matomoIntegrationTagManagerDebugMode',
    ],
];

if ((new TYPO3\CMS\Core\Information\Typo3Version())->getMajorVersion() < 12) {
    foreach ($GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationOptions']['config']['items'] as &$item) {
        $item[0] = $item['label'];
        $item[1] = $item['value'];
        unset($item['label']);
        unset($item['value']);
    }

    $GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0][0]
        = $GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0]['label'];
    $GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0][1]
        = $GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0]['value'];
    unset($GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0]['label']);
    unset($GLOBALS['SiteConfiguration']['site']['columns']['matomoIntegrationTagManagerDebugMode']['config']['items'][0]['value']);
}
