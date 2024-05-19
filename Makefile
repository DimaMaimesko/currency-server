# Makefile
setup: env-prepare build install db-create db-migrate run-worker

down:
	docker compose down --remove-orphans
up:
	docker compose up --pull always -d --wait
run-worker:
	docker exec -it currency-server-php-1 php bin/console messenger:consume -vv
env-prepare:
	cp -n .env.example .env



build:
	docker compose down --remove-orphans
	docker compose build --no-cache
	docker compose up --pull always -d --wait
db-create:
	docker exec -it currency-server-php-1 php bin/console doctrine:database:create
db-migrate:
	docker exec -it currency-server-php-1 php bin/console make:migration
run-worker:
	docker exec -it currency-server-php-1 php bin/console messenger:consume -vv
bush:
	docker exec -it currency-server-php-1 bash
cache-clear:
	docker exec -it currency-server-php-1 php bin/console cache:clear
install:
	docker exec -it currency-server-php-1 composer install

