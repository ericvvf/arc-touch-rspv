SHELL := /bin/bash # Use bash syntax

all: build rspv-install create-user

install:
	composer install

build:
	./vendor/drupal/console/bin/drupal build

rspv-install:
	./vendor/drupal/console/bin/drupal module:install rspv_events

create-user:
	./vendor/drush/drush/drush user-create eric.vvf --mail="eu@ericvinicius.com.br" --password="admin"; drush user-add-role "administrator" eric.vvf
