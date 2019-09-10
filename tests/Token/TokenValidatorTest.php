<?php

namespace NevStokes\SplitTokens\Tests\Token;

use NevStokes\SplitTokens\Repository\InMemoryUserTokenRepository;
use NevStokes\SplitTokens\Token\TokenGenerator;
use NevStokes\SplitTokens\Token\TokenValidator;
use NevStokes\SplitTokens\ValueObject\Token;
use PHPUnit\Framework\TestCase;

/**
 * @group critical
 * @group validation
 */
class TokenValidatorTest extends TestCase
{
    private const SIGNING_KEY = 'test';
    private const USER_ID = 'user@example.com';

    public function test_token_can_be_validated()
    {
        $userTokenRepository = new InMemoryUserTokenRepository();

        $generator = new TokenGenerator($userTokenRepository, self::SIGNING_KEY);
        $token = $generator->generate(self::USER_ID);

        $validator = new TokenValidator($userTokenRepository, self::SIGNING_KEY);
        $this->assertTrue($validator->validate($token));
    }

    public function test_invalid_token_is_not_valid()
    {
        $userTokenRepository = new InMemoryUserTokenRepository();

        $randomToken = Token::generate();

        $validator = new TokenValidator($userTokenRepository, self::SIGNING_KEY);
        $this->assertFalse($validator->validate($randomToken));
    }
}
