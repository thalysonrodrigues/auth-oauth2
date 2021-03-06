<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'aliases' => [
                \App\Domain\Service\Facebook\ProviderInterface::class => \League\OAuth2\Client\Provider\Facebook::class,
                \App\Domain\Service\Google\ProviderInterface::class => \League\OAuth2\Client\Provider\Google::class
            ],
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                // homepage
                \App\Handler\HomePageHandler::class => \App\Handler\PageHandlerFactory::class,
                \App\Handler\LoginPageHandler::class => \App\Handler\PageHandlerFactory::class,
                \App\Handler\RegisterPageHandler::class => \App\Handler\PageHandlerFactory::class,
                \App\Handler\User\ProfilePageHandler::class => \App\Handler\PageHandlerFactory::class,

                // connection
                \Doctrine\ODM\MongoDB\DocumentManager::class => \App\Core\Factory\DocumentManagerFactory::class,

                // actions
                \App\Domain\Handler\User\Create::class => \App\Core\Factory\UserHandlerFactory::class,
                \App\Domain\Handler\User\CreateOauth::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\Login::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\Logout::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\LoginFacebook::class => \App\Core\Factory\UserAuthHandlerProviderFactory::class,
                \App\Domain\Handler\User\LoginCallbackFacebook::class => \App\Core\Factory\UserAuthHandlerProviderFactory::class,
                \App\Domain\Handler\User\LoginGoogle::class => \App\Core\Factory\UserAuthHandlerProviderFactory::class,
                \App\Domain\Handler\User\LoginCallbackGoogle::class => \App\Core\Factory\UserAuthHandlerProviderFactory::class,

                // service
                \App\Domain\Service\UserServiceInterface::class => \App\Core\Domain\Service\UserServiceFactory::class,
                \League\OAuth2\Client\Provider\Facebook::class => \App\Core\Domain\Service\Facebook\ProviderFactory::class,
                \League\OAuth2\Client\Provider\Google::class => \App\Core\Domain\Service\Google\ProviderFactory::class,

                // repository
                \App\Infrastructure\Repository\UserRepositoryInterface::class => \App\Core\Infrastructure\Repository\UserRepositoryFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'        => [__DIR__ . '/../../resources/templates/app'],
                'user'       => [__DIR__ . '/../../resources/templates/app/user'],
                'components' => [__DIR__ . '/../../resources/templates/app/components'],
                'error'      => [__DIR__ . '/../../resources/templates/error'],
                'layout'     => [__DIR__ . '/../../resources/templates/layout'],
            ],
        ];
    }
}
