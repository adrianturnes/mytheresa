<?php

declare(strict_types=1);

namespace App\Store\UserInterface\Http\Controller;

use App\Shared\Application\Dto\PaginatorTransformer;
use App\Shared\UserInterface\Http\Controller;
use App\Store\Application\Dto\ProductListTransformer;
use App\Store\Application\Query\GetProductListQuery;
use App\Store\Application\Query\Handler\GetProductListQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetProductListController extends AbstractController implements Controller
{
    public function __construct(
        private GetProductListQueryHandler $handler,
        private ProductListTransformer $productListTransformer,
        private PaginatorTransformer $paginatorTransformer
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $query = GetProductListQuery::create(
            $request->query->get('category'),
            $request->query->get('priceLessThan'),
            $request->query->get('page'),
            $request->query->get('limit')
        );
        $result = $this->handler->handle($query);

        return new JsonResponse($this->paginatorTransformer->transform($result, $this->productListTransformer), JsonResponse::HTTP_OK);
    }
}
