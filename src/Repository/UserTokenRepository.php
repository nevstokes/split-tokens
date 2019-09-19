<?php

namespace NevStokes\SplitTokens\Repository;

use NevStokes\SplitTokens\Exception\TokenExistsException;
use NevStokes\SplitTokens\ValueObject\UserToken;

interface UserTokenRepository
{
    public function findUserTokenBySelector(string $selector): ?UserToken;

    /**
     * @throws TokenExistsException
     */
    public function save(UserToken $token): void;
}
