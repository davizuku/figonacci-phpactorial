help:		## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
.PHONY: run
run:		## Start the services
	@docker-compose run php-http composer install && docker-compose up
.PHONY: build
build:		## Build the containers
	@docker-compose build
.PHONY: down
down:		## Stop the containers
	@docker-compose down
.PHONY: test
test:		## Execute test

.PHONY: clean
clean:		## Clean all the data created
	@rm -rf php/vendor
