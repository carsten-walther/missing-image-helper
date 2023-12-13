<?php

use CarstenWalther\MissingImageHelper\Event\HtaccessManipulationEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][ImageService::class] = [
    'className' => \CarstenWalther\MissingImageHelper\Service\ImageService::class,
];
