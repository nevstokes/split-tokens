<?php

namespace App;

class Environment
{
    public const CI = 'ci';
    public const DEV = 'dev';
    public const PROD = 'prod';
    public const TEST = 'test';

    public const VALID_ENVS = [
        self::CI,
        self::DEV,
        self::PROD,
        self::TEST,
    ];

    public static function determine(): ?string
    {
        return getenv('ENV', true) ?: null;
    }
}
