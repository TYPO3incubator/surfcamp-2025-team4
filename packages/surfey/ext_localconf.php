<?php

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][] = [
    'nodeName' => 'surfeyEditor',
    'priority' => 30,
    'class' => \TYPO3Incubator\Surfey\Form\SurfeyEditorElement::class,
];
