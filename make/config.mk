# Make sure we're using bash
SHELL := /usr/bin/env bash

# https://explainshell.com/explain?cmd=set+-euo+pipefail
.SHELLFLAGS := -euo pipefail -c

# https://www.gnu.org/software/make/manual/html_node/Special-Targets.html#Special-Targets
.DELETE_ON_ERROR:
.SUFFIXES:

INCLUDE_PATH := $(dir $(lastword $(MAKEFILE_LIST)))

# Unless otherwise stated, set interactive mode if stdin is a tty
INTERACTIVE ?= $(shell [ -t 0 ] && echo 1)

# Disable all command echoing without requiring @ prefixes
ifndef VERBOSE
.SILENT:
endif

# Default to development environment
ENV ?= dev
CI ?= $(if $(findstring ci,$(ENV)),1)
PRODUCTION := $(if $(findstring prod,$(ENV)),1)

# Derive project repository name components if not stated elsewhere
VENDOR ?= $(shell whoami)
PROJECT ?= $(notdir $(CURDIR))

# Current git hash
export SOURCE_COMMIT := $(shell git rev-parse --short HEAD)

# Unless supplied, define how to run container commands
RUNNER ?= $(shell command -v docker || command -v podman)
RUN := $(RUNNER) run --rm
ifeq ($(INTERACTIVE),1)
RUN += --interactive
endif

include $(INCLUDE_PATH)/ansi.mk
