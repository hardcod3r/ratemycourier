<?php

namespace App\Http\Controllers\Api\Rate;

use App\Http\Controllers\Controller;
use App\Services\RateService;
use App\Http\Requests\Api\Rate\RateDestroyRequest;
use App\Http\Controllers\Api\ApiController;
class DeleteRateController extends ApiController
{
    /**
     * Handle the incoming request.
     */
    public function __construct(private RateService $rateService)
    {}
    public function __invoke(RateDestroyRequest $request)
    {
        $this->rateService->deleteRate($request->validated());
        return $this->noContentResponse(204);
    }
}
