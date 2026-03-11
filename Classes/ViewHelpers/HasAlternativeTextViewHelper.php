<?php

/*
 * This file is part of the "Kickstarter Website".
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\ViewHelpers;

use Leuchtfeuer\AltTextChecker\Repository\FileReferenceRepository;
use Leuchtfeuer\AltTextChecker\Service\FileReferenceAltTextChecker;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HasAlternativeTextViewHelper extends AbstractViewHelper
{
    public function __construct(protected FileReferenceAltTextChecker $fileReferenceAltTextChecker, protected FileReferenceRepository $fileReferenceRepository) {}
    public function initializeArguments(): void
    {
        $this->registerArgument('refUid', 'int', 'File Reference Uid', true);
    }

    public function render(): string
    {
        /** @var int $refUid */
        $refUid = $this->arguments['refUid'];

        $fileReferences = $this->fileReferenceRepository->findReferenceByUid($refUid);
        $getIfReferenceHasAltText = $this->fileReferenceAltTextChecker->hasAltText($fileReferences);

        if ($getIfReferenceHasAltText) {
            return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.yes') ?? 'Yes';
        }

        return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.no') ?? 'No';
    }
}
