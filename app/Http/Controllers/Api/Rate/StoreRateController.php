<?php

namespace App\Http\Controllers\Api\Rate;



use App\Http\Requests\Api\Rate\RateStoreRequest;
use App\Services\RateService;
use App\Http\Controllers\Api\ApiController;

class StoreRateController extends ApiController
{
    /**
     * Handle the incoming request.
     */

    public function __construct(private RateService $rateService)
    {}
    public function __invoke(RateStoreRequest $request)
    {
        $rate = $this->rateService->storeRate($request->validated());
        return $this->successResponse('Rate stored successfully', $rate, 201);
    }
}
