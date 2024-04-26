# Dockerfile for the backend service

# Usa l'immagine base di tomsik68/xampp
FROM tomsik68/xampp

# Copia la cartella dist (risultato del build Vue.js) nel backend
COPY ./backend/src /www
COPY ./ecogroup/dist /www
