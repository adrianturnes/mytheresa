<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface Controller
{
    public function __invoke(Request $request): JsonResponse;
}
