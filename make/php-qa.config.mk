PHP := $(shell command -v php)

INFECTION := ./vendor/bin/infection
PHP_CS_FIXER := ./vendor/bin/php-cs-fixer
PHPSTAN := ./vendor/bin/phpstan
PHPUNIT := ./vendor/bin/phpunit

TOOLS := INFECTION PHP_CS_FIXER PHPSTAN PHPUNIT

ifeq ($(PHP),)
__ := $(foreach TOOL,$(TOOLS), \
      		$(eval $(TOOL) := $(RUN) \
					--user $$$$(id -u):$$$$(id -g) \
					--volume $$$$PWD:/var/www \
					--workdir /var/www \
					--entrypoint $($(TOOL)) \
				php:7.3-cli-alpine3.10) \
      	;)
endif
