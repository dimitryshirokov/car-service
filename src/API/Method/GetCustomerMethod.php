<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\CustomerServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetCustomerMethod
 * @package App\API\Method
 */
class GetCustomerMethod implements Procedure
{
    /**
     * @var CustomerServiceInterface
     */
    private CustomerServiceInterface $customerService;

    /**
     * GetCustomerMethod constructor.
     * @param CustomerServiceInterface $customerService
     */
    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $params = $request->params();

        try {
            $result = $this->getCustomerService()->get($params->customerId);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), $exception->__toString(), $request->id());
        }

        return new Success($request->id(), ['customer' => $result]);
    }

    /**
     * @return stdClass|null
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return CustomerServiceInterface
     */
    public function getCustomerService(): CustomerServiceInterface
    {
        return $this->customerService;
    }
}
