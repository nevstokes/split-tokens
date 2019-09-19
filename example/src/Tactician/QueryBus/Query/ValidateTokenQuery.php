<?php

namespace App\Tactician\QueryBus\Query;

use NevStokes\SplitTokens\ValueObject\Token;

class ValidateTokenQuery
{
    /**
     * @var Token
     */
    private $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * @return Token
     */
    public function getToken(): Token
    {
        return $this->token;
    }
}
