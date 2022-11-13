<?php

declare(strict_types=1);

namespace App\Api\Entrypoint\Http\Product;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Shared\Trait\ApiResponseTrait;
use App\Api\Shared\Trait\QueryHandle;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class GetListController
{
    use QueryHandle;
    use ApiResponseTrait;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * List the rewards of the specified user.
     *
     * This call takes into account all confirmed awards, but not pending or refused awards.
     *
     * @Route("/api/products", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Get a list of products",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ProductView::class))
     *     )
     * )
     * @OA\Parameter(
     *     name="category",
     *     in="query",
     *     description="Optional name of the category to filter to",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="price_lt",
     *     in="query",
     *     description="Optional price max to prices to be listed",
     *     @OA\Schema(type="integer")
     * )
     */
    #[Route('/api/products', name: 'http_get_test', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        try {
            return $this->apiSuccess(
                $this->query(
                    new ListProductCommand(
                        $request->query->all()
                    ),
                    Response::HTTP_OK
                )
            );
        } catch (ValidationException $e) {
            return $this->apiError($e->getMessage(), $e->getErrorList(), Response::HTTP_CONFLICT);
        } catch (\Exception $e) {
            return $this->apiError($e->getMessage(), [], Response::HTTP_BAD_REQUEST);
        }
    }
}
