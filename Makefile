.PHONY: composer-install shell phpunit-test format analyse npm-test up down restart logs rebuild

DOCKER = docker compose exec
SERVICE_PHP = php
SERVICE_WEB = web-user

composer-install:
	$(DOCKER) $(SERVICE_PHP) composer install

shell:
	$(DOCKER) $(SERVICE_PHP) bash

phpunit-test:
	$(DOCKER) $(SERVICE_PHP) bin/phpunit

format:
	$(DOCKER) $(SERVICE_PHP) bin/php-cs-fixer fix

analyse:
	$(DOCKER) $(SERVICE_PHP) bin/phpstan analyse src

npm-test:
	$(DOCKER) $(SERVICE_WEB) npm test

up:
	docker compose up --build

down:
	docker compose down

restart:
	docker compose down && docker compose up --build

logs:
	docker compose logs -f

rebuild:
	docker compose up --build --no-cache --force-recreate
