SHELL := /bin/bash # Use bash syntax

drupal: install build rspv-install admin-user

theme: build-theme cache-rebuild

install:
	composer install

build:
	./vendor/drupal/console/bin/drupal build

rspv-install:
	./vendor/drupal/console/bin/drupal module:install rspv_events

admin-user:
	./vendor/drush/drush/drush user:password admin "admin";

build-theme:
	cd web/themes/custom/rspv && npm install && npm run build

cache-rebuild:
	./vendor/drush/drush/drush cr
