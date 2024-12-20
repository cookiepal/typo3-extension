<?php

declare(strict_types=1);

/*
 * This file is part of the "cookiepal_integration_v4" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace CookiePal\CookiePalIntegration\Entity;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
final class Configuration
{
    private const SITE_CONFIGURATION_PREFIX = 'cookiepalIntegration';
    
    public string $websiteId = '';

    private function __construct() {}

    /**
     * @param array<string,bool|int|string> $siteConfiguration
     */
    public static function createFromSiteConfiguration(array $siteConfiguration): self
    {
        $configuration = new self();
        foreach ($siteConfiguration as $name => $value) {
            if (! \str_starts_with($name, self::SITE_CONFIGURATION_PREFIX)) {
                continue;
            }

            self::processConfiguration($configuration, $name, $value);
        }

        return $configuration;
    }

    /**
     * @param bool|int|string $value
     */
    private static function processConfiguration(self $configuration, string $name, $value): void
    {
        $property = self::mapConfigurationNameToClassProperty($name);
        if ($property === 'options') {
            self::processOptions($configuration, (string)$value);
            return;
        }

        if (! \property_exists(self::class, $property)) {
            return;
        }

        self::setConfiguration($configuration, $property, $value);
    }

    private static function mapConfigurationNameToClassProperty(string $name): string
    {
        return \lcfirst(\substr($name, \strlen(self::SITE_CONFIGURATION_PREFIX)));
    }

    private static function processOptions(self $configuration, string $commaDelimitedOptions): void
    {
        $options = GeneralUtility::trimExplode(',', $commaDelimitedOptions, true);
        foreach ($options as $option) {
            self::setConfiguration($configuration, $option, true);
        }
    }

    /**
     * @param bool|int|string $value
     */
    private static function setConfiguration(self $configuration, string $property, $value): void
    {
        $type = self::getTypeForProperty($property);
        if ($type === 'string') {
            $configuration->{$property} = (string)$value;
            return;
        }
        if ($type === 'int') {
            $configuration->{$property} = (int)$value;
            return;
        }
        if ($type === 'bool') {
            $configuration->{$property} = (bool)$value;
            return;
        }
        if ($type === 'array') {
            if (\is_string($value)) {
                $value = GeneralUtility::trimExplode(',', $value, true);
            }
            $configuration->{$property} = $value;
        }
    }

    private static function getTypeForProperty(string $property): string
    {
        try {
            $type = (new \ReflectionProperty(self::class, $property))->getType();
            if (! $type instanceof \ReflectionNamedType) {
                return '';
            }
            if (! $type->isBuiltin()) {
                return '';
            }

            return $type->getName();
        } catch (\ReflectionException) {
        }

        return '';
    }
}
