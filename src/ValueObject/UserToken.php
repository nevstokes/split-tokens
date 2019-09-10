<?php

namespace NevStokes\SplitTokens\ValueObject;

use DateTimeImmutable;

class UserToken
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $selector;
    /**
     * @var string
     */
    private $validator;
    /**
     * @var DateTimeImmutable
     */
    private $expiration;

    public function __construct(string $userId, string $selector, string $validator, DateTimeImmutable $expiration)
    {
        $this->userId = $userId;
        $this->selector = $selector;
        $this->validator = $validator;
        $this->expiration = $expiration;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getValidator(): string
    {
        return $this->validator;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getExpiration(): DateTimeImmutable
    {
        return $this->expiration;
    }
}
