<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Courier;
use App\Traits\Paginatable;
use App\DTO\CourierDTO;
use App\Exceptions\CourierListException;
use App\Exceptions\InvalidCourierException;
class CourierRepository
{
    use Paginatable;

    public function getAllWithFilters(array $filters): array
    {
        try{
            $paginated = Courier::withCounts()
            ->filter($filters)
            ->paginate($filters['per_page'] ?? config('demo.per_page'));
          return $this->paginateWithDTO($paginated, fn($courier) => CourierDTO::fromModel($courier));
        } catch (CourierListException $e) {
            throw new CourierListException(
                message: $e->getMessage(),
                statusCode: $e->getCode()
            );
        }

    }

    public function getById(string $id): CourierDTO
    {
        try{
            $courier = Courier::withCounts()
            ->withSum('list_views', 'views')
            ->withSum('detail_views', 'views')
            ->withSum('views', 'views')->findOrFail($id);
            return CourierDTO::fromModel($courier);
        } catch (InvalidCourierException $e) {
            throw new InvalidCourierException(
                message: $e->getMessage(),
                statusCode: $e->getCode()
            );
        }
    }
}
