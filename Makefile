install:
		composer install

lint:
		composer exec --verbose phpcs -- --standard=PSR12 currency.php index.php

start:
		php -S localhost:8000