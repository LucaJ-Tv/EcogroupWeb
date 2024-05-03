#!/bin/bash

cd ecogroup

rm dist -rf

vue build

docker compose up -d --build