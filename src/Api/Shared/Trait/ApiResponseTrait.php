<?php

declare(strict_types=1);

namespace App\Api\Shared\Trait;

use App\Api\Shared\Dto\ApiErrorResponse;
use App\Api\Shared\Dto\ApiSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    /**
     * @param $message
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    protected function apiError($message, $data = [], ?int $status = 400)
    {
        return (new ApiErrorResponse($message, $data, $status))();
    }

    /**
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    protected function apiSuccess($data = [], ?int $status = 200, $extraHeaders = [])
    {
        return (new ApiSuccessResponse($data, $status, $extraHeaders))();
    }

    /**
     * @param $message
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    protected function apiResponse($message, $data = [], ?int $status = 200, $extraHeaders = [])
    {
        $status = $status ?? Response::HTTP_OK;
        $mainStatus = substr((string)$status, 0, 1);
        $stringStatus = in_array($mainStatus, [4,5]) ? 'error' : 'success';

        $response = new JsonResponse([
            'status' => $stringStatus,
            'message' => $message,
            'data' => $data,
        ], $status);

        $response->headers->add($extraHeaders);

        return $response;
    }
}
