<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\OAuth2\Client\Provider\Facebook;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Service\Facebook as Fb;
use App\Domain\Service\Facebook\ProviderInterface;

final class LoginCallbackFacebook implements MiddlewareInterface
{
    /**
     * @var bool
     */
    public const ROUTER = true;

    /**
     * @var string
     */
    public const PROVIDER = ProviderInterface::class;

    /**
     * @var Facebook
     */
    private $provider;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(Facebook $provider, RouterInterface $router)
    {
        $this->provider = $provider;
        $this->router   = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getQueryParams();

        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $params['code']
            ]);
        } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // verify token on session and redirect to profile
            if ($request->getAttribute('session')->has('oauth2state')) {
                return new RedirectResponse($this->router->generateUri('profile.get'), 301);
            }

        } catch (\Exception $e) {
           return new RedirectResponse($this->router->generateUri('home.get'), 301);
        }

        try {
            $user = $this->provider->getResourceOwner($token);

            // persist data if never registered
            return $handler->handle($request->withParsedBody([
                'provider' => 'facebook',
                'user_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'picture' => $user->getPictureUrl()
            ])->withAttribute(Fb\ProviderInterface::class, [
                'expires' => $token->getExpires(),
                'token' => $token->getToken()
            ]));

        } catch (\Exception $e) {
            return new JsonResponse([
                'code' => 404,
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
