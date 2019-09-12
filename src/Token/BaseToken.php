<?php

namespace NevStokes\SplitTokens\Token;

use NevStokes\SplitTokens\Repository\UserTokenRepository;
use DateTimeImmutable;

class BaseToken
{
    private const SIGNING_ALGO = 'sha256';
    private const DATE_FORMAT = DATE_RFC3339;

    /**
     * @var UserTokenRepository
     */
    protected $tokenRepository;
    /**
     * @var string
     */
    protected $signingKey;

    public function __construct(UserTokenRepository $tokenRepository, string $signingKey)
    {
        $this->tokenRepository = $tokenRepository;
        $this->signingKey = $signingKey;
    }

    protected function getHashedVerifier(string $verifier, string $userID, DateTimeImmutable $expiration): string
    {
        $data = sprintf('%s%s%s', $verifier, $userID, $expiration->format(self::DATE_FORMAT));

        return hash_hmac(self::SIGNING_ALGO, $data, $this->signingKey);
    }
}
