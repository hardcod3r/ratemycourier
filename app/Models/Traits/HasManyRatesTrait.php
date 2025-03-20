<?php  declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Rate;
use App\Enums\RateType;
use Illuminate\Database\Eloquent\Relations\HasMany;
trait HasManyRatesTrait
{
    /**
     * Get the rates for the model.
     */
    public function rates() : HasMany
    {
        return $this->hasMany(Rate::class);
    }

    //likes Rate with Type::Like
    public function likes() : HasMany
    {
        return $this->rates()->where('rate', RateType::Like);
    }

    //dislikes Rate with Type::Dislike

    public function dislikes() : HasMany
    {
        return $this->rates()->where('rate', RateType::Dislike);
    }
}
