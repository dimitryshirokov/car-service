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
 * Class CreateCustomerMethod
 * @package App\API\Method
 */
class CreateCustomerMethod implements Procedure
{
    /**
     * @var CustomerServiceInterface
     */
    private CustomerServiceInterface $customerService;

    /**
     * CreateCustomerMethod constructor.
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
        if (!is_array($params)) {
            $params = json_decode(json_encode($params), true);
        }

        try {
            $customer = $this->getCustomerService()->create($params);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), $exception->__toString(), $request->id());
        }

        return new Success($request->id(), ['customerId' => $customer->getId()]);
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
