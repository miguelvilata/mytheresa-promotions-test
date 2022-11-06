make.DEFAULT_GOAL := help

DOCKER_COMPOSE := docker-compose --file docker/docker-compose.yml
PHP_UNIT := ./vendor/symfony/phpunit-bridge/bin/simple-phpunit -c app

.PHONY: init
init:
	make start
	make composer-install
	make db-schema-load
	make fix-permissions

.PHONY: fix-permissions
fix-permissions:
	$(DOCKER_COMPOSE) run docker-php-fpm chmod -R 777 var/log var/cache

.PHONY: install-symfony
install-symfony:
	$(DOCKER_COMPOSE) exec docker-php-fpm symfony new ./new-project

.PHONY: start
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

.PHONY: recreate
recreate:
	$(DOCKER_COMPOSE) up -d --build

.PHONY: restart
restart: stop start

#Access shell on containers
.PHONY: shell-php
shell-php:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash

.PHONY: shell-php-consumer
shell-php-consumer:
	$(DOCKER_COMPOSE) exec docker-php-consumer bash

.PHONY: shell-localstack
shell-localstack:
	$(DOCKER_COMPOSE) exec aws-localstack bash

.PHONY: shell-nginx
shell-nginx:
	$(DOCKER_COMPOSE) exec docker-nginx bash

.PHONY: shell-db
shell-db:
	$(DOCKER_COMPOSE) exec docker-db bash

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

#Compile css
.PHONY: assets-install
assets-install:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console assets:install --symlink

assetic-dump:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console assetic:dump

#Code analyse
.PHONY: phpstan
phpstan:
	$(DOCKER_COMPOSE) run docker-php-fpm ./tools/php-stan/vendor/bin/phpstan analyse -c phpstan.neon

.PHONY: phpfixer
phpfixer:
	$(DOCKER_COMPOSE) exec docker-php-fpm ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix ./src --rules=@Symfony --dry-run

.PHONY: phpfixer-fix
phpfixer-fix:
	$(DOCKER_COMPOSE) exec docker-php-fpm ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix ./src --rules=@Symfony

.PHONY: phpmetrics
phpmetrics:
	$(DOCKER_COMPOSE) exec docker-php-fpm ./tools/php-metrics/vendor/bin/phpmetrics --junit=./build/coverage/coverage.xml --report-html=build/coverage/phpmetrics ./src

.PHONY: phpcs
phpcs:
	$(DOCKER_COMPOSE) exec docker-php-fpm ./tools/php-code-sniffer/vendor/bin/phpcs ./src

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
# 	make start
# 	make composer-dump-autoload
# 	$(DOCKER_COMPOSE) run docker-php-fpm rm -rf app/logs/* app/cache/*
	make test-phpunit

#npm
.PHONY: shell-npm
shell-npm:
	$(DOCKER_COMPOSE) exec docker-npm bash

.PHONY: npm-compile
npm-compile:
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-npm npm run encore dev

.PHONY: npm-install
npm-install:
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-npm npm install

#security
.PHONY: security-generate-password-hash
security-generate-password-hash:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console security:hash-password

.PHONY: user-update-pw
user-generate-pw:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console app:user:generate [password] --email=[email_of_user_to_create_or_change_pw]

#logs
.PHONY: logs
logs:
	$(DOCKER_COMPOSE) exec docker-php-fpm tail -f var/log/*

.PHONY: logs-consumer
logs-consumer:
	$(DOCKER_COMPOSE) exec docker-php-consumer tail -f var/log/*

.PHONY: project-sync
project-sync:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console app:project:sync_videos $(project)

.PHONY: messenger-stop-workers
messenger-stop-workers:
	$(DOCKER_COMPOSE) exec docker-php-fpm bin/console messenger:stop-workers

.PHONY: messenger-process-async
messenger-process-async:
	$(DOCKER_COMPOSE) exec docker-php-consumer bin/console messenger:consume async -vv
