<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\PositionServiceInterface;
use stdClass;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetPositionsMethod
 * @package App\API\Method
 */
class GetPositionsMethod implements Procedure
{
    /**
     * @var PositionServiceInterface
     */
    private PositionServiceInterface $positionService;

    /**
     * GetPositionsMethod constructor.
     * @param PositionServiceInterface $positionService
     */
    public function __construct(PositionServiceInterface $positionService)
    {
        $this->positionService = $positionService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $positions = $this->getPositionService()->getPositions();

        return new Success($request->id(), ['positions' => $positions]);
    }

    /**
     * @inheritDoc
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return PositionServiceInterface
     */
    public function getPositionService(): PositionServiceInterface
    {
        return $this->positionService;
    }
}
