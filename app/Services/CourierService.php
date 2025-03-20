<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Courier;
use App\Actions\Courier\GetAllAction;

class CourierService
{
    public function getAllCouriers(array $filters): array
    {
        return app(GetAllAction::class)->execute($filters);
    }

    public function getCourierById(int $id): object
    {
        return Courier::withCount(['likes', 'dislikes'])->withSum(['views', 'list_views', 'detail_views'])->findOrFail($id);
    }
}
