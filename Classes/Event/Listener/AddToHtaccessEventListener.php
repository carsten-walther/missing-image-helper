<?php

namespace CarstenWalther\MissingImageHelper\Event\Listener;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class AddToHtaccessEventListener
{
    public function __invoke(\TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent $event): void
    {
        $htaccessFile = Environment::getProjectPath() . DIRECTORY_SEPARATOR . '.htaccess';

        if (file_exists($htaccessFile)) {

            $htaccessContent[] = <<<END
########################################################################################################################
# Rewrites missing images
########################################################################################################################

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
    RewriteRule \.(gif|jpe?g|png|bmp|svg)$ /typo3conf/ext/missing_image_helper/Resources/Public/test.jpg [NC,L,R=303]
</IfModule>

END;

            $htaccessContent[] = GeneralUtility::getUrl($htaccessFile);

            GeneralUtility::writeFile($htaccessFile, implode('', $htaccessContent));
        }
    }
}
