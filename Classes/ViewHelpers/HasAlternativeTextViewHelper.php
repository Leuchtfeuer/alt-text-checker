<?php

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
        $refUid = (int)$this->arguments['refUid'];

        $fileReferences = $this->fileReferenceRepository->findReferenceByUid($refUid);
        $getIfReferenceHasAltText = $this->fileReferenceAltTextChecker->hasAltText($fileReferences);

        if ($getIfReferenceHasAltText) {
            return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.yes') ?? 'Yes';
        }

        return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.no') ?? 'No';
    }
}
