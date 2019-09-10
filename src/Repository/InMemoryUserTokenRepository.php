<?php

namespace NevStokes\SplitTokens\Repository;

use NevStokes\SplitTokens\ValueObject\UserToken;
use DateTimeImmutable;

class InMemoryUserTokenRepository implements UserTokenRepository
{
    /**
     * @var array
     */
    private $tokens;

    public function __construct()
    {
        $this->tokens = [];
    }

    public function findUserTokenBySelector(string $selector): ?UserToken
    {
        if (!isset($this->tokens[$selector])) {
            return null;
        }

        /** @var UserToken $userToken */
        $userToken = $this->tokens[$selector];
        $currentTime = new DateTimeImmutable();

        return $currentTime < $userToken->getExpiration() ? $userToken : null;
    }

    public function save(UserToken $token): void
    {
        $this->tokens[$token->getSelector()] = $token;
    }
}
