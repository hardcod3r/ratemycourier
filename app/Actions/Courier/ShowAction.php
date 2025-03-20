<?php declare(strict_types=1);

namespace App\Actions\Courier;

use App\Repositories\CourierRepository;
use App\DTO\CourierDTO;
use App\Tasks\SendToQueueSingleTask;
class ShowAction
{
    public function __construct(private readonly CourierRepository $courierRepository) {}

    public function execute($filters): CourierDTO
    {
        $model = $this->courierRepository->getById($filters);
        app(SendToQueueSingleTask::class)->execute($model->id); // Send to queue
        return $model;
    }
}
