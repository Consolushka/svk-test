install:
	#cp -n .env.example .env
	docker-compose build
	docker-compose up -d
	docker exec -i app composer install
	docker exec -i app php artisan key:generate
	docker exec -i app php artisan l5:generate

up:
	docker-compose up -d

down:
	docker-compose down

stop:
	docker-compose stop

sh:
	docker exec -ti app bash