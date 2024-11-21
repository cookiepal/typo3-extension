<?php

declare(strict_types=1);

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace CookiePal\CookiePalIntegration\Hooks\PageRenderer;

use CookiePal\CookiePalIntegration\Code\JavaScriptTrackingCodeBuilder;
use CookiePal\CookiePalIntegration\Code\ScriptTagBuilder;
use CookiePal\CookiePalIntegration\Entity\Configuration;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Site\Entity\Site;

/**
 * @internal
 */
final class TrackingCodeInjector
{
    public function __construct(
        private readonly JavaScriptTrackingCodeBuilder $javaScriptTrackingCodeBuilder,
        private readonly ScriptTagBuilder $scriptTagBuilder,
    ) {}

    /**
     * @param array{}|null $params
     */
    public function execute(?array &$params, PageRenderer $pageRenderer): void
    {
        $request = $this->getRequest();
        if ($request->getAttribute('applicationType') !== 1) {
            // Not a frontend request
            return;
        }

        /** @var Site $site */
        $site = $request->getAttribute('site');
        $configuration = Configuration::createFromSiteConfiguration($site->getConfiguration());

        if (! $this->hasValidConfiguration($configuration)) {
            return;
        }

        $this->javaScriptTrackingCodeBuilder
            ->setRequest($request)
            ->setConfiguration($configuration);
        $this->scriptTagBuilder->setRequest($request);

        $scriptCode = $this->javaScriptTrackingCodeBuilder->getTrackingCode();

        $pageRenderer->addHeaderData($this->scriptTagBuilder->build($scriptCode));
    }

    private function hasValidConfiguration(Configuration $configuration): bool
    {
        return true;
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
