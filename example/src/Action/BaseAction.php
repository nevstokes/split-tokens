<?php

namespace App\Action;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class BaseAction
{
    /**
     * @var CommandBus
     */
    protected $queryBus;
    /**
     * @var Environment
     */
    protected $environment;

    public function __construct(CommandBus $queryBus, Environment $environment)
    {
        $this->queryBus = $queryBus;
        $this->environment = $environment;
    }

    protected function renderResponse(string $template, ?array $context = null): Response
    {
        $content = $this->environment->render($template, $context);

        return new Response($content);
    }
}
