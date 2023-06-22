<?php

namespace App\Http\ExchangeRequests\Controllers;

use App\Http\ExchangeRequests\Requests\CreateExchangeRequest;
use App\Services\ApiAnswerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Src\ExchangeRequests\DTO\CreateExchangeRequestDTO;
use Src\ExchangeRequests\DTO\ExchangeRequestDTO;
use Src\ExchangeRequests\Resources\ExchangeRequestsService;

class ExchangeRequestsController
{
    public function __construct(
        private readonly ExchangeRequestsService $exchangeService
    )
    {
    }

    public function index()
    {

    }

    public function create(CreateExchangeRequest $request): JsonResponse
    {
        try {
            $exchangeRequest = $this->exchangeService->create(
                CreateExchangeRequestDTO::fromRequest($request, auth()->id())
            );

            return ApiAnswerService::success(
                ExchangeRequestDTO::fromModel($exchangeRequest)->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }

    public function applyExchange()
    {

    }
}
