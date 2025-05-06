<?php

/**
 * Definitions for modules provided by EXT:surfey
 */

use TYPO3Incubator\Surfey\Controller\ManagementController;

return [
    'web_surfey' => [
        'parent' => 'web',
        'access' => 'user',
        'path' => '/module/web/surfey',
        'iconIdentifier' => 'tx-surfey',
        'labels' => [
            'title' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:management.module.title',
            'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:management.module.description',
            'shortDescription' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_module.xlf:management.module.shortDescription',
        ],
        'routes' => [
            '_default' => [
                'target' => ManagementController::class . '::overviewAction',
            ],
        ],
    ],
];
