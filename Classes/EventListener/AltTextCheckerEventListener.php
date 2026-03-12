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
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Imaging\Event\ModifyIconForResourcePropertiesEvent;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;

/**
 * This event listener listens to PSR-14 events given in TYPO3 10 and above.
 */
class AltTextCheckerEventListener
{
    public function __construct(protected FileReferenceRepository $fileReferenceRepository, protected FileRepository $fileRepository, protected ResourceFactory $resourceFactory, protected PageRepository $pageRepository) {}
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

        if (empty($fileAlternativeText) || !$this->hasAltText($fileReferences)) {
            $event->setOverlayIdentifier('overlay-warning');
        }

    }

    /**
     * @param array<int, array<string, mixed>> $fileReferences
     * @return bool
     */
    public function hasAltText(array $fileReferences): bool
    {
        foreach ($fileReferences as $reference) {
            /** @var int $refUid */
            $refUid = $reference['uid'];
            $fileReference = $this->resourceFactory->getFileReferenceObject($refUid);
            $altText = $fileReference->getAlternative();

            if (empty($altText)) {
                return false;
            }
        }

        return true;
    }

}
