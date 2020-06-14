<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @param array|object $data
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function success($data, int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->json(
            [
                'status' => $code,
                'data' => $data
            ],
            $code,
        );
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function error(array $data, array $headers = []): JsonResponse
    {
        return $this->json(
            [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => $data
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $headers
        );
    }
}
