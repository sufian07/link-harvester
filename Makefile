up:
	docker-compose down && docker-compose up
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop