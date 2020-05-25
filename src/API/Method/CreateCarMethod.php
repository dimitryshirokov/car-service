<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\CarServiceInterface;
use App\Service\Exception\ValidationException;
use stdClass;
use Throwable;
use UMA\JsonRpc\Error;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class CreateCarMethod
 * @package App\API\Method
 */
class CreateCarMethod implements Procedure
{
    /**
     * @var CarServiceInterface
     */
    private CarServiceInterface $carService;

    /**
     * CreateCarMethod constructor.
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
        if (!is_array($params)) {
            $params = json_decode(json_encode($params), true);
        }

        try {
            $car = $this->getCarService()->create($params);
        } catch (ValidationException $notFoundException) {
            return new Error(-1000, $notFoundException->getMessage(), null, $request->id());
        } catch (Throwable $exception) {
            return new Error(-32603, $exception->getMessage(), null, $request->id());
        }

        return new Success($request->id(), ['carId' => $car->getId()]);
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
