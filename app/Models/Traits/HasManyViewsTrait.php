<?php declare(strict_types=1);

namespace App\Models\Traits;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AggregatedView;
use App\Enums\ViewType;

trait HasManyViewsTrait
{
    public function views(): HasMany
    {
        return $this->hasMany(AggregatedView::class);
    }
   //get list views
   public function list_views() : HasMany
   {
         return $this->views()
              ->where('type', ViewType::List);
   }

   //get detail views
    public function detail_views() : HasMany
    {
        return $this->views()
            ->where('type', ViewType::Detail);
    }

    public function getTotalViewsAttribute() : int
    {
        return $this->views()->sum('views');
    }




    public function getMonthlyViewsAttribute() : int
    {
        return $this->views()
            ->whereBetween('view_date', [now()->subMonth()->toDateString(), now()->toDateString()])
            ->sum('views');
    }
}
