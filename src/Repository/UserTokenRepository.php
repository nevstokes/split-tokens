<?php

namespace NevStokes\SplitTokens\Repository;

use NevStokes\SplitTokens\ValueObject\UserToken;

interface UserTokenRepository
{
    public function findUserTokenBySelector(string $selector): ?UserToken;

    public function save(UserToken $token): void;
}
