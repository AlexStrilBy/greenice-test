.DEFAULT_GOAL := init
.PHONY : init-vendor start migrate seed

init: init-vendor start migrate seed

init-vendor:
	docker run --rm \
    		-u "$(id -u):$(id -g)" \
    		-v "$(shell pwd):/var/www/html" \
    		-w /var/www/html \
    		laravelsail/php82-composer:latest \
    		composer install --ignore-platform-reqs

start:
	./vendor/bin/sail up -d

stop:
	./vendor/bin/sail down

restart:
	./vendor/bin/sail restart

tty:
	./vendor/bin/sail shell

tty-root:
	./vendor/bin/sail root-shell

tinker:
	./vendor/bin/sail tinker

open:
	./vendor/bin/sail open

migrate:
	./vendor/bin/sail artisan migrate

migrate-rollback:
	./vendor/bin/sail artisan migrate:rollback

seed:
	./vendor/bin/sail artisan db:seed
