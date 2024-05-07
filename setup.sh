#!/bin/bash

cd ecogroup

rm -r dist

vue build

docker compose up -d --build