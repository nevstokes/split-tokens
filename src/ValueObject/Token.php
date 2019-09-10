<?php

namespace NevStokes\SplitTokens\ValueObject;

use Exception;
use NevStokes\SplitTokens\Exception\TokenGenerationException;

class Token
{
    public const KEY_LENGTH = 96;
    private const VERIFIER_LENGTH = 64;

    /**
     * @var string
     */
    private $verifier;
    /**
     * @var string
     */
    private $selector;

    /**
     * @throws TokenGenerationException
     */
    public function __construct(string $rawToken)
    {
        if (strlen($rawToken) < self::KEY_LENGTH) {
            throw new TokenGenerationException('Key too short');
        }

        [$this->verifier, $this->selector] = str_split($rawToken, self::VERIFIER_LENGTH);
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function getVerifier(): string
    {
        return $this->verifier;
    }

    public function getToken(): string
    {
        return sprintf('%s%s', $this->getVerifier(), $this->getSelector());
    }

    /**
     * @throws TokenGenerationException
     */
    public static function generate(): Token
    {
        try {
            $randomBytes = random_bytes(self::KEY_LENGTH / 2);
            return new self(bin2hex($randomBytes));
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            throw new TokenGenerationException($exception->getMessage());
            // @codeCoverageIgnoreEnd
        }
    }
}
