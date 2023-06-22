<?php

namespace App\Http\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ApiAnswerService;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Src\Users\Aggregators\UserInfoAggregator;

class UserInfoController extends Controller
{
    public function show(UserInfoAggregator $aggregator): JsonResponse
    {
        try {
            $data = $aggregator->getData(Auth::id());

            return ApiAnswerService::success($data->toArray());
        } catch (Exception $e) {
            return ApiAnswerService::failureMessage($e->getMessage());
        }
    }
}
