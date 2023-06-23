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
    public function __construct(
        private readonly ExchangeRequestsService $exchangeService,
        private readonly IExchangeRequestsRepository $exchangeRepository,
        private readonly CommissionService $commissionService
    )
    {
    }

    public function index(): JsonResponse
    {
        try {
            $exchangeRequests = $this->exchangeRepository->getAllAvailableRequests();

            return ApiAnswerService::success(
                $exchangeRequests
                    ->map(function ($exchangeRequest) {
                        $exchangeRequest = $this->commissionService
                            ->addCommissionToExchangeRequest($exchangeRequest, auth()->id());

                        return ExchangeRequestDTO::fromModel($exchangeRequest)->toArray();
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
                ExchangeRequestDTO::fromModel($exchangeRequest)->toArray()
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
                ExchangeRequestDTO::fromModel($exchangeRequest)->toArray()
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
                ExchangeRequestDTO::fromModel($exchangeRequest)->toArray()
            );
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }
}
