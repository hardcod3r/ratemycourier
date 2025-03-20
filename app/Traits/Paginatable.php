<?php declare(strict_types=1);

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait Paginatable
{
    /**
     * Μετατρέπει τα δεδομένα σε DTO και επιστρέφει paginated response
     *
     * @param LengthAwarePaginator $paginated
     * @param callable $transformer
     * @return array
     */
    public function paginateWithDTO(LengthAwarePaginator $paginated, callable $transformer): array
    {
        return [
            'data' => collect($paginated->items())->map($transformer),
            'pagination' => [
                'total' => $paginated->total(),
                'per_page' => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'next_page_url' => $paginated->nextPageUrl(),
                'prev_page_url' => $paginated->previousPageUrl(),
            ],
        ];
    }
}
