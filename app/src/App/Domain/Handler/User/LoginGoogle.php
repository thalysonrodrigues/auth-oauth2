<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use League\OAuth2\Client\Provider\Google;
use App\Domain\Service\Google\ProviderInterface;

final class LoginGoogle implements MiddlewareInterface
{
    /**
     * @var bool
     */
    public const ROUTER = false;

    /**
     * @var string
     */
    public const PROVIDER = ProviderInterface::class;

    /**
     * @var Google
     */
    private $provider;

    public function __construct(Google $provider, RouterInterface $router = null)
    {
        $this->provider = $provider;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params  = $request->getQueryParams();
        $session = $request->getAttribute('session');

        if ( ! empty($params['error'])) {
            // access denied
            exit('Got error: ' . htmlspecialchars($params['error'], ENT_QUOTES, 'UTF-8'));

        } elseif (empty($params['code'])) {
            // get a url
            $authUrl = $this->provider->getAuthorizationUrl();

            $session->set('oauth2state', $this->provider->getState());
            
            return $handler->handle($request->withAttribute(self::class,
                ['logged' => false, 'auth_url' => $authUrl]
            ));

        } elseif (empty($params['state']) || ($params['state'] !== $session->get('oauth2state'))) {
            $session->unset('oauth2state');
        }

        return $handler->handle($request->withAttribute(self::class, null));
    }
}
