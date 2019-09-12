# Split Tokens

An implementation of a secure split token approach to authentication as outlined by [Paragon Initiative Enterprises](https://paragonie.com/blog/2017/02/split-tokens-token-based-authentication-protocols-without-side-channels).

## Getting Started

This library will generate and validate authentication tokens. It provides sample repositories for storing and retrieving these tokens but not for getting them into the hands of your users.

### Dependencies

- PHP >= 7.2

### Use

Add the library to your project:

```bash
composer require nevstokes/split-tokens
```

#### Generate

A repository needs to be given for token persistence; two are included in this library: `RedisUserTokenRepository` and `DoctrineUserTokenRepository`. A signing key is also required in order to create a <acronym title="M">HMAC</acronym> for the token. If you're using tokens for multiple purposes then you should choose distinct signing keys.

```php
$generator = new TokenGenerator($userTokenRepository, $signingKey);
```

To generate a token for a user with a default TTL (one hour):

```php
$token = $generator->generate($userIdentifier);
```

You can set a custom TTL with the optional second argument (specified as integer seconds):

```php
$token = $generator->generate($userIdentifier, $ttl);
```

#### Validate

Use the same signing key as was used to generate a token to validate it:

```php
$validator = new TokenValidator($userTokenRepository, $signingKey);
$validity = $validator->validate($token);
```

See the [`example`](example) directory for a fully runnable demonstration, which can be started with the following command:

```bash
make -C example run
```

## Versioning

The project uses [SemVer](http://semver.org/). Notable changes are recorded in the [CHANGELOG.md](CHANGELOG.md) file. For the versions available, see the [tags on this repository](https://github.com/nevstokes/split-tokens/tags).

## Authors

* **[Nev Stokes](https://github.com/nevstokes)** - *Initial work*

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on the code of conduct, and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Built With

* [Composer](https://getcomposer.org/) - Dependency Management
* [PHPUnit](https://phpunit.de/), [Infection](https://infection.github.io/), [PHPStan](https://github.com/phpstan/phpstan) and [PHP CS Fixer](https://cs.symfony.com/) - QA Tools

## Acknowledgments

* [Paragon Initiative Enterprises](https://paragonie.com/blog/2017/02/split-tokens-token-based-authentication-protocols-without-side-channels) for the concept.
* [Billie Thompson](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2) for a great README template.
