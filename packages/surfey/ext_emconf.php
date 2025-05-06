<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Surfey',
    'description' => 'Create, manage, and analyze surfeys with ease in TYPO3.',
    'category' => 'module',
    'author' => 'TYPO3 Surfcamp Team 4',
    'author_email' => 'typo3cms@typo3.org',
    'state' => 'beta',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => []
    ],
    'autoload' => [
        'psr-4' => [
            'TYPO3Incubator\\Surfey\\' => 'Classes/',
        ]
    ]
];
