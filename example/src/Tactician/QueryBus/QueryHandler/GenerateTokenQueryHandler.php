<?php

namespace App\Tactician\QueryBus\QueryHandler;

use App\Tactician\QueryBus\Query\GenerateTokenQuery;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use NevStokes\SplitTokens\Token\TokenGenerator;

class GenerateTokenQueryHandler implements TokenGeneratorInterface
{
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(GenerateTokenQuery $generateTokenQuery): string
    {
        return ($this->generateToken())($generateTokenQuery->getUserId());
    }

    public function generateToken(): callable
    {
        return function (string $userId): string {
            return $this->tokenGenerator->generate($userId)->getToken();
        };
    }
}
