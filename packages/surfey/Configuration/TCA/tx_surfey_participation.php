<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_participation.title',
        'label' => 'surfey',
        'crdate' => 'crdate',
        'tstamp' => 'tstamp',
        'groupName' => 'system',
        'default_sortby' => 'crdate',
        'delete' => 'deleted',
        'typeicon_classes' => [
            'default' => 'tx-surfey',
        ],
        'enablecolumns' => [
            'disabled' => 'disabled',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                surfey,identifier,fe_user,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                disabled,
        '],
    ],
    'columns' => [
        'surfey' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_participation.columns.surfey.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_surfey_definition',
            ],
        ],
        'identifier' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_participation.columns.identifier.label',
            'config' => [
                'type' => 'uuid',
            ],
        ],
        'fe_user' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_participation.columns.fe_user.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
            ],
        ]
    ],
];
