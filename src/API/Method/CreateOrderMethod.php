<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\Exception\ValidationException;
use App\Service\OrderServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class CreateOrderMethod
 * @package App\API\Method
 */
class CreateOrderMethod implements Procedure
{
    /**
     * @var OrderServiceInterface
     */
    private OrderServiceInterface $orderService;

    /**
     * CreateOrderMethod constructor.
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
        if (!is_array($params)) {
            $params = json_decode(json_encode($params), true);
        }

        try {
            bcscale(5);
            $order = $this->getOrderService()->createOrder($params);
        } catch (ValidationException $notFoundException) {
            return new Error(-1000, $notFoundException->getMessage(), null, $request->id());
        } catch (Throwable $exception) {
            file_put_contents(__DIR__ . '/../../../var/log.txt', $exception->__toString());
            return new Error(-32603, $exception->getMessage(), null, $request->id());
        }

        return new Success($request->id(), ['orderId' => $order->getId()]);
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
