<?php

declare(strict_types=1);

namespace App\Store\UserInterface\Http\Controller;
use App\Store\Application\Query\GetProductQuery;
use App\Shared\UserInterface\Http\Controller;
use App\Store\Application\Dto\ProductTransformer;
use App\Store\Application\Query\Handler\GetProductQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetProductController extends AbstractController implements Controller
{
    public function __construct(
        private GetProductQueryHandler $handler,
        private ProductTransformer $transformer,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = GetProductQuery::create(
            $request->attributes->get('sku', '')
        );
        $result = $this->handler->handle($query);

        return new JsonResponse($this->transformer->transform($result), JsonResponse::HTTP_OK);
    }
}
