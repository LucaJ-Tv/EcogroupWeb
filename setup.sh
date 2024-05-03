#!/bin/bash

if [ -d "/backend/src/dist" ]; then
    echo prova
    rm dist -rf
fi

cd ecogroup

vue build

docker compose up -d --build