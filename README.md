# figonacci-phpactorial

## Introduction

Imagine a big PHP application that started as a big monolith. After some refactoring many PHP services started to arise. The big monolith starts calling those other PHP services via HTTP/S. When performance is a must, this architecture does not scale well as the number of services increase. Each call to a PHP service adds many valuable milliseconds that cannot be afforded. After all this process you consider two options:

1. Reduce the number of ~micro~ services and going back to the big monolith you had initially.
2. Stop developing new features and start recreating your whole application using a new technology stack, thus losing a lot of time and introducing many new bugs. Or even worse, maintaining two "equal" applications.

In this repository some solutions to this common architectural scenario are explored.

## Methology

The scenarios presented in this repository asume the desire to replace a module of an application with a clearly defined interface and a logic independent of other modules. As an example of this, is the function `FibFac(x) = Fibonacci(x) + Factorial(x)`. This problem has been chosen and implemented vaguely on purpose to represent a CPU intensive logic.

The following scenarios are considered:

![scenarios](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/scenarios.png)

### Local PHP

This represents the original monolith the application might look like. All the logic of the different modules is placed in code locally to the application entry point.

![local-php](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/local-php.png)

You can find the code for this approach [here](https://github.com/davizuku/figonacci-phpactorial/blob/master/php/client/LocalClient.php)

This code is run on the `client` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)

### HTTP PHP

In this scenario, a local interface is executed in a remote server via HTTP requests. Still all the code in both sides is PHP.

![http-php](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/http-php.png)

You can find the code for this approach [here](https://github.com/davizuku/figonacci-phpactorial/blob/master/php/server/index.php)

This code is run on the `php-http` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)


### HTTP GO + PHP

Remote service runs GO only to handle HTTP requests & responses. However, the logic of the replaced module still runs on PHP.

![http-go-php](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/http-go-php.png)

You can find the HTTP go service in [this file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/cmd/http.go). The endpoint for this scenario is `/fibfac-php`

This code is run on the `go-http` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)

### HTTP GO

Remote service runs exclusively GO and communications are performed via HTTP requests.

![http-go](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/http-go.png)

You can find the HTTP go service in [this file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/cmd/http.go). The endpoint for this scenario is `/fibfac`

This code is run on the `go-http` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)

### GRPC GO+PHP

Remote service does not runs GO only to handle GRPC requests & responses. However, the logic of the replaced module still runs on PHP.

![grpc-go-php](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/grpc-go-php.png)

You can find the GRPC go service in [this file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/cmd/grpc.go). This service is described in [this proto file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/api/benchmark.proto) and the method that corresponds to this scenario is `Benchmark.FibFacPhp`.

This code is run on the `go-grpc` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)


### GRPC GO

Remote service runs exclusively GO and communications are performed via HTTP requests.

![grpc-go](https://github.com/davizuku/figonacci-phpactorial/raw/master/img/grpc-go.png)

You can find the GRPC go service in [this file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/cmd/grpc.go). This service is described in [this proto file](https://github.com/davizuku/figonacci-phpactorial/blob/master/golang/api/benchmark.proto) and the method that corresponds to this scenario is `Benchmark.FibFac`.

This code is run on the `go-grpc` service of the [docker-compose file](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml)


## Benchmark

The benchmark consists of a series of repetitions or `epochs` of the process of computing `FibFac(x)` for `x` from 1 to `max-value`. Randomization is performed on each epoch to avoid possible optimizations on repeated calls to the same service.

Data is collected into a CSV file and then it is processed by the `painter` [service](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml) to generate a final graph of the benchmarks.

Execute `make benchmark` to reproduce the results on this page.

For example, after executing `make benchmark readme-example 1 3`, you should see something similar to:

```
Starting to generate CSV file...

architecture,method,param,value,time
localPhp,fibFac,2,4,0.012269020080566
httpGo,fibFac,2,4,0.13835000991821
httpPhp,fibFac,2,4,0.89593195915222
httpGoPhp,fibFac,2,4,0.30547308921814
grpcGoPhp,fibFac,2,4,0.31886720657349
grpcGo,fibFac,2,4,0.00341796875
localPhp,fibFac,1,2,2.8848648071289E-5
httpGo,fibFac,1,2,0.0021929740905762
httpPhp,fibFac,1,2,1.0135419368744
httpGoPhp,fibFac,1,2,0.24810910224915
grpcGoPhp,fibFac,1,2,0.23761796951294
grpcGo,fibFac,1,2,0.0012149810791016
localPhp,fibFac,3,9,1.8119812011719E-5
httpGo,fibFac,3,9,0.0031158924102783
httpPhp,fibFac,3,9,0.77564311027527
httpGoPhp,fibFac,3,9,0.23479413986206
grpcGoPhp,fibFac,3,9,0.25522589683533
grpcGo,fibFac,3,9,0.0011210441589355

CSV file generated in:  ./benchmarks/readme-example.csv
Starting processing data...
PNG file generated in:  ./benchmarks/readme-example.png
```

## Results

The following data has been produced by the command `make benchmark example 10 30`. All the data is available under the `benchmarks` folder.

![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example.png)

As you can see, only pure GO services overpass `localPhp` implementation. However, the benefit of simply replacing the Request&Response management from PHP to GO represents 300% benefit in response time.

Moreover, GO easy parallelization capability makes its services more scalable as other implementations grow exponentially in time.

## Disclaimers

- `FibFac` implementation in GO include an optimization using go routines. This is an optimization taking profit of one of the limitations of PHP services, which is parallelism, as stated [here](https://github.com/krakjoe/pthreads#sapi-support)
- Memoization or other algorithmic optimizations have not been applied to the `FibFac` implementation to increase the CPU demand and simulate higher load to the services.
