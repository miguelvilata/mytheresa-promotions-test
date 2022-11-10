<?php
declare(strict_types=1);

namespace App\Api\Shared\Dto;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiSuccessResponse
{
    private $response;

    public function __construct($data = [], ?int $status = 200, $extraHeaders = [])
    {
        $mainStatus = substr((string)$status, 0, 1);
        $stringStatus = in_array($mainStatus, [4,5]) ? 'error' : 'success';

        $response = new JsonResponse([
            'status' => $stringStatus,
            'data' => $data,
        ], $status);

        $response->headers->add($extraHeaders);
        $this->response = $response;
    }

    public function __invoke()
    {
        return $this->response;
    }
}
