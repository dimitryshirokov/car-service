<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\EmployeeServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class CreateEmployeeMethod
 * @package App\API\Method
 */
class CreateEmployeeMethod implements Procedure
{
    /**
     * @var EmployeeServiceInterface
     */
    private EmployeeServiceInterface $employeeService;

    /**
     * CreateEmployeeMethod constructor.
     * @param EmployeeServiceInterface $employeeService
     */
    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
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
            $employee = $this->getEmployeeService()->create($params);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), null, $request->id());
        }

        return new Success($request->id(), ['employeeId' => $employee->getId()]);
    }

    /**
     * @inheritDoc
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return EmployeeServiceInterface
     */
    public function getEmployeeService(): EmployeeServiceInterface
    {
        return $this->employeeService;
    }
}
