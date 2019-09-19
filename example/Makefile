.PHONY: run stop

# Standard configuration and definitions
include ../make/config.mk

# Required functional modules
include ../make/dotenv.mk
include ../make/composer.mk

##@ Project

run: .env ## Run the example project
	docker-compose up -d webserver

stop: ## Tear down the example project
	docker-compose down -v --rmi local --remove-orphans

# Included last to include relevant module config automatically
include ../make/helpers.mk
