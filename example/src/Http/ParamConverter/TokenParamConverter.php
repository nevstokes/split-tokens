<?php

namespace App\Http\ParamConverter;

use NevStokes\SplitTokens\Exception\TokenGenerationException;
use NevStokes\SplitTokens\ValueObject\Token;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class TokenParamConverter implements ParamConverterInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $rawToken = $request->attributes->get('token');

        try {
            $token = new Token($rawToken);
        } catch (TokenGenerationException $exception) {
            return false;
        }

        $paramName = $configuration->getName();
        $request->attributes->set($paramName, $token);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration): bool
    {
        return Token::class === $configuration->getClass();
    }
}
