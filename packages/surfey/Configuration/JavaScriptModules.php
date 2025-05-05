<?php

return [
    'dependencies' => [
        'backend',
        'core'
    ],
    'tags' => [
        'backend.module',
    ],
    'imports' => [
        '@typo3incubator/surfey/' => 'EXT:surfey/Resources/Public/JavaScript/',
    ],
];
