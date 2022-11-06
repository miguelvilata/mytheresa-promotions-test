<?php
declare(strict_types=1);

namespace App\Api\Shared\Dto;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiErrorResponse
{
    private $response;

    public function __construct($message, $data = [], ?int $status = 400)
    {
        $mainStatus = substr((string)$status, 0, 1);
        $stringStatus = in_array($mainStatus, [4,5]) ? 'error' : 'success';

        $this->response = new JsonResponse([
            'status' => $stringStatus,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function __invoke()
    {
        return $this->response;
    }
}
