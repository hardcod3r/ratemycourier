<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Rate;

use App\Exceptions\Rate\StoreRateException;
use App\Exceptions\Rate\UpdateRateException;
use App\Exceptions\Rate\DeleteRateException;
use App\Exceptions\Rate\GetUserRateException;
use App\DTO\RateDTO;
class RateService
{
    public function storeRate(array $data): RateDTO
    {
        try {
            $model = Rate::updateOrCreate(
                ['user_id' => $data['user_id'], 'courier_id' => $data['courier_id']],
                ['rate' => $data['rate']]
            );
            return RateDTO::fromArray($model->toArray());
        } catch (\Exception $e) {
            throw new StoreRateException();
        }
    }

    public function updateRate(array $data): RateDTO
    {
        try {
            $rate = Rate::findOrFail($data['id'])->where('user_id', $data['user_id'])->first();
            $rate->update([
                'rate' => $data['rate']
            ]);
            return  RateDTO::fromArray($rate->toArray());
        } catch (\Exception $e) {
            throw new UpdateRateException();
        }
    }

    public function deleteRate($data): void
    {
        try {
            $rate = Rate::findOrFail($data['id'])->where('user_id', $data['user_id'])->first();
            $rate->delete();
        } catch (\Exception $e) {
            throw new DeleteRateException();
        }
    }

    //getuser rate for a courier
    public function getUserRate($data): RateDTO
    {
       try{
        $model =  Rate::where('user_id', $data['user_id'])->where('courier_id', $data['courier_id'])->first()->toArray();
        return  RateDTO::fromArray($model);
       }catch(\Exception $e){
           throw new GetUserRateException();
       }
    }
}
