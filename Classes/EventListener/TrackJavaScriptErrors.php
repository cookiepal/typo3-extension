<?php

declare(strict_types=1);

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\MatomoIntegration\EventListener;

use Brotkrueml\MatomoIntegration\Event\AfterTrackPageViewEvent;

/**
 * @internal
 */
final class TrackJavaScriptErrors
{
    public function __invoke(AfterTrackPageViewEvent $event): void
    {
        if ($event->getConfiguration()->trackJavaScriptErrors) {
            $event->addMatomoMethodCall('enableJSErrorTracking');
        }
    }
}
