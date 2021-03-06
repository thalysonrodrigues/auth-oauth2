<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Tuupola\Base62;
use Firebase\JWT\JWT;
use App\Domain\Documents\UserInterface;

use function random_bytes;

trait JwtWrapper
{
    /**
     * Return a JWT (Json Web Token) with time to expires, jti (id of token) and token
     * 
     * @param UserInterface $user
     * @param int $minutes
     * @return \StdClass
     */
    private function createJwt(UserInterface $user, int $minutes = 20): \StdClass
    {
        $future = (new \DateTime("+$minutes minutes"))->getTimestamp();

        $payload = [
            'iat' => (new \DateTime())->getTimestamp(),
            'exp' => $future,
            'jti' => (new Base62)->encode(random_bytes(32)),
            'data' => [
                'id' => (string) $user->getId()->getUuid(),
                'name' => $user->getName()->getString(),
                'email' => $user->getEmail()->getEmail()
            ]
        ];

        return (object) [
            'exp' => $future,
            'jti' => $payload['jti'],
            'token' => JWT::encode($payload, $this->jwtSecret, 'HS256')
        ];
    }
}
