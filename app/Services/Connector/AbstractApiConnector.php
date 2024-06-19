<?php

namespace App\Services\Connector;

abstract class AbstractApiConnector
{
    protected array $connector;

    public function setConnector(array $connector): static
    {
        $this->connector = $connector;

        return $this;
    }

    abstract public static function label(): string;

    abstract public function create($record): array;

    abstract public function update($record, $params): array;

    abstract public function updateOrCreate($record, $uniqueFields): array;

    abstract public function getOnOfficeFields(): array;

    abstract public function uploadFileTmp($records): ?string;

    abstract public function uploadFile($records, $resourceId): ?string;

    abstract public function getRecord($filter, $resourceId): ?array;

    abstract public function createRelation(array $parentId, array $childId, string $relationType): array;
}
