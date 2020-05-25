<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\WorkServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetWorksMethod
 * @package App\API\Method
 */
class GetWorksMethod implements Procedure
{
    /**
     * @var WorkServiceInterface
     */
    private WorkServiceInterface $workService;

    /**
     * GetWorksMethod constructor.
     * @param WorkServiceInterface $workService
     */
    public function __construct(WorkServiceInterface $workService)
    {
        $this->workService = $workService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $params = $request->params();

        try {
            $result = $this->getWorkService()->getAll($params->limit, $params->offset);
        } catch (Throwable $exception) {
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
     * @return WorkServiceInterface
     */
    public function getWorkService(): WorkServiceInterface
    {
        return $this->workService;
    }
}
