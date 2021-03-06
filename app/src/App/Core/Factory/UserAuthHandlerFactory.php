<?php

declare(strict_types=1);

namespace App\Core\Factory;

use App\Domain\Service\UserServiceInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Router\RouterInterface;

final class UserAuthHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $className): MiddlewareInterface
    {
        return new $className(
            $container->get(UserServiceInterface::class),
            $container->get(RouterInterface::class),
            $container->get('config')['auth']['jwt']['secret'],
            $container->get('config')['session']['jwt']
        );
    }
}
