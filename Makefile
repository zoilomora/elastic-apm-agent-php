UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE=php
PWD=`pwd`

start: erase cache-folders build composer-install up bash

erase:
		docker-compose down -v

build:
		docker-compose build && \
		docker-compose pull

up:
		docker-compose up -d

down:
		docker-compose down

cache-folders:
		mkdir -p ~/.composer && chown ${UID}:${GID} ~/.composer

composer-install:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} composer install

bash:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} bash

logs:
		docker-compose logs -f ${DOCKER_PHP_SERVICE}

unit-tests:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} phpunit --testsuite 'Unit Tests'

integration-tests:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} phpunit --testsuite 'Integration Tests' --no-coverage

static-code-analysis:
		sh -c "docker run --rm -v ${PWD}:/app phpstan/phpstan analyse ./src -l 5"
