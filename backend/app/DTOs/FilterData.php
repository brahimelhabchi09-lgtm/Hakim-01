<?php

namespace App\DTOs;

class FilterData
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?int $categoryId = null,
        public readonly ?int $marqueId = null,
        public readonly ?float $minPrice = null,
        public readonly ?float $maxPrice = null,
        public readonly ?string $sort = null,
        public readonly int $page = 1,
        public readonly int $perPage = 12,
    ) {}

    public static function fromRequest(array $query): self
    {
        return new self(
            $query['search'] ?? null,
            isset($query['category_id']) ? (int) $query['category_id'] : null,
            isset($query['marque_id']) ? (int) $query['marque_id'] : null,
            isset($query['min_price']) ? (float) $query['min_price'] : null,
            isset($query['max_price']) ? (float) $query['max_price'] : null,
            $query['sort'] ?? null,
            (int) ($query['page'] ?? 1),
            (int) ($query['per_page'] ?? 12),
        );
    }
}
