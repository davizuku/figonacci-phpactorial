FROM node

RUN npm install supervisor -g
RUN npm install

ENTRYPOINT ["supervisor", "-w /node-http", "/node-http/index.js"]
