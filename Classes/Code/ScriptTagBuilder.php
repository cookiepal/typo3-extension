<?php

declare(strict_types=1);

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace CookiePal\CookiePalIntegration\Code;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Domain\ConsumableString;

/**
 * @internal
 */
class ScriptTagBuilder
{
    private ServerRequestInterface $request;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * Build the script tag with optional attributes
     */
    public function build(string $code): string
    {
        $attributes = [];

        $attributes = \array_map(static function (string $name, string $value): string {
            if ($value === '') {
                return $name;
            }
            return $name . '="' . \htmlspecialchars($value) . '"';
        }, \array_keys($attributes), \array_values($attributes));

        $prepend = '';
        if ($attributes !== []) {
            $prepend = ' ';
        }

        return '<script' . $prepend . \implode(' ', $attributes) . '>' . $code . '</script>';
    }
}
