up: docker-up
down: docker-down
restart: docker-down docker-up
assets: assets-install assets-sass

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

test-functional:
	docker-compose run --rm music-php-cli php bin/phpunit --testsuite=functional

assets-install:
	docker-compose run --rm music-node yarn install

assets-sass:
	docker-compose run --rm music-node npm rebuild node-sass

assets-dev:
	docker-compose run --rm music-node npm run dev

assets-watch:
	docker-compose run --rm music-node npm run watch

clear:
	docker run --rm -v ${PWD}/music:/app --workdir=/app alpine rm -f .ready

ready:
	docker run --rm -v ${PWD}/music:/app --workdir=/app alpine touch .ready

diff:
	docker-compose run --rm music-php-cli php bin/console do:mi:di

migrate:
	docker-compose run --rm music-php-cli php bin/console do:mi:mi
