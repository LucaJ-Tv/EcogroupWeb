FROM node:hydrogen-slim
# Imposta il working directory

# Copia il package.json e il package-lock.json nella directory di lavoro
WORKDIR /www

COPY ./ecogroup/package*.json ./

# Installa le dipendenze del progetto
RUN npm install

# Copia il resto del codice nella directory di lavoro
COPY ./ecogroup .

# Esponi la porta 8080 
EXPOSE 8080

# Comando predefinito
CMD ["npm", "run", "serve"]
