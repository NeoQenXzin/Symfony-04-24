# Makefile
SHELL := /bin/bash
tests:
	APP_ENV=test symfony console doctrine:database:drop --force || true
	APP_ENV=test symfony console doctrine:database:create
	APP_ENV=test symfony console doctrine:schema:update --force
	APP_ENV=test symfony console doctrine:fixtures:load -n
	APP_ENV=dev symfony php bin/phpunit $(MAKECMDGOALS)

# Lancer serveur 
loadup:
	docker compose up -d --wait
	symfony server:start -d --no-tls

push:
	git add .
	git commit -m "$(m)"
	git push

# Verifie que le code est de qualité 
phpstan:
	APP_ENV=dev symfony php vendor/bin/phpstan analyse --level max

bdd:
	docker compose exec database psql app app

bddtest:
	docker compose exec database psql app_test app

# Equivalent eslint => autoformat le code convention
php-cs-fixer:
	APP_ENV=dev symfony php vendor/bin/php-cs-fixer fix
php-cs-fixer-dry-run:
	APP_ENV=dev symfony php vendor/bin/php-cs-fixer fix --dry-run


quality: php-cs-fixer tests phpstan

.PHONY: tests