make.DEFAULT_GOAL := help

DOCKER_COMPOSE := docker-compose --file docker/docker-compose.yml
PHP_UNIT := ./bin/phpunit

.PHONY: init
init:
	make start
	make composer-install
	make db-create
	make migrations-execute

.PHONY: fix-permissions
fix-permissions:
	$(DOCKER_COMPOSE) run docker-php-fpm chmod -R 777 var/log var/cache

.PHONY: start
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: stop start

#Db
.PHONY: migrations-execute
migrations-execute:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console --no-interaction doctrine:migrations:migrate

.PHONY: db-create
db-create:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:database:create

#Access shell on containers
.PHONY: shell-php
shell-php:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash

#Cache clear
.PHONY: cache-clear
cache-clear:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console cache:clear

#Database fixtures load
.PHONY: db-fixtures-load
db-fixtures-load:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:fixtures:load

.PHONY: db-create
db-create:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:database:create

.PHONY: db-schema-update
db-schema-update:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console doctrine:schema:update --force

.PHONY: copy-host
copy-host:
	echo "127.0.0.1 local.project.com" >> /etc/hosts

#PHP - Composer
.PHONY: composer-install
composer-install:
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-php-fpm composer install -vvv

.PHONY: composer-dump-autoload
composer-dump-autoload:
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-php-fpm composer dump-autoload --no-dev --classmap-authoritative

#test: see: https://docs.google.com/document/d/1oxCaf2mPqk2P7pGLtHfAzIxSPo8t_qyI00GmqNUId4Q/edit?usp=sharing
.PHONY: test
test:
	make start
	make cache-clear CACHE-ENV=test
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-php-fpm $(PHP_UNIT) $(TEST_DIR) --coverage-xml build/coverage
