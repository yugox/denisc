<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->success(['Logged out successfully'], Response::HTTP_NO_CONTENT);
    }
}
