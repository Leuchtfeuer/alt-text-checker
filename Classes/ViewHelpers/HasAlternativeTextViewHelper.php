<?php

/*
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\ViewHelpers;

use Leuchtfeuer\AltTextChecker\Repository\FileReferenceRepository;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HasAlternativeTextViewHelper extends AbstractViewHelper
{
    public function __construct(protected FileReferenceRepository $fileReferenceRepository, protected ResourceFactory $resourceFactory, protected PageRepository $pageRepository) {}
    public function initializeArguments(): void
    {
        $this->registerArgument('refUid', 'int', 'File Reference Uid', true);
    }

    public function render(): string
    {
        /** @var int $refUid */
        $refUid = $this->arguments['refUid'];

        $fileReference = $this->resourceFactory->getFileReferenceObject($refUid);
        $altText = $fileReference->getAlternative();

        if (empty($altText)) {
            $overlay = $this->pageRepository->getLanguageOverlay(FileReferenceRepository::TABLE, $fileReference->getProperties());
            $altText = $overlay['alternative'] ?? '';
        }

        if (!empty($altText)) {
            return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.yes') ?? 'Yes';
        }

        return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.no') ?? 'No';
    }
}
