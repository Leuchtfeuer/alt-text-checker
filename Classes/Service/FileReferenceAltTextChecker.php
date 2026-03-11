<?php

/*
 * This file is part of the "Kickstarter Website".
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\Service;

class FileReferenceAltTextChecker
{
    /**
     * @param array<int, array<string, mixed>> $fileReferences
     */
    public function hasAltText(array $fileReferences): bool
    {
        foreach ($fileReferences as $reference) {
            if ($reference['alternative'] === null) {
                return false;
            }
        }

        return true;
    }
}
