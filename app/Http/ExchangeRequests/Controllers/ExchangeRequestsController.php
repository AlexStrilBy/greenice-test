<?php

namespace App\Http\ExchangeRequests\Controllers;

use App\Http\ExchangeRequests\Requests\CreateExchangeRequest;
use App\Models\ExchangeRequest;
use App\Services\ApiAnswerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Src\ExchangeRequests\DTO\CreateExchangeRequestDTO;
use Src\ExchangeRequests\DTO\ExchangeRequestDTO;
use Src\ExchangeRequests\Repositories\IExchangeRequestsRepository;
use Src\ExchangeRequests\Resources\CommissionService;
use Src\ExchangeRequests\Resources\ExchangeRequestsService;

class ExchangeRequestsController
{
    private readonly int $userId;

    public function __construct(
        private readonly ExchangeRequestsService $exchangeService,
        private readonly IExchangeRequestsRepository $exchangeRepository,
    )
    {
        $this->userId = auth()->id();
    }

    public function index(): JsonResponse
    {
        try {
            $exchangeRequests = $this->exchangeRepository->getAllAvailableRequests();

            return ApiAnswerService::success(
                $exchangeRequests
                    ->map(function (ExchangeRequest $exchangeRequest) {
                        return ExchangeRequestDTO::fromModel($exchangeRequest, $this->userId)->toArray();
                    })
                    ->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }

    public function create(CreateExchangeRequest $request): JsonResponse
    {
        try {
            $exchangeRequest = $this->exchangeService->create(
                CreateExchangeRequestDTO::fromRequest($request, auth()->id())
            );

            return ApiAnswerService::success(
                ExchangeRequestDTO::fromModel($exchangeRequest, $this->userId)->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }

    public function applyExchange(ExchangeRequest $exchangeRequest): JsonResponse
    {
        try {
            $exchangeRequest = $this->exchangeService->applyExchange($exchangeRequest, auth()->id());

            return ApiAnswerService::success(
                ExchangeRequestDTO::fromModel($exchangeRequest, $this->userId)->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $exchangeRequest = $this->exchangeService->closeExchange($id, auth()->id());

            return ApiAnswerService::success(
                ExchangeRequestDTO::fromModel($exchangeRequest, $this->userId)->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }
}
