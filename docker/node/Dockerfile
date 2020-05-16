FROM node

# Install PHP for using php from Node as a part of the benchmarking
RUN apt-get update -y && apt-get install -y php

RUN npm install supervisor -g

ENTRYPOINT ["supervisor", "-w /node-http", "/node-http/index.js"]
