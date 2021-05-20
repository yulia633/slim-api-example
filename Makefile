start:
	php -S localhost:8080 -t public public/index.php

setup: prepare-db install

install:
	composer install

prepare-db:
	touch users.json
