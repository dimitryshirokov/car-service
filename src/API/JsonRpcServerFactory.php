<?php

declare(strict_types=1);

namespace App\API;

use Psr\Container\ContainerInterface;
use UMA\JsonRpc\Server;

/**
 * Class JsonRpcServerFactory
 * @package App\API
 */
class JsonRpcServerFactory
{
    /**
     * @param ContainerInterface $container
     * @param array $methods
     * @return Server
     */
    public function create(ContainerInterface $container, array $methods): Server
    {
        $server = new Server($container);
        foreach ($methods as $name => $serviceName) {
            $server->set($name, $serviceName);
        }

        return $server;
    }
}
