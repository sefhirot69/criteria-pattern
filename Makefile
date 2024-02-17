# VARIABLES
ENV_FILE	   = .docker/.env
DOCKER_COMPOSE = docker compose
CONTAINER_SUFFIX = $(shell source $(ENV_FILE); echo $$CONTAINER_SUFFIX)
PORT_HTTP_EXTERNAL = $(shell source $(ENV_FILE); echo $$PORT_HTTP_EXTERNAL)
PORT_HTTP_INTERNAL = $(shell source $(ENV_FILE); echo $$PORT_HTTP_INTERNAL)
PORT_MYSQL_EXTERNAL = $(shell source $(ENV_FILE); echo $$PORT_MYSQL_EXTERNAL)
PORT_MYSQL_INTERNAL = $(shell source $(ENV_FILE); echo $$PORT_MYSQL_INTERNAL)
MYSQL_ROOT_PASSWORD= $(shell source $(ENV_FILE); echo $$MYSQL_ROOT_PASSWORD)
MYSQL_ROOT_USER = $(shell source $(ENV_FILE); echo $$MYSQL_ROOT_USER)
MYSQL_USER = $(shell source $(ENV_FILE); echo $$MYSQL_USER)
MYSQL_PASSWORD = $(shell source $(ENV_FILE); echo $$MYSQL_PASSWORD)
MYSQL_DB = $(shell source $(ENV_FILE); echo $$MYSQL_DB)
CONTAINER      = webserver
EXEC           = docker exec -t --user=root $(CONTAINER)-$(CONTAINER_SUFFIX)
EXEC_PHP       = $(EXEC) php
SYMFONY        = $(EXEC_PHP) bin/console
COMPOSER       = $(EXEC) composer
CURRENT-DIR  := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
CURRENT_UID  := $(shell id -u)

define EXPORT_ENV_VARS
export CONTAINER_SUFFIX=$(CONTAINER_SUFFIX); \
export PORT_HTTP_EXTERNAL=$(PORT_HTTP_EXTERNAL); \
export PORT_HTTP_INTERNAL=$(PORT_HTTP_INTERNAL); \
export PORT_MYSQL_EXTERNAL=$(PORT_MYSQL_EXTERNAL); \
export PORT_MYSQL_INTERNAL=$(PORT_MYSQL_INTERNAL); \
export MYSQL_ROOT_PASSWORD=$(MYSQL_ROOT_PASSWORD); \
export MYSQL_ROOT_USER=$(MYSQL_ROOT_USER); \
export MYSQL_USER=$(MYSQL_USER); \
export MYSQL_PASSWORD=$(MYSQL_PASSWORD); \
export MYSQL_DB=$(MYSQL_DB);
endef


.DEFAULT_GOAL := deploy

.PHONY: deploy build deps update-deps composer-install ci composer-update cu composer-require cr composer start stop down recreate rebuild test reload clear bash style lint lint-diff static-analysis

deploy: build
	@echo "📦 Build done"

build: create_env_file rebuild

# 🚚 Dependencies
deps: composer-install

update-deps: composer-update

create_env_file:
	@if [ ! -f .env.local ]; then cp .env .env.local; fi
# 🐘 Composer
composer-install ci: ACTION=install

composer-update cu: ACTION=update $(module)

composer-require cr: ACTION=require $(module)

composer composer-install ci composer-update cu composer-require cr: create_env_file
	$(COMPOSER) $(ACTION) \
			--ignore-platform-reqs \
			--no-ansi
# 🐳 Docker Compose
start: create_env_file
	@echo "🚀 Deploy!!!"
	@$(call EXPORT_ENV_VARS) $(DOCKER_COMPOSE) up -d
stop:
	@$(call EXPORT_ENV_VARS) $(DOCKER_COMPOSE) stop
down:
	$(DOCKER_COMPOSE) down
recreate:
	@echo "🔥 Recreate container!!!"
	@$(call EXPORT_ENV_VARS) $(DOCKER_COMPOSE) up -d --build --remove-orphans --force-recreate
	make deps
rebuild:
	@echo "🔥 Rebuild container!!!"
	@$(call EXPORT_ENV_VARS) $(DOCKER_COMPOSE) build --pull --force-rm --no-cache
	make start
	make deps

# 🧪 Tests
test: create_env_file
	$(EXEC)  ./vendor/bin/phpunit --no-coverage

test/coverage: create_env_file
	$(EXEC)  ./vendor/bin/phpunit --coverage-text --coverage-clover=coverage.xml --order-by=random

# 🦝 Apache
reload:
	$(EXEC) /bin/bash service apache2 restart || true

# 🧹 Clear cache
clear:
	$(SYMFONY) cache:clear

# 🐚 Shell
bash:
	@$(call EXPORT_ENV_VARS) $(DOCKER_COMPOSE) exec -it $(CONTAINER) /bin/bash

# 🦊 Linter
style: lint static-analysis
lint:
	$(EXEC) ./vendor/bin/php-cs-fixer fix --diff
	@echo "Coding Standar Fixer Executed ✅"

lint-diff:
	$(EXEC)  ./vendor/bin/php-cs-fixer fix --dry-run --diff
	@echo "Coding Standar Fixer Executed ✅"

static-analysis:
	$(EXEC)  ./vendor/bin/phpstan analyse -c phpstan.neon.dist

rm-database:
	@$(call EXPORT_ENV_VARS) docker-compose rm -f database
compose: stop rm-database
	@$(call EXPORT_ENV_VARS) docker-compose up -d --force-recreate database

create-db: create-db/dev create-db/test
create-db/dev:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:database:create --env=dev --no-interaction --if-not-exists
create-db/test:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:database:create --env=test --no-interaction --if-not-exists

migrate: migrate/dev migrate/test
migrate/dev:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:migrations:migrate --env=dev

migrate/test:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:migrations:migrate --env=test

migration/diff:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:migrations:diff

migration/gen:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:migrations:generate

drop-db: drop-db/dev  drop-db/test
drop-db/dev:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:database:drop --force --env=dev --if-exists
drop-db/test:
	@$(call EXPORT_ENV_VARS) docker exec $(CONTAINER)-$(CONTAINER_SUFFIX) php bin/console doctrine:database:drop --force --env=test --if-exists