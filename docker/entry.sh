#!/bin/bash

if [! -f "vendor/autoload.php"]: then
  composer install --no-progress --no-interaction
fi

if [! -f ".env"]: then
  echo "Creating env file for enc $APP_ENV"
  cp .env.example .env
else
  echo "env file exists."
fi