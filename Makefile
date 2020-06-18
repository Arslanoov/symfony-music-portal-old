up: docker-up
down: docker-down
restart: docker-down docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-build:
	docker-compose build

composer-install:
	docker-compose run --rm music-php-cli composer install

test:
	docker-compose run --rm music-php-cli php bin/phpunit

test-coverage:
	docker-compose run --rm music-php-cli php bin/phpunit --coverage-clover var/clover.xml --coverage-html var/coverage

test-unit:
	docker-compose run --rm music-php-cli php bin/phpunit --testsuite=unit

test-unit-coverage:
	docker-compose run --rm music-php-cli php bin/phpunit --testsuite=unit --coverage-clover var/clover.xml --coverage-html var/coverage
