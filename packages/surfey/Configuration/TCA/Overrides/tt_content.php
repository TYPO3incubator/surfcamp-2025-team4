<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');

ExtensionManagementUtility::addRecordType(
    [
        'label' => 'Survey',
        'description' => 'Survey Content Element',
        'value' => 'surfey',
        'icon' => 'surfey-survey-icon',
        'group' => 'default',
    ],
    '
    --palette--;;general,
        header,
        bodytext,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;;hidden
        '
    ,
    [
        'columnsOverrides' => [
            'bodytext' => [
                'config' => [
                    'enableRichtext' => true,
                ],
            ],
        ],
    ],
);

