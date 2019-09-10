# Split Tokens

An implementation of a secure split token approach to authentication as outlined by [Paragon Initiative Enterprises](https://paragonie.com/blog/2017/02/split-tokens-token-based-authentication-protocols-without-side-channels).

## Getting Started

This library will generate and validate authentication tokens. It provides sample repositories for storing and retrieving these tokens but not for getting them into the hands of your users.

### Dependencies

- PHP >= 7.2

### Use

```
composer require nevstokes/split-tokens
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
