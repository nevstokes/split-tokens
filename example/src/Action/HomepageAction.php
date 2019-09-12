<?php

namespace App\Action;

use App\Tactician\QueryBus\Query\GenerateTokenQuery;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomepageAction
{
    /**
     * @var CommandBus
     */
    private $queryBus;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(CommandBus $queryBus, Environment $environment)
    {
        $this->queryBus = $queryBus;
        $this->environment = $environment;
    }

    public function __invoke()
    {
        $tokenCommand = new GenerateTokenQuery('me@example.com');
        $token = $this->queryBus->handle($tokenCommand);

        $content = $this->environment->render('site/base.html.twig', [
            'token' => $token,
        ]);

        return new Response($content);
    }
}
