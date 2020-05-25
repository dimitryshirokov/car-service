<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\OrderServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetWorksAndEmployersMethod
 * @package App\API\Method
 */
class GetWorksAndEmployersMethod implements Procedure
{
    /**
     * @var OrderServiceInterface
     */
    private OrderServiceInterface $orderService;

    /**
     * GetWorksAndEmployersMethod constructor.
     * @param OrderServiceInterface $orderService
     */
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            $result = $this->getOrderService()->getWorksAndEmployers();
        } catch (Throwable $exception) {
            file_put_contents(__DIR__ . '/../../../var/log.txt', $exception->getMessage());
            return new Error(-32603, $exception->getMessage(), null, $request->id());
        }

        return new Success($request->id(), $result);
    }

    /**
     * @return stdClass|null
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return OrderServiceInterface
     */
    public function getOrderService(): OrderServiceInterface
    {
        return $this->orderService;
    }
}
