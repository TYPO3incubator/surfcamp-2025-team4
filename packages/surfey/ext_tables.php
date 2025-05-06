<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('Access denied.');

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'tx_survey_definition',
    '',
    'after:bodytext'
);
