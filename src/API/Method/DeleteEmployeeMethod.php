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
 * Class DeleteEmployeeMethod
 * @package App\API\Method
 */
class DeleteEmployeeMethod implements Procedure
{
    /**
     * @var EmployeeServiceInterface
     */
    private EmployeeServiceInterface $employeeService;

    /**
     * DeleteEmployeeMethod constructor.
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
            $employee = $this->getEmployeeService()->delete($params['id']);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), null, $request->id());
        }

        return new Success(-32603, ['employeeId' => $employee->getId()]);
    }

    /**
     * @return stdClass|null
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
