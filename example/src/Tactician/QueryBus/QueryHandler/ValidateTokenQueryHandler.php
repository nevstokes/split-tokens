<?php

namespace App\Tactician\QueryBus\QueryHandler;

use App\Tactician\QueryBus\Query\ValidateTokenQuery;
use NevStokes\SplitTokens\Token\TokenValidator;

class ValidateTokenQueryHandler
{
    /**
     * @var TokenValidator
     */
    private $tokenValidator;

    public function __construct(TokenValidator $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
    }

    public function __invoke(ValidateTokenQuery $validateTokenQuery): bool
    {
        return $this->tokenValidator->validate($validateTokenQuery->getToken());
    }
}
