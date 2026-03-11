<?php

namespace Leuchtfeuer\AltTextChecker\Service;

class FileReferenceAltTextChecker
{

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
