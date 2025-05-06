<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');

ExtensionManagementUtility::addRecordType(
    [
        'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:element.surfey.title',
        'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:element.surfey.description',
        'value' => 'surfey',
        'icon' => 'tx-surfey',
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


ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'tx_survey_definition' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.title',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_surfey_definition',
                'foreign_table_where' => 'ORDER BY tx_surfey_definition.title',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    ]
);
