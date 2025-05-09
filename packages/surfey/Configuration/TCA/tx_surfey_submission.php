<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_submission.title',
        'label' => 'surfey',
        'crdate' => 'crdate',
        'tstamp' => 'tstamp',
        'groupName' => 'system',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'default_sortby' => 'crdate',
        'delete' => 'deleted',
        'typeicon_classes' => [
            'default' => 'tx-surfey',
        ],
        'enablecolumns' => [
            'disabled' => 'disabled',
        ],
        'rootLevel' => 1,
        'readOnly' => true,
        'hideTable' => true,
    ],
    'types' => [
        '1' => [
            'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                surfey,hash,data,participant,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                disabled,
        '],
    ],
    'palettes' => [
        'language' => ['showitem' => 'sys_language_uid, l10n_parent'],
    ],
    'columns' => [
        'surfey' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_submission.columns.surfey.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_surfey_definition',
            ],
        ],
        'hash' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_submission.columns.hash.label',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'data' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_submission.columns.data.label',
            'config' => [
                'type' => 'json',
                'default' => '{}',
                'readOnly' => true,
            ]
        ],
        'participant' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_surfey_submission.columns.participant.label',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_surfey_participation',
            ]
        ]
    ],
];
