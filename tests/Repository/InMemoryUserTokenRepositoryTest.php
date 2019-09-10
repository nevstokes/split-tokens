<?php

namespace NevStokes\SplitTokens\Tests\Token;

use NevStokes\SplitTokens\Repository\InMemoryUserTokenRepository;
use NevStokes\SplitTokens\Token\TokenGenerator;
use NevStokes\SplitTokens\ValueObject\UserToken;
use PHPUnit\Framework\TestCase;

/**
 * @group supporting
 * @group repository
 */
class InMemoryUserTokenRepositoryTest extends TestCase
{
    private const SIGNING_KEY = 'test';
    private const USER_ID = 'user@example.com';

    public function test_token_is_returned_for_valid_selector()
    {
        $userTokenRepository = new InMemoryUserTokenRepository();

        $generator = new TokenGenerator($userTokenRepository, self::SIGNING_KEY);
        $token = $generator->generate(self::USER_ID);

        $userToken = $userTokenRepository->findUserTokenBySelector($token->getSelector());

        $this->assertInstanceOf(UserToken::class, $userToken);
    }

    public function test_no_token_is_returned_for_invalid_selector()
    {
        $userTokenRepository = new InMemoryUserTokenRepository();

        $this->assertNull($userTokenRepository->findUserTokenBySelector('blah'));
    }
}
