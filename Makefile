make.DEFAULT_GOAL := help

DOCKER_COMPOSE := docker-compose --file docker/docker-compose.yml
PHP_UNIT := bin/phpunit

.PHONY: init
init:
	make start
	make composer-install
	make migrations-execute

.PHONY: start
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: stop start

.PHONY: recreate
recreate:
	$(DOCKER_COMPOSE) up -d --build

#Access shell on container
.PHONY: shell-php
shell-php:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash

#Cache clear
.PHONY: cache-clear
cache-clear:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console cache:clear

#Db
.PHONY: migrations-execute
migrations-execute:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console --no-interaction doctrine:migrations:migrate

.PHONY: db-fixtures-load
db-fixtures-load:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:fixtures:load

.PHONY: db-create
db-create:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:database:create

.PHONY: db-schema-update
db-schema-update:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:schema:update --force

.PHONY: test
test:
	make start
	make cache-clear
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-php-fpm php $(PHP_UNIT)
