SHELL := /bin/bash

APP_ROOT = /var/www
TARGET_CONTAINER = $(shell docker ps -q -a -f 'name=read-model-users-csv-exercise_php-fpm')

all: help

help:
	@echo
	@echo "usage: make <command>"
	@echo
	@echo "commands:"
	@echo "    start       - start the application containers"
	@echo "    stop        - stop the application containers"
	@echo "    clean       - stop running containers and remove them"
	@echo "    sh          - execute sh inside the app container"
	@echo "    synchronize - download the users csv file"
	@echo "    install     - install php dependencies using composer"
	@echo "    update      - update php dependencies using composer"
	@echo "    test        - run tests"
	@echo

start:
	@docker-compose up -d

stop:
	@docker-compose stop

clean: stop
	@docker-compose rm -v --force

sh:
	@docker exec -it $(TARGET_CONTAINER) sh

test:
	@echo ">>> Running unit tests..."
	@docker exec $(TARGET_CONTAINER) sh -c "$(APP_ROOT)/bin/phpunit"
	@echo

synchronize:
	@echo ">>> Synchronizing..."
	@docker exec $(TARGET_CONTAINER) sh -c "$(APP_ROOT)/bin/console user:synchronize-file"

install:
	@echo ">>> Installing..."
	@docker exec $(TARGET_CONTAINER) sh -c "composer install"

update:
	@echo ">>> Updating..."
	@docker exec $(TARGET_CONTAINER) sh -c "composer update"