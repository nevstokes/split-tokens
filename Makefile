# Standard configuration and definitions
include make/config.mk

# Required functional modules
include make/composer.mk
include make/php-qa.mk

# Included last to include relevant module config automatically
include make/helpers.mk
