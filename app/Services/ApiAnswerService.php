<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiAnswerService
{
    /**
     * @param array $data
     * @param int $statusCode
     * @param string|null $partialErrorMessage
     * @param int|null $partialErrorCode
     * @return JsonResponse
     */
    public static function success(
        array   $data = [],
        int     $statusCode = Response::HTTP_OK,
        ?string $partialErrorMessage = null,
        ?int    $partialErrorCode = null
    ): JsonResponse
    {
        $data = [
            'successful' => true,
            'data' => $data,
        ];

        if (isset($partialErrorMessage)) {
            $data['partialError']['message'] = $partialErrorMessage;
            $data['partialError']['code'] = $partialErrorCode;
        }

        return self::response($data, $statusCode);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function response(array $data = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function successMessage($message, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return self::response([
            'successful' => true,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function failure(array $data = [], int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return self::response(
            [
                'successful' => false,
                'data' => $data,
            ],
            $statusCode
        );
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function failureMessage($message, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return self::response(
            [
                'successful' => false,
                'message' => $message,
            ],
            $statusCode
        );
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function notFound(string $message = '', int $statusCode = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return self::response([
            'successful' => false,
            'message' => $message
        ], $statusCode);
    }

}
