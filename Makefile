docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-cli:
	docker-compose run --rm api-php-cli ${arg}

php-cli:
	docker-compose run --rm api-php-cli php cli.php ${args}

console:
	docker-compose run --rm api-php-cli php bin/app.php ${args}

images-rm:
	docker system prune -af

delete-all:
	docker system prune -af

test:
	 docker-compose run --rm api-php-cli vendor/bin/phpunit --colors=always

test-coverage:
	docker-compose run --rm api-php-cli vendor/bin/phpunit --color=always --coverage-html var/coverage