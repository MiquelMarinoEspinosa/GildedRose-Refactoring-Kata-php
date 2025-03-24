SH_PHP=docker exec -i -t app.php-cli

build:
	docker build etc/devel/docker/php-cli -t app/php-cli

up:
	docker run --rm -i -t -d --name app.php-cli -v .:/app --add-host "host.docker.internal:host-gateway" app/php-cli 

stop:
	docker stop app.php-cli

shell:
	$(SH_PHP) sh
