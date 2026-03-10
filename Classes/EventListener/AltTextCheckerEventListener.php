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
     * "Alternative Text Checker": Adds a warning icon to indicate that a file
     * or some of its references do not have alternative text (Alt-Text) set.
     *
     * @param ModifyIconForResourcePropertiesEvent $event
     */
    public function onFileModuleSetWarningIconForMissingAltText(ModifyIconForResourcePropertiesEvent $event): void
    {
        $resource = $event->getResource();


        if (!$resource instanceof File) {
            return;
        }

        $fileUid = $resource->getUid();
        $fileAlternativeText = $resource->getProperty('alternative');

        if (!$fileAlternativeText || $this->referencesHaveMissingAltText($fileUid)) {
            $event->setOverlayIdentifier('overlay-warning');
        }
    }
    private function referencesHaveMissingAltText(int $fileId): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_file_reference');

        $count = $queryBuilder
            ->count('uid')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq('uid_local',
                    $queryBuilder->createNamedParameter($fileId, Connection::PARAM_INT)),
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->isNull('alternative'),
                    $queryBuilder->expr()->eq('alternative',
                        $queryBuilder->createNamedParameter(''))
                )
            )
            ->executeQuery()
            ->fetchOne();

        return $count > 0;
    }

}
