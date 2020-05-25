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
 * Class GetOrderMethod
 * @package App\API\Method
 */
class GetOrderMethod implements Procedure
{
    /**
     * @var OrderServiceInterface
     */
    private OrderServiceInterface $orderService;

    /**
     * GetOrderMethod constructor.
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
        $params = $request->params();

        try {
            $result = $this->getOrderService()->getOrder($params->orderId);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), $exception->__toString(), $request->id());
        }

        return new Success($request->id(), ['order' => $result]);
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
