<?php

declare(strict_types=1);

/*
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Leuchtfeuer Digital Marketing <dev@Leuchtfeuer.com>
 */

namespace Leuchtfeuer\AltTextChecker\Tests\Unit\Service;

use Leuchtfeuer\AltTextChecker\Service\FileReferenceAltTextChecker;
use PHPUnit\Framework\TestCase;

class FileReferenceAltTextCheckerTest extends TestCase
{
    private FileReferenceAltTextChecker $subject;

    protected function setUp(): void
    {
        $this->subject = new FileReferenceAltTextChecker();
    }

    public function testReturnsTrueWhenAllReferencesHaveAltText(): void
    {
        $references = [
            ['alternative' => 'Some alt text'],
            ['alternative' => 'Another alt text'],
        ];

        self::assertTrue($this->subject->hasAltText($references));
    }

    public function testReturnsFalseWhenOneReferenceHasNullAltText(): void
    {
        $references = [
            ['alternative' => 'Some alt text'],
            ['alternative' => null],
        ];

        self::assertFalse($this->subject->hasAltText($references));
    }

    public function testReturnsFalseWhenAllReferencesHaveNullAltText(): void
    {
        $references = [
            ['alternative' => null],
            ['alternative' => null],
        ];

        self::assertFalse($this->subject->hasAltText($references));
    }

    public function testReturnsTrueWhenReferencesArrayIsEmpty(): void
    {
        self::assertTrue($this->subject->hasAltText([]));
    }
}
