<?php

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

$GLOBALS['SiteConfiguration']['site']['columns'] += [
    'cookiepalIntegrationWebsiteId' => [
        'label' => CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':websiteId',
        'description' => CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':websiteId.description',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
];

$GLOBALS['SiteConfiguration']['site']['types']['0']['showitem'] .= ',
    --div--;' . CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tabName,
    --palette--;;cookiepalIntegrationInstallation,
    --palette--;;cookiepalIntegrationOptions,
    --palette--;;cookiepalIntegrationTagManager,
';

$GLOBALS['SiteConfiguration']['site']['palettes'] += [
    'cookiepalIntegrationInstallation' => [
        'label' => CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':installation',
        'showitem' => 'cookiepalIntegrationUrl, cookiepalIntegrationSiteId',
    ],
    'cookiepalIntegrationOptions' => [
        'label' => CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':options',
        'showitem' => 'cookiepalIntegrationOptions, --linebreak--',
    ],
    'cookiepalIntegrationTagManager' => [
        'label' => CookiePal\CookiePalIntegration\Extension::LANGUAGE_PATH_SITECONF . ':tagManager',
        'showitem' => 'cookiepalIntegrationWebsiteId',
    ],
];

if ((new TYPO3\CMS\Core\Information\Typo3Version())->getMajorVersion() < 12) {
    foreach ($GLOBALS['SiteConfiguration']['site']['columns']['cookiepalIntegrationOptions']['config']['items'] as &$item) {
        $item[0] = $item['label'];
        $item[1] = $item['value'];
        unset($item['label']);
        unset($item['value']);
    }
}
