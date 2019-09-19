<?php

namespace NevStokes\SplitTokens\Repository;

use NevStokes\SplitTokens\Exception\TokenExistsException;
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

    public function clear(UserToken $token): void
    {
        $selector = $token->getSelector();

        if (isset($this->tokens[$selector])) {
            unset($this->tokens[$selector]);
        }
    }

    /**
     * @inheritDoc
     */
    public function save(UserToken $token): void
    {
        $selector = $token->getSelector();

        if (isset($this->tokens[$selector])) {
            throw new TokenExistsException(sprintf('Token for selector %s already exists', $selector));
        }

        $this->tokens[$token->getSelector()] = $token;
    }
}
