start:
	php -S localhost:8080 -t public public/index.php

setup: prepare-db install

install:
	composer install

validate:
	composer validate

prepare-db:
	touch users.json

prepare-seed:
	bin/seed

lint:
	composer exec -v phpcs -- --standard=PSR12 public app

test:
	composer exec -v phpunit tests

test-coverage:
	composer exec -v phpunit tests -- --coverage-clover build/logs/clover.xml
