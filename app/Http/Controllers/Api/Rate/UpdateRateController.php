<?php

namespace App\Http\Controllers\Api\Rate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rate\RateUpdateRequest;
use App\Services\RateService;
use App\Http\Controllers\Api\ApiController;

class UpdateRateController extends ApiController
{
    public function __construct(private RateService $rateService)
    {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(RateUpdateRequest $request)
    {
        $rate = $this->rateService->updateRate($request->validated());
        return $this->successResponse('Rate updated successfully', $rate, 200);
    }
}
