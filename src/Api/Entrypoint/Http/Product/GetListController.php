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

class GetListController
{
    use QueryHandle;
    use ApiResponseTrait;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

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
