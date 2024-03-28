FROM node:hydrogen-slim

WORKDIR /app

COPY ./package*.json ./
RUN npm install

CMD ["npm", "run", "serve"]