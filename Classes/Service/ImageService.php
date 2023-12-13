<?php

namespace CarstenWalther\MissingImageHelper\Service;

use GeorgRinger\News\Domain\Model\FileReference;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImageService extends \TYPO3\CMS\Extbase\Service\ImageService
{
    /**
     * @param string $src
     * @param $image
     * @param bool $treatIdAsReference
     * @return FileInterface
     */
    public function getImage(string $src, $image, bool $treatIdAsReference): FileInterface
    {
        try {
            $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
            $configuration = $extensionConfiguration->get('missing_image_helper');

            if ($src !== '' && Environment::getContext()->isDevelopment() && (bool)$configuration['useInDevelopmentContext']) {

                $pathinfo = pathinfo(Environment::getProjectPath() . DIRECTORY_SEPARATOR . $src);
                if (array_key_exists($pathinfo['extension'], $configuration['replacementPath']) && !file_exists($pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['basename'])) {
                    $src = $configuration['replacementPath'][$pathinfo['extension']];
                    $image = NULL;
                    $treatIdAsReference = false;
                }
            }

            if (!is_null($image) && Environment::getContext()->isDevelopment() && (bool)$configuration['useInDevelopmentContext']) {

                $publicUrl = $image instanceof FileReference ? $image->getOriginalResource()->getPublicUrl() : $image->getPublicUrl();

                $pathinfo = pathinfo(Environment::getProjectPath() . $publicUrl);
                if (array_key_exists($pathinfo['extension'], $configuration['replacementPath']) && !file_exists($pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['basename'])) {
                    $src = $configuration['replacementPath'][$pathinfo['extension']];
                    $image = NULL;
                    $treatIdAsReference = false;
                }
            }

        } catch (\Exception $exception) {
            // do nothing
        }

        return parent::getImage($src, $image, $treatIdAsReference);
    }
}
