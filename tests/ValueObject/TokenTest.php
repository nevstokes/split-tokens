<?php

namespace NevStokes\SplitTokens\Tests\ValueObject;

use NevStokes\SplitTokens\Exception\TokenGenerationException;
use NevStokes\SplitTokens\ValueObject\Token;
use PHPUnit\Framework\TestCase;

/**
 * @group critical
 * @group token
 */
class TokenTest extends TestCase
{
    public function test_token_is_split_into_parts()
    {
        $token = Token::generate();
        $reassembled = sprintf('%s%s', $token->getVerifier(), $token->getSelector());

        $this->assertEquals($token->getToken(), $reassembled);
    }

    public function test_generated_token_is_correct_length()
    {
        $token = Token::generate();
        $this->assertEquals(strlen($token->getToken()), Token::KEY_LENGTH);
    }

    public function test_token_cant_be_too_short()
    {
        $this->expectException(TokenGenerationException::class);

        $rawToken = str_repeat('x', Token::KEY_LENGTH - 1);
        $token = new Token($rawToken);
    }
}
