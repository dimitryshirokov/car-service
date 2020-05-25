<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\EmployeeServiceInterface;
use stdClass;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetEmployersMethod
 * @package App\API\Method
 */
class GetEmployersMethod implements Procedure
{
    /**
     * @var EmployeeServiceInterface
     */
    private EmployeeServiceInterface $employersService;

    /**
     * GetEmployersMethod constructor.
     * @param EmployeeServiceInterface $employersService
     */
    public function __construct(EmployeeServiceInterface $employersService)
    {
        $this->employersService = $employersService;
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

        $result = $this->getEmployersService()->getAll($params['limit'], $params['offset']);

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
     * @return EmployeeServiceInterface
     */
    public function getEmployersService(): EmployeeServiceInterface
    {
        return $this->employersService;
    }
}
