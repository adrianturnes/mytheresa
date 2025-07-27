SHELL:=/bin/bash

PHP_CONTAINER_NAME=my-theresa-php
DATABASE_CONTAINER_NAME=my-theresa-database

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-17s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ [Application] Install
build: ## Build application container image
	@docker compose build
install: up  ## Install required software and initialize local application
	@docker compose exec ${PHP_CONTAINER_NAME} ./bin/console doctrine:migrations:migrate -n
	@docker compose exec ${PHP_CONTAINER_NAME} ./bin/console doctrine:fixtures:load -n
up: build ## Start application running containers
	@docker compose up -d
	@docker compose exec ${PHP_CONTAINER_NAME} php -d memory_limit=-1 /usr/local/bin/composer install
	@docker compose exec ${DATABASE_CONTAINER_NAME} bash -c "until mysqladmin ping -h localhost --silent; do sleep 1; done; sleep 5"
down: ## Stop and remove application running containers
	@docker compose down
shell: ## Execute a shell inside application container
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l

##@ [Application] Testing
test: ## Run all tests
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l -c 'vendor/bin/phpunit'
test-unit: ## Run unit tests
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l -c 'vendor/bin/phpunit --testsuite Unit'
test-integration: ## Run integration tests
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l -c 'vendor/bin/phpunit --testsuite Integration'
test-acceptance: ## Run acceptance tests
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l -c 'vendor/bin/phpunit --testsuite Acceptance'
coverage: ## Create code coverage report inside coverage directory
	@docker compose exec ${PHP_CONTAINER_NAME} bash -l -c 'export XDEBUG_MODE=coverage; vendor/bin/phpunit --coverage-html coverage'
