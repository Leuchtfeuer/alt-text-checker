<?php

declare(strict_types=1);

/*
 * This file is part of the "Alternative Text Checker" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) Dev <dev@Leuchtfeuer.com>, Leuchtfeuer Digital Marketing
 */

namespace Leuchtfeuer\AltTextChecker\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\File;

class FileReferenceRepository
{
    private const string TABLE = 'sys_file_reference';

    public function __construct(private readonly ConnectionPool $connectionPool) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findReferencesByFile(File $file): array
    {
        $fileUid = $file->getUid();
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);

        return $queryBuilder
            ->select('uid')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid_local',
                    $queryBuilder->createNamedParameter(
                        $fileUid,
                        Connection::PARAM_INT
                    )
                ),
                $queryBuilder->expr()->eq('deleted', 0),
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
