<?php

namespace App\Action;

use App\Tactician\QueryBus\Query\GenerateTokenQuery;
use Symfony\Component\HttpFoundation\Response;

class HomepageAction extends BaseAction
{
    public function __invoke(): Response
    {
        $tokenCommand = new GenerateTokenQuery('me@example.com');
        $token = $this->queryBus->handle($tokenCommand);

        return $this->renderResponse('site/base.html.twig', [
            'token' => $token,
        ]);
    }
}
