args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

# Help rule to get the arguments
%:
	@:

help:		## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
.PHONY: run
run: install	## Start the services
	@docker-compose up
.PHONY: build
build:		## Build the containers
	@docker-compose build
.PHONY: install
install:	## Install the dependencies
	@docker-compose run --rm php-http composer install && \
	docker-compose run --entrypoint "" node-http npm install
.PHONY: down
down:		## Stop the containers
	@docker-compose down

.PHONY: benchmark
benchmark: 	## Usage: benchmark <filename> <method> <num-epochs> <max-value>
	@bash ./benchmarks/run.sh $(call args,)

.PHONY: test
test: test-php-http test-go-http test-go-grpc test-node-http		## Execute test

test-php-http:
	@echo "Sending request to php-http service..." && time curl localhost:3000

test-go-http:
	@echo "Sending request to go-http service..." && time curl localhost:3001

test-go-grpc:
	@echo "Sending request to go-grpc service..." && \
	time grpcurl --plaintext localhost:3002 HelloWorld.Speak

test-node-http:
	@echo "Sending request to node-http service..." && time curl localhost:3003

.PHONY: clean
clean:		## Clean all the data created
	@rm -rf php/vendor
