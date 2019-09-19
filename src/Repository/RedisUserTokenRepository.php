<?php

namespace NevStokes\SplitTokens\Repository;

use NevStokes\SplitTokens\Exception\TokenExistsException;
use NevStokes\SplitTokens\ValueObject\UserToken;
use DateTimeImmutable;
use Redis;

class RedisUserTokenRepository implements UserTokenRepository
{
    /**
     * @var Redis
     */
    private $redisClient;
    /**
     * @var string
     */
    private $prefix;

    public function __construct(Redis $redisClient, string $prefix)
    {
        $this->redisClient = $redisClient;
        $this->prefix = $prefix;
    }

    public function findUserTokenBySelector(string $selector): ?UserToken
    {
        $key = $this->getPrefixedKey($selector);
        if (!$this->redisClient->exists($key)) {
            return null;
        }

        $rawToken = $this->redisClient->get($key);
        return unserialize($rawToken, [UserToken::class]);
    }

    public function clear(UserToken $token): void
    {
        $key = $this->getPrefixedKey($token->getSelector());
        $this->redisClient->del($key);
    }

    /**
     * @inheritDoc
     */
    public function save(UserToken $token): void
    {
        $key = $this->getPrefixedKey($token->getSelector());
        if ($this->redisClient->exists($key)) {
            throw new TokenExistsException(sprintf('Token with key %s already exists', $key));
        }

        $ttl = $token->getExpiration()->format('U') - (new DateTimeImmutable())->format('U');

        $this->redisClient->setex($key, $ttl, serialize($token));
    }

    private function getPrefixedKey(string $key): string
    {
        return sprintf('%s.%s', $this->prefix, $key);
    }
}
