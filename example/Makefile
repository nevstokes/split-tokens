.PHONY: run stop

# Standard configuration and definitions
include ../make/config.mk

# Required functional modules
include ../make/dotenv.mk
include ../make/composer.mk

define port #(service,port)
$(shell docker-compose port $(1) $(2) | cut -d: -f 2)
endef


##@ Project

run: .env ## Run the example project
	docker-compose up -d webserver
	printf "App running on port $(STYLE_info)%s$(STYLE_reset)\n" $(call port,webserver,80)

stop: ## Tear down the example project
	docker-compose down -v --rmi local --remove-orphans

# Included last to include relevant module config automatically
include ../make/helpers.mk
