<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'CookiePal Integration',
    'description' => 'CookiePal integration for TYPO3',
    'category' => 'fe',
    'author' => 'CookiePal',
    'author_email' => 'support@cookiepal.io',
    'state' => 'stable',
    'version' => '2.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-13.4.99',
            'php' => '8.1.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\MatomoIntegration\\' => 'Classes']
    ],
];
