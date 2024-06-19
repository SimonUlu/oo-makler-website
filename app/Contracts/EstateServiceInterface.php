<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EstateServiceInterface
{
    /**
     * Get all estates
     */
    public static function getAllEstates();

    /**
     * Get filtered estates
     */
    public static function getFilteredEstates(string $collectionName, array $filter, int $perPage = 10, string $sortField = 'kaufpreis', string $sortDirection = 'asc', int $page = 1): LengthAwarePaginator;

    /**
     * Get estates for map view.
     */
    public static function getEstatesForMap(array $filter): Collection;

    /**
     * Get locations of all estates.
     */
    public static function getLocationsOfAllEstates(): array;

    /**
     * Get unpaginated estates.
     */
    public static function getEstatesUnpaginated(array $filter, int $perPage = 15, string $sortField = 'kaufpreis', string $sortDirection = 'asc', string $collectionName = 'estate_entries'): Collection;
}
