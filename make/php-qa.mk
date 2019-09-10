.PHONY: php-qa-clean php-cs-fixer php-lint php-unit-test-% php-unit-tests php-unit-tests-coverage

CHECKS += php-cs-fixer php-lint
CLEAN += php-qa-clean
TESTS += php-unit-tests

##@ PHP QA

php-cs-fixer: composer.lock ## Code style checks
	$(PHP_CS_FIXER) \
		fix \
		--dry-run

php-lint: composer.lock ## Static analysis
	$(PHPSTAN) \
		analyse \
		$(if $(ANSI),--ansi,--no-ansi) \
		--no-progress \
		src tests \
		--level 4

php-unit-tests: tests composer.lock ## All unit tests
	$(PHPUNIT) $(if $(CI),-c phpunit.ci.xml) \
		--colors=$(if $(ANSI),always,never) \
		--no-logging

php-unit-test-filter: tests composer.lock ## Filtered unit tests
	$(PHPUNIT) $(if $(CI),-c phpunit.ci.xml) \
		--colors=$(if $(ANSI),always,never) \
		--no-logging \
		--filter $(filter-out $@,$(MAKECMDGOALS))

php-unit-test-group: tests composer.lock ## Single unit test group
	$(PHPUNIT) $(if $(CI),-c phpunit.ci.xml) \
		--colors=$(if $(ANSI),always,never) \
		--no-logging \
		--group $(filter-out $@,$(MAKECMDGOALS))

php-unit-test-suite: tests composer.lock ## Unit testsuite
	$(PHPUNIT) $(if $(CI),-c phpunit.ci.xml) \
		--colors=$(if $(ANSI),always,never) \
		--no-logging \
		--testsuite "$(filter-out $@,$(MAKECMDGOALS))"

php-unit-tests-coverage: build/xdebug-filter.php ## Full unit test with coverage
	$(PHPUNIT) $(if $(CI),-c phpunit.ci.xml) \
		--colors=$(if $(ANSI),always,never) \
		--prepend $<

php-qa-clean: ## Remove temporary files and directories
	rm -rf .php_cs.cache .phpunit.result.cache build

build/xdebug-filter.php: tests composer.lock
	$(PHPUNIT) --dump-xdebug-filter $@

build/infection.log: CHANGED_FILES := $(shell git diff origin/master --diff-filter=AM --name-only | grep src/ | paste -sd "," -)
build/infection.log: infection.json composer.lock ## Mutation tests
	echo $(CHANGED_FILES)
	$(INFECTION) \
		$(if $(CI),--no-progress,--show-mutations) \
		--threads=4 --coverage=build/coverage --formatter=progress --only-covered

#INFECTION_FILTER="--filter=${CHANGED_FILES} --ignore-msi-with-no-mutations";

#infection --coverage=build/coverage --min-covered-msi=70 --min-msi=48 --threads=4 $INFECTION_FILTER
#/usr/bin/php vendor/bin/infection --min-covered-msi=70 --min-msi=65 --threads=4 --coverage=build/coverage --formatter=progress --only-covered
