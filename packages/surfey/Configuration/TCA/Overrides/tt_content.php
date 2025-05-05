<?php
defined('TYPO3') or die('Access denied.');

call_user_func(function () {
    $GLOBALS['TCA']['tt_content']['types']['surfey_survey'] = [
        'showitem' => '
        --palette--;;general,
        header,
        bodytext,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
        --palette--;;hidden
    ',
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            'Survey',
            'surfey_survey',
            'surfey-survey-icon',
        ],
        'textmedia',
        'after'
    );

    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['surfey_survey'] = 'surfey-survey-icon';
});
