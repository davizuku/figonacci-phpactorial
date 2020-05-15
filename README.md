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

The benchmark consists of a series of repetitions or `epochs` of the process of computing `FibFac(x)` for `x` from 1 to `max-value`. Randomization is performed on each epoch to avoid possible optimizations on repeated calls to the same service.

Data is collected into a CSV file and then it is processed by the `painter` [service](https://github.com/davizuku/figonacci-phpactorial/blob/master/docker-compose.yml) to generate a final graph of the benchmarks.

Execute `make benchmark` to reproduce the results on this page.

For example, after executing `make benchmark readme-example 1 3`, you should see something similar to:

```
Starting to generate CSV file...

architecture,method,param,value,time
httpPhp,fibFac,3,9,0.94866299629211
httpPhp,textLen,10^3,1000,0.69463205337524
httpGo,fibFac,3,9,0.022700071334839
httpGo,textLen,10^3,1000,0.0052220821380615
httpGoPhp,fibFac,3,9,0.2314510345459
httpGoPhp,textLen,10^3,1000,0.18640899658203
localPhp,fibFac,3,9,0.026846170425415
localPhp,textLen,10^3,1000,0.018160820007324
grpcGo,fibFac,3,9,0.07497501373291
grpcGo,textLen,10^3,1000,0.020685911178589
grpcGoPhp,fibFac,3,9,0.25618886947632
grpcGoPhp,textLen,10^3,1000,0.24194407463074
httpPhp,fibFac,1,2,0.83478808403015
httpPhp,textLen,10^1,10,0.69294595718384
httpGo,fibFac,1,2,0.0020709037780762
httpGo,textLen,10^1,10,0.0014779567718506
httpGoPhp,fibFac,1,2,0.21976208686829
httpGoPhp,textLen,10^1,10,0.23144197463989
localPhp,fibFac,1,2,1.5974044799805E-5
localPhp,textLen,10^1,10,2.8133392333984E-5
grpcGo,fibFac,1,2,0.0011518001556396
grpcGo,textLen,10^1,10,0.012670993804932
grpcGoPhp,fibFac,1,2,0.14927291870117
grpcGoPhp,textLen,10^1,10,0.20850610733032
httpPhp,fibFac,2,4,0.35487985610962
httpPhp,textLen,10^2,100,0.34541583061218
httpGo,fibFac,2,4,0.0022380352020264
httpGo,textLen,10^2,100,0.0027408599853516
httpGoPhp,fibFac,2,4,0.23408722877502
httpGoPhp,textLen,10^2,100,0.22459983825684
localPhp,fibFac,2,4,1.6927719116211E-5
localPhp,textLen,10^2,100,0.00040078163146973
grpcGo,fibFac,2,4,0.0035159587860107
grpcGo,textLen,10^2,100,0.014184951782227
grpcGoPhp,fibFac,2,4,0.183758020401
grpcGoPhp,textLen,10^2,100,0.2317910194397

CSV file generated in:  ./benchmarks/readme-example.csv
Starting processing data...
PNG files generated in:
     - ./benchmarks/fibFac-readme-example.png
     - ./benchmarks/textLen-readme-example.png
```

## Results

The following data has been produced by the command `make benchmark example 10 30` for `FibFac` and `make benchmark 10 7` for `TextLen`. All the data is available under the `benchmarks` folder.

![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example-fibfac.png)
![results](https://github.com/davizuku/figonacci-phpactorial/raw/master/benchmarks/example-textlen.png)

As you can see, only pure GO services overpass `localPhp` implementation. However, the benefit of simply replacing the Request&Response management from PHP to GO represents 300% benefit in response time.

Moreover, GO easy parallelization capability makes its services more scalable as other implementations grow exponentially in time.

## Disclaimers

- `FibFac` and `TextLen` implementations in GO include an optimization using go routines. This is an optimization taking profit of one of the limitations of PHP services, which is parallelism, as stated [here](https://github.com/krakjoe/pthreads#sapi-support)
- Memoization or other algorithmic optimizations have not been applied to the `FibFac` implementation to increase the CPU demand and simulate higher load to the services.
