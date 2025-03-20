<?php declare(strict_types=1);

namespace App\DTO;

class CourierDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public int $likes,
        public int $dislikes,
        public int $views,
        public int $list_views,
        public int $detail_views,
        public string $created_at
    ) {}

    public static function fromModel($courier): self
    {
        return new self(
            id: $courier->id,
            name: $courier->name,
            description: $courier->description,
            likes: (int) $courier->likes_count,
            dislikes: (int) $courier->dislikes_count,
            views: (int) $courier->views_sum_views,
            list_views: (int) $courier->list_views_sum_views,
            detail_views: (int) $courier->detail_views_sum_views,
            created_at: $courier->created_at->format('Y-m-d')
        );
    }
}
