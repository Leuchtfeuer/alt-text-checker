<?php

/*
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\ViewHelpers;

use Leuchtfeuer\AltTextChecker\Repository\FileReferenceRepository;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HasAlternativeTextViewHelper extends AbstractViewHelper
{
    public function __construct(protected FileRepository $fileRepository) {}
    public function initializeArguments(): void
    {
        $this->registerArgument('contentUid', 'int', 'Content Element Uid', true);
    }

    public function render(): string
    {
        /** @var int $contentUid */
        $contentUid = $this->arguments['contentUid'];
        $references = $this->fileRepository->findByRelation('tt_content', 'image', $contentUid);

        foreach ($references as $reference) {
            if (empty($reference->getAlternative())) {
                return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.no') ?? 'No';
            }
        }

        return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.yes') ?? 'Yes';
    }
}
