<?php

namespace NevStokes\SplitTokens\Token;

use NevStokes\SplitTokens\Exception\TokenExistsException;
use NevStokes\SplitTokens\ValueObject\Token;
use NevStokes\SplitTokens\ValueObject\UserToken;
use DateInterval;
use DateTimeImmutable;

class TokenGenerator extends BaseToken
{
    private const DEFAULT_TTL = 3600;

    public function generate(string $userId, int $ttl = self::DEFAULT_TTL): Token
    {
        do {
            $regenerate = false;

            $token = Token::generate();
            $expiration = new DateInterval(sprintf('PT%dS', $ttl));
            $tokenExpiration = (new DateTimeImmutable())->add($expiration);

            $validator = $this->getHashedVerifier($token->getVerifier(), $userId, $tokenExpiration);
            $userToken = new UserToken($userId, $token->getSelector(), $validator, $tokenExpiration);

            try {
                $this->tokenRepository->save($userToken);
            } catch (TokenExistsException $exception) {
                $regenerate = true;
            }
        } while (true === $regenerate);

        return $token;
    }
}
