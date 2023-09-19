setup:
	cp ./src/.env.example ./src/.env
	docker-compose --env-file ./src/.env build --no-cache --force-rm
	docker-compose --env-file ./src/.env up -d
	docker-compose --env-file ./src/.env exec app composer install
	docker-compose --env-file ./src/.env exec app chmod -R 777 storage
	@db_migrate
	docker-compose --env-file ./src/.env exec app npm run dev
build:
	docker-compose --env-file ./src/.env build
up:
	docker-compose --env-file ./src/.env down && docker-compose --env-file ./src/.env up
	docker-compose --env-file ./src/.env exec app npm run dev
db_refresh:
	docker-compose --env-file ./src/.env exec app php artisan db:wipe
	@db_migrate
db_migrate:
	docker-compose --env-file ./src/.env exec app php artisan migrate
down:
	docker-compose --env-file ./src/.env stop
stop:
	docker-compose --env-file ./src/.env stop