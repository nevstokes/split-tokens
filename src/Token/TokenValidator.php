<?php

namespace NevStokes\SplitTokens\Token;

use NevStokes\SplitTokens\ValueObject\Token;

class TokenValidator extends BaseToken
{
    public function validate(Token $token): bool
    {
        $userToken = $this->tokenRepository->findUserTokenBySelector($token->getSelector());

        if (null === $userToken) {
            return false;
        }

        $claim = $this->getHashedVerifier(
            $token->getVerifier(),
            $userToken->getUserid(),
            $userToken->getExpiration()
        );

        if ($valid = hash_equals($claim, $userToken->getValidator())) {
            $this->tokenRepository->clear($userToken);
        }

        return $valid;
    }
}
