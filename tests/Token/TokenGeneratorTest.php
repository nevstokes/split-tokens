<?php

namespace NevStokes\SplitTokens\Tests\Token;

use NevStokes\SplitTokens\Repository\UserTokenRepository;
use NevStokes\SplitTokens\Token\TokenGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @group critical
 * @group validation
 */
class TokenGeneratorTest extends TestCase
{
    private const SIGNING_KEY = 'test';
    private const USER_ID = 'user@example.com';

    public function test_token_is_persisted()
    {
        $userTokenRepository = $this->createMock(UserTokenRepository::class);

        $userTokenRepository->expects($this->once())
            ->method('save');

        $generator = new TokenGenerator($userTokenRepository, self::SIGNING_KEY);
        $generator->generate(self::USER_ID);
    }
}
