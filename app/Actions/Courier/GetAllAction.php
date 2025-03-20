<?php declare(strict_types=1);

namespace App\Actions\Courier;
use App\Tasks\SendToQueueArrayTask;

use App\Repositories\CourierRepository;

class GetAllAction
{
    public function __construct(private readonly CourierRepository $courierRepository) {}

    public function execute($filters): array
    {
        $models =  $this->courierRepository->getAllWithFilters($filters);
        app(SendToQueueArrayTask::class)->execute($models['data']); // Send to queue
        return $models;
    }
}
