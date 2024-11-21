<?php

declare(strict_types=1);

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace CookiePal\CookiePalIntegration\Code;

use CookiePal\CookiePalIntegration\Entity\Configuration;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
class JavaScriptTrackingCodeBuilder
{
    private ServerRequestInterface $request;
    private Configuration $configuration;
    /**
     * @var list<JavaScriptCode>
     */
    private array $trackingCodeParts = [];

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}

    public function setRequest(ServerRequestInterface $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setConfiguration(Configuration $configuration): self
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getTrackingCode(): string
    {
        $this->addBanner();

        return \implode('', $this->trackingCodeParts);
    }

    private function addBanner(): void
    {
       
        $this->trackingCodeParts[] = new JavaScriptCode(
            '(function(){'
            . \sprintf('var u="%s%s";', "https://cdn.cookiepal.io/client_data/", $this->configuration->websiteId)
            . 'var d=document,g=d.createElement("script"),s=d.getElementsByTagName("script")[0];'
            . 'g.async=true;g.src=u+"/script.js";s.parentNode.insertBefore(g,s);'
            . '})();',
        );
    }
}
