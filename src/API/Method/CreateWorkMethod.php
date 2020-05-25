<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\WorkServiceInterface;
use stdClass;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class CreateWorkMethod
 * @package App\API\Method
 */
class CreateWorkMethod implements Procedure
{
    /**
     * @var WorkServiceInterface
     */
    private WorkServiceInterface $workService;

    /**
     * CreateWorkMethod constructor.
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
        if (!is_array($params)) {
            $params = json_decode(json_encode($params), true);
        }
        try {
            bcscale(5);
            $work = $this->getWorkService()->create($params);
        } catch (\Throwable $exception) {
            file_put_contents(__DIR__ . '/../../../var/log.txt', $exception->getMessage());
        }

        return new Success($request->id(), ['workId' => $work->getId()]);
    }

    /**
     * @inheritDoc
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
