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
	@docker-compose run --rm php-http composer install
.PHONY: down
down:		## Stop the containers
	@docker-compose down

.PHONY: benchmark
benchmark: 	## Execute benchmark <filename>
	@echo "Starting to generate CSV file..." && \
	echo "\033[0;90m" && \
	docker-compose exec client php benchmark.php --epochs 1 --max_value 1 | tee ./benchmarks/$(call args,example).csv && \
	echo "\033[0;0m" && \
	echo "CSV file generated in: \033[1;32m ./benchmarks/$(call args,example).csv \033[0;0m" && \
	echo "Starting processing data..." && \
	docker-compose run painter python processBenchmark.py $(call args,example) && \
	echo "PNG file generated in: \033[1;32m ./benchmarks/$(call args,example).png \033[0;0m"

.PHONY: test
test: test-php-http test-go-http test-go-grpc		## Execute test

test-php-http:
	@echo "Sending request to php-http service..." && time curl localhost:3000

test-go-http:
	@echo "Sending request to go-http service..." && time curl localhost:3001

test-go-grpc:
	@echo "Sending request to go-grpc service..." && \
	time grpcurl --plaintext localhost:3002 HelloWorld.Speak

.PHONY: clean
clean:		## Clean all the data created
	@rm -rf php/vendor
