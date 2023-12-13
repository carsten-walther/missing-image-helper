<?php

namespace CarstenWalther\MissingImageHelper\Event\Listener;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class RemoveFromHtaccessEventListener
{
    public function __invoke(\TYPO3\CMS\Core\Package\Event\AfterPackageDeactivationEvent $event): void
    {
        $htaccessFile = Environment::getProjectPath() . DIRECTORY_SEPARATOR . '.htaccess';

        if (file_exists($htaccessFile)) {

            $htaccessContent = GeneralUtility::getUrl($htaccessFile);
            $htaccessContentToRemove = <<<END
########################################################################################################################
# Rewrites missing images
########################################################################################################################

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
    RewriteRule \.(gif|jpe?g|png|bmp|svg)$ /typo3conf/ext/missing_image_helper/Resources/Public/test.jpg [NC,L,R=303]
</IfModule>

END;
            $htaccessContent = str_replace($htaccessContentToRemove, '', $htaccessContent);

            GeneralUtility::writeFile($htaccessFile, $htaccessContent);
        }
    }
}
