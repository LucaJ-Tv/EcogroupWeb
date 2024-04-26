# Usa un'immagine di base di Node.js
FROM node:latest

WORKDIR /www/

COPY ./ecogroup/package*.json ./
COPY ./ecogroup/dist/ ./dist


RUN npm install
RUN npm install -g serve

CMD ["serve", "-s", "dist"]
