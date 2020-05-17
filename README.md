# figonacci-phpactorial

## Introduction

Imagine a big PHP application that started as a big monolith. After some refactoring many PHP services started to arise. The big monolith starts calling those other PHP services via HTTP/S. When performance is a must, this architecture does not scale well as the number of services increase. Each call to a PHP service adds many valuable milliseconds that cannot be afforded. After all this process you consider two options:

1. Reduce the number of ~micro~ services and going back to the big monolith you had initially.
2. Stop developing new features and start recreating your whole application using a new technology stack, thus losing a lot of time and introducing many new bugs. Or even worse, maintaining two "equal" applications.

In this repository some solutions to this common architectural scenario are explored.

## Methodology

The scenarios presented in this repository asume the desire to replace a module of an application with a clearly defined interface and a logic independent of other modules. For generalization purposes two different problems have been chosen: FibFac and TextLen.

The first problem, FibFac, is a _CPU intensive_ algorithm that has been implemented naively for this purpose. As its name may imply, this function is described as follows:

```
FibFac(x) = Fibonacci(x) + Factorial(x)
```

The second problem, TextLen, is a _memory intensive_ algorithm designed to quickly generate a big response for a given number. In this case, `TextLen(x)` generate a random string of length `x`.

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

The benchmark consists of a series of repetitions or `epochs` of the process of computing `FibFac(x)` or `TextLen(2^x)` for `x` from 1 to `max-value`. Since each algorithm has different "limits" the argument `method` is used to choose which to benchmark. Randomization is performed on each epoch to avoid possible optimizations on repeated calls to the same service.

Data is collected into a CSV file and then it is processed by the `painter` [service](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml) to generate a final graph of the benchmarks.

Execute `make benchmark` to reproduce the results on this page.

For example, after executing `make benchmark readme-example fibfac 1 3`, you should see something similar to:

```
Starting to generate CSV file...

architecture,method,param,value,time
httpNode,fibFac,3,9,0.12454891204834
httpGoPhp,fibFac,3,9,0.46756601333618
grpcGoPhp,fibFac,3,9,0.32606291770935
httpPhp,fibFac,3,9,0.6788649559021
httpGo,fibFac,3,9,0.0075061321258545
localPhp,fibFac,3,9,0.031401872634888
httpNodePhp,fibFac,3,9,0.19814491271973
grpcGo,fibFac,3,9,0.0076329708099365
httpNode,fibFac,1,2,0.0048940181732178
httpGoPhp,fibFac,1,2,0.22060894966125
grpcGoPhp,fibFac,1,2,0.27100086212158
httpPhp,fibFac,1,2,0.46150016784668
httpGo,fibFac,1,2,0.00087499618530273
localPhp,fibFac,1,2,6.1988830566406E-6
httpNodePhp,fibFac,1,2,0.14736199378967
grpcGo,fibFac,1,2,0.0016500949859619
httpNode,fibFac,2,4,0.0049290657043457
httpGoPhp,fibFac,2,4,0.15628004074097
grpcGoPhp,fibFac,2,4,0.19772601127625
httpPhp,fibFac,2,4,0.42020702362061
httpGo,fibFac,2,4,0.0035560131072998
localPhp,fibFac,2,4,1.5974044799805E-5
httpNodePhp,fibFac,2,4,0.20602202415466
grpcGo,fibFac,2,4,0.0010449886322021

CSV file generated in:  ./benchmarks/readme-example-fibfac.csv
Starting processing data...
PNG files generated in:  - ./benchmarks/readme-example-fibfac.png
```

## Results

The following data has been produced by the following commands:
- `make benchmark example fibfac 10 30`
- `make benchmark textlen 10 7`

All the data is available under the `benchmarks` folder.

### FibFac

GO easy parallelization capability makes its services more scalable. As other implementations grow exponentially in time, the growth curve of GO services stays pretty flat.

![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example-fibfac.png)

Let's zoom in the common flat part for those calls under 30:

![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example-fibfac-le-30.png)

As you can see, only services not using PHP overpass `localPhp` implementation. However, the benefit of simply replacing the Request&Response management from PHP to GO or NodeJS reduces to less than 50% the response time with respect of `httpPhp` service.

Additionally, it can be observed that the more PHP is used, the more variable is the response time over network. Pure Node and GO services keep their response times stable and low for all the requests.

### TextLen

Again, GO growth curve is impressive compared to other implementations. In this problem, PHP memory management is quite poor and all services using PHP seem to converge for large inputs. Non-PHP services, grow more slowly and stable.

![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example-textlen.png)

Surprisingly, Node is not capable of keeping the scalability nor stability when calling PHP scripts during request time. For inputs above 2^25 it looks like PHP is getting more and more impact on the response time.

## Disclaimers

- `FibFac` and `TextLen` implementations in GO include an optimization using go routines. This is an optimization taking profit of one of the limitations of PHP services, which is parallelism, as stated [here](https://github.com/krakjoe/pthreads#sapi-support)
- Memoization or other algorithmic optimizations have not been applied to the `FibFac` implementation to increase the CPU demand and simulate higher load to the services.
- All services are running on local Dockers, so their response times should be higher in real scenarios compared to `localPhp`. However, these benchmarks focus not only on response times but also on scalability. After all, all "non-local" services run under the same conditions and transfer the same amount of data, so the comparisons between them are still valid.
