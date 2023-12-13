<?php

use TYPO3\CMS\Extbase\Service\ImageService;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][ImageService::class] = [
    'className' => \CarstenWalther\MissingImageHelper\Service\ImageService::class,
];
