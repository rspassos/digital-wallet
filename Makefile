init:
	docker-compose up -d

fix-permissions:
	docker exec digitalwallet-webserver-7.4 chown -R root:www-data storage
	docker exec digitalwallet-webserver-7.4 chmod -R 775 storage
	docker exec digitalwallet-webserver-7.4 chown -R root:www-data bootstrap/cache
	docker exec digitalwallet-webserver-7.4 chmod -R 775 bootstrap/cache

migrate:
	docker exec digitalwallet-webserver-7.4 php artisan migrate
