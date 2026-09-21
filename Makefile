SHELL := /bin/bash
#include .docker.config

.PHONY: init
init: ## Copies env file if does not exists and sets githooks

#	git config core.hooksPath .githooks
#	docker login ${DOCKER_LOGIN_CR} --username ${DOCKER_LOGIN_UNAME}  --password-stdin <<< ${DOCKER_LOGIN_TOKEN}

.PHONY: help
help: ## Displays the list of tarhets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: setup
setup: init up

.PHONY: up
up: ## Force recreate and start of local containers
	docker compose down --remove-orphans -v
	docker compose pull
	docker compose up -d --force-recreate
