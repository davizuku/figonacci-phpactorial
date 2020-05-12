#!/bin/bash

if [[ $# -le 2 ]]; then
    echo "Usage: benchmark <filename> <num-epochs> <max-value> <method>";
    exit;
fi

echo -e "Starting to generate CSV file...";
echo -e "\033[0;90m" && \
docker-compose exec client php benchmark.php --epochs $2 --max_value $3 --method $4 | tee ./benchmarks/$1.csv;
echo -e "\033[0;0m";
echo -e "CSV file generated in: \033[1;32m ./benchmarks/$1.csv \033[0;0m";
echo -e "Starting processing data...";
docker-compose run painter python processBenchmark.py $1 $4;
echo -e "PNG file generated in: \033[1;32m ./benchmarks/$1.png \033[0;0m"
