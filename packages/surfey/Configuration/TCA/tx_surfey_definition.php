<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.title',
        'label' => 'title',
        'descriptionColumn' => 'description',
        'crdate' => 'crdate',
        'tstamp' => 'tstamp',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'groupName' => 'content',
        'editlock' => 'editlock',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'default_sortby' => 'crdate',
        'delete' => 'deleted',
        'typeicon_classes' => [
            'default' => 'tx-surfey',
        ],
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'searchFields' => 'title',
    ],
    'types' => [
        '1' => [
            'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                title,definition,random_order,--palette--;;private,notifications,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                hidden,--palette--;;timeRestriction,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                description,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        '],
    ],
    'palettes' => [
        'timeRestriction' => [
            'showitem' => 'starttime, endtime, --linebreak--, fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel, --linebreak--,editlock'
        ],
        'language' => ['showitem' => 'sys_language_uid, l10n_parent'],
        'private' => ['showitem' => 'private_survey, single_submission'],
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.title.label',
            'config' => [
                'type' => 'input',
                'required' => true,
                'eval' => 'trim',
            ],
        ],
        'definition' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.definition.label',
            'config' => [
                'type' => 'json',
                'renderType' => 'surfeyEditor',
                'default' => '{}',
                'readOnly' => true,
            ],
        ],
        'random_order' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.random_order.label',
            'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.random_order.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ]
        ],
        'private_survey' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.private_survey.label',
            'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.private_survey.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ]
        ],
        'single_submission' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.single_submission.label',
            'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.single_submission.description',
            'displayCond' => 'FIELD:private_survey:!=:0',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ]
        ],
        'notifications' => [
            'label' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.notifications.label',
            'description' => 'LLL:EXT:surfey/Resources/Private/Language/locallang_tca.xlf:tx_survey_definition.columns.notifications.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ]
        ],
    ],
];
