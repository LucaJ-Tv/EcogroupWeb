FROM node:hydrogen-slim

WORKDIR /app

COPY . .
RUN npm install
RUN npm install -g @vue/cli
RUN vue build
#RUN npm install -g serve


# CMD ["npm", "run", "serve"]
# CMD ["vue-cli-service","build"]
# CMD ["vue-cli-service","build"]

# CMD [ "serve", "-s", "dist"]