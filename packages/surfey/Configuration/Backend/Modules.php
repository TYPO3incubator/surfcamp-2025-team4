<?php

/**
 * Definitions for modules provided by EXT:surfey
 */

use TYPO3Incubator\Surfey\Controller\ManagementController;

return [
    'system_surfey' => [
        'parent' => 'web',
        'access' => 'user',
        'path' => '/module/web/surfey',
        'iconIdentifier' => 'tx-surfey',
        'labels' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_module_surfey.xlf',
        'routes' => [
            '_default' => [
                'target' => ManagementController::class . '::handleRequest',
            ],
        ],
    ],
];
