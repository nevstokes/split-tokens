<?php

namespace App\Action;

use App\Tactician\QueryBus\Query\ValidateTokenQuery;
use NevStokes\SplitTokens\ValueObject\Token;
use Symfony\Component\HttpFoundation\Response;

class RedeemTokenAction extends BaseAction
{
    public function __invoke(Token $token): Response
    {
        $validationCommand = new ValidateTokenQuery($token);
        $valid = $this->queryBus->handle($validationCommand);

        return $this->renderResponse('site/base.html.twig', [
            'token' => $valid ? 'Valid' : 'Invalid',
        ]);
    }
}
