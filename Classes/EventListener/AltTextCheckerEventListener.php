<?php

declare(strict_types=1);

/*
 * This file is part of the "Secure Downloads" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Dev <dev@Leuchtfeuer.com>, Leuchtfeuer Digital Marketing
 */

namespace Leuchtfeuer\AltTextChecker\EventListener;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Imaging\Event\ModifyIconForResourcePropertiesEvent;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This event listener listens to PSR-14 events given in TYPO3 10 and above.
 */
class AltTextCheckerEventListener
{
    /**
     * Adds a warning icon to indicate that some file references
     * do not have alternative text (Alt-Text) set.
     *
     * @param ModifyIconForResourcePropertiesEvent $event
     */
    public function onFileModuleSetWarningIconForMissingAltText(ModifyIconForResourcePropertiesEvent $event): void
    {
        $resource = $event->getResource();


        if (!$resource instanceof File) {
            return;
        }

        $fileAlternativeText = $resource->getProperty('alternative');

        if (!$fileAlternativeText) {
            $event->setOverlayIdentifier('overlay-warning');
        }
    }


}
