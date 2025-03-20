<?php

namespace App\Http\Controllers\Api\Rate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rate\GetUserRateByCourierRequest;
use App\Services\RateService;
use App\Http\Controllers\Api\ApiController;
class GetUserRateByCourier extends ApiController
{
    public function __construct(private RateService $rateService)
    {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetUserRateByCourierRequest $request)
    {
        $rate = $this->rateService->getUserRate($request->validated());
        return $this->successResponse('Rate fetched successfully.', $rate);
    }
}
