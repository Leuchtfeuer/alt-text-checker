<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\EventListener;

use Leuchtfeuer\AltTextChecker\Repository\FileReferenceRepository;
use Leuchtfeuer\AltTextChecker\Service\FileReferenceAltTextChecker;
use TYPO3\CMS\Core\Imaging\Event\ModifyIconForResourcePropertiesEvent;
use TYPO3\CMS\Core\Resource\File;

/**
 * This event listener listens to PSR-14 events given in TYPO3 10 and above.
 */
class AltTextCheckerEventListener
{
    public function __construct(protected FileReferenceAltTextChecker $fileReferenceAltTextChecker, protected FileReferenceRepository $fileReferenceRepository) {}
    /**
     * "Alternative Text Checker": Adds a warning icon to indicate that a file
     * or some of its references do not have alternative text (Alt-Text) set.
     *
     * @param ModifyIconForResourcePropertiesEvent $event
     */
    public function onFileModuleSetWarningIconForMissingAltText(ModifyIconForResourcePropertiesEvent $event): void
    {
        $file = $event->getResource();

        if (!$file instanceof File) {
            return;
        }

        $fileAlternativeText = $file->getProperty('alternative');

        $fileReferences = $this->fileReferenceRepository->findReferencesByFile($file);
        $getIfReferencesHaveAltText = $this->fileReferenceAltTextChecker->hasAltText($fileReferences);

        if (empty($fileAlternativeText) || !$getIfReferencesHaveAltText) {
            $event->setOverlayIdentifier('overlay-warning');
        }

    }

}
