<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\CarServiceInterface;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetCarMethod
 * @package App\API\Method
 */
class GetCarMethod implements Procedure
{
    /**
     * @var CarServiceInterface
     */
    private CarServiceInterface $carService;

    /**
     * GetCarMethod constructor.
     * @param CarServiceInterface $carService
     */
    public function __construct(CarServiceInterface $carService)
    {
        $this->carService = $carService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $params = $request->params();

        try {
            $car = $this->getCarService()->get($params->id);
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), $exception->__toString(), $request->id());
        }

        return new Success($request->id(), ['car' => $car]);
    }

    /**
     * @return stdClass|null
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return CarServiceInterface
     */
    public function getCarService(): CarServiceInterface
    {
        return $this->carService;
    }
}
