<?php

/*
 * This file is part of the "Alternative Text Checker" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Dev <dev@Leuchtfeuer.com>, Leuchtfeuer Digital Marketing
 */

namespace Leuchtfeuer\AltTextChecker\ViewHelpers;

use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class HasAlternativeTextViewHelper extends AbstractViewHelper
{
    public function __construct(protected FileRepository $fileRepository) {}

    public function initializeArguments(): void
    {
        $this->registerArgument('refUid', 'int', 'Reference Uid', true);
        $this->registerArgument('tableName', 'string', 'Table name', true);
        $this->registerArgument('field', 'string', 'Content Element Uid', true);
    }

    public function render(): string
    {
        /** @var int refUid */
        $refUid = $this->arguments['refUid'];
        /** @var string $tableName */
        $tableName = $this->arguments['tableName'];
        /** @var string $field */
        $field = $this->arguments['field'];

        $references = $this->fileRepository->findByRelation($tableName, $field, $refUid);

        foreach ($references as $reference) {
            if (empty($reference->getAlternative())) {
                return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.no') ?? 'No';
            }
        }

        return LocalizationUtility::translate('LLL:EXT:alt_text_checker/Resources/Private/Language/locallang.xlf:alt_text.yes') ?? 'Yes';
    }
}
