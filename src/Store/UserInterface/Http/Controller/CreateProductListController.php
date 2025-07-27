<?php

declare(strict_types=1);

namespace App\Store\UserInterface\Http\Controller;

use App\Shared\UserInterface\Http\Controller;
use App\Store\Application\Command\CreateProductListCommand;
use App\Store\Application\Command\Handler\CreateProductListCommandHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateProductListController extends AbstractController implements Controller
{
    public function __construct(
        private CreateProductListCommandHandler $handler
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $command = CreateProductListCommand::createFromArray($request->toArray());
        $this->handler->handle($command);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED);
    }
}
