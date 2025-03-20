<?php declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RateType;

trait CourierScopes
{
    public function scopeWithCounts(Builder $query): Builder
    {
        return $query->withCount(['likes', 'dislikes', 'views']);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
        ->with('views')
        ->withSum('views', 'views')
        ->withSum('detail_views', 'views')
        ->withSum('list_views', 'views')
        ->when($filters['name'] ?? null, fn($q, $title) => $q->where('name', 'like', "%{$title}%"))
        ->when($filters['min_likes'] ?? null, fn($q, $min) => $q->where('likes_count', '>=', $min)->where('type', RateType::Like))
        ->when($filters['min_dislikes'] ?? null, fn($q, $min) => $q->where('dislikes_count', '>=', $min)->where('type', RateType::Dislike))
        ->when($filters['min_views'] ?? null, function ($q, $min) {
            return $q->having('views_sum_views', '>=', $min); // Χρήση του aggregated sum
        })
        ->when($filters['created_at'] ?? null, fn($q, $date) => $q->whereDate('created_at', $date))
        ->when(
            isset($filters['order_by']),
            function ($q) use ($filters) {
                $allowedColumns = ['name', 'likes_count', 'dislikes_count', 'views_sum_views', 'created_at'];
                $orderBy = in_array($filters['order_by'], $allowedColumns) ? $filters['order_by'] : 'created_at';
                $order = (isset($filters['order']) && in_array(strtolower($filters['order']), ['asc', 'desc'])) ? strtolower($filters['order']) : 'desc';
                return $q->orderBy($orderBy, $order);
            }
        );



    }
}
