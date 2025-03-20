<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CourierShowRequest;
use App\Http\Requests\Api\ListCouriersRequest;
use App\Http\Controllers\Api\ApiController;
use App\Actions\Courier\GetAllAction;
use App\Actions\Courier\ShowAction;
use Illuminate\Http\JsonResponse;

class CourierController extends ApiController
{
    public function __construct(private readonly GetAllAction $getAllAction, private readonly ShowAction $showAction)
    {

    }

    public function index(ListCouriersRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $couriers = $this->getAllAction->execute($filters);
        return $this->paginatedResponse($couriers, "Couriers retrieved successfully.");
    }

    public function show(CourierShowRequest $request): JsonResponse
    {
        $courier = $this->showAction->execute($request->id);
        return $this->successResponse("Courier retrieved successfully.", $courier);
    }
}
