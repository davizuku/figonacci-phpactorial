#!/bin/bash

if [[ $# -ne 4 ]]; then
    echo "Usage: benchmark <filename> <method> <num-epochs> <max-value> <method>";
    exit;
fi

FILENAME="$1-$2"
echo -e "Starting to generate CSV file...";
echo -e "\033[0;90m" && \
docker-compose exec client php benchmark.php --method $2 --epochs $3 --max_value $4 | tee ./benchmarks/$FILENAME.csv;
echo -e "\033[0;0m";
echo -e "CSV file generated in: \033[1;32m ./benchmarks/$FILENAME.csv \033[0;0m";
echo -e "Starting processing data...";
docker-compose run painter python processBenchmark.py $FILENAME;
echo -e "PNG files generated in: \033[1;32m - ./benchmarks/$FILENAME.png \033[0;0m";
