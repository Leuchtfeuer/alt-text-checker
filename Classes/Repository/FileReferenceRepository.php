<?php

declare(strict_types=1);

namespace Leuchtfeuer\AltTextChecker\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

class FileReferenceRepository
{

    private const string TABLE = 'sys_file_reference';

    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function findReferencesByFileUid(int $fileId): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);

        return $queryBuilder
            ->select('*')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid_local',
                    $queryBuilder->createNamedParameter($fileId,
                        Connection::PARAM_INT)
                ),
                $queryBuilder->expr()->eq('deleted', 0),
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function findReferenceByUid(int $refUid): array
    {
        $queryBuilder =
            $this->connectionPool->getQueryBuilderForTable(self::TABLE);

        return $queryBuilder
            ->select('*')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($refUid,
                        Connection::PARAM_INT)
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

}
