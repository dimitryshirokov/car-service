<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UMA\JsonRpc\Server;

/**
 * Class RpcController
 * @package App\Controller
 */
class RpcController extends AbstractController
{
    /**
     * @var Server
     */
    private Server $server;

    /**
     * RpcController constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @Route("/rpc", name="rpc", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function rpc(Request $request): Response
    {
        $response = $this->getServer()->run($request->getContent());

        return new Response(
            $response,
            200,
            ['Content\Type' => 'application\json']
        );
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }
}
