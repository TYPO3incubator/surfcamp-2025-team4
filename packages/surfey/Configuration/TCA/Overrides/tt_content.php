<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');

ExtensionManagementUtility::addRecordType(
    [
        'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tt_content.CType.surfey.title',
        'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tt_content.CType.surfey.description',
        'value' => 'surfey',
        'icon' => 'tx-surfey',
        'group' => 'default',
    ],
    '
    --palette--;;general,
        header,
        bodytext,
        tx_surfey_definition,
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
        'tx_surfey_definition' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tt_content.columns.tx_surfey_definition.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_surfey_definition',
                'foreign_table_where' => 'ORDER BY tx_surfey_definition.title',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
    ]
);

$GLOBALS['TCA']['tt_content']['columns']['tx_surfey_definition']['displayCond'] = 'FIELD:CType:=:surfey';
