.PHONY: all-checks all-tests check-tree clean deps guard-% help
.DEFAULT_GOAL := help

# Don't check these files for a respetive config
NOCONFIGS = Makefile $(INCLUDE_PATH)config.mk $(INCLUDE_PATH)ansi.mk $(INCLUDE_PATH)helpers.mk

# Automatically include any configuration for specified modules
include $(filter $(wildcard $(INCLUDE_PATH)*.config.mk),$(subst .mk,.config.mk,$(filter-out $(NOCONFIGS),$(MAKEFILE_LIST))))


##@ Checking

all-checks: ## Run all checks
	$(if $(CHECKS),$(MAKE) --keep-going --no-print-directory --output-sync --jobs $(CHECKS),$(call style,"No checks",$(STYLE_error)))

all-tests: ## Run all tests
	$(if $(TESTS),$(MAKE) --keep-going --no-print-directory --output-sync --jobs $(TESTS),$(call style,"No tests",$(STYLE_error)))


##@ Helpers

# https://stackoverflow.com/questions/4728810/makefile-variable-as-prerequisite
guard-%:
	$(if $(value $*),,$(error $* not set))

# Make sure working tree is clean
check-tree: ## Check working tree status
	git diff --quiet || $(error Working tree is dirty. Please commit your work.)

clean: ## Clean up
	$(if $(CLEAN),$(MAKE) --keep-going --no-print-directory --output-sync --jobs $(CLEAN),$(call style,"Nothing to clean",$(STYLE_error)))

deps: ## Install all dependecies
	$(if $(DEPS),$(MAKE) --keep-going --no-print-directory --output-sync --jobs $(DEPS),$(call style,"No dependencies to install",$(STYLE_error)))

# https://suva.sh/posts/well-documented-makefiles/
help: ## Display this help
	awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make $(STYLE_cyan)<target>$(STYLE_reset)\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  $(STYLE_cyan)%-$(shell awk 'BEGIN {FS = ":.*##"; } /^[a-zA-Z_-]+:.*?##/ { printf "%s\n", $$1, $$2 }' $(MAKEFILE_LIST) | awk 'BEGIN{max=0} NR>1{len=length($1);max=max>len?max:len;}END{print max}')s$(STYLE_reset) %s\n", $$1, $$2 } /^##@/ { printf "\n$(STYLE_bold)%s$(STYLE_reset)\n", substr($$0, 5) }' $(MAKEFILE_LIST)

# Don't do anything that's not defined
%:
	@:

# This should be the last thing done so as to not profile any config commands
ifdef PROFILER
# Run commands through a profiler script if one is supplied
override SHELL := /usr/bin/env $(PROFILER)
endif
