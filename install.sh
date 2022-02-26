#!/bin/sh
green='\e[1;32m%s\e[0m\n'

set -e

clear
printf "$green" "###################################################################################################"
printf "$green" "# "
printf "$green" "# Awesome Technical Exam API Installer."
printf "$green" "# "
printf "$green" "# Do you want to install Awesome Technical Exam API Installer in your computer? [Y/n]?"
printf "$green" "# "
printf "$green" "###################################################################################################"
read -p "" choice

if [ "$choice" = "Y" ]; then
  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [1/8] Shut down existing  containers."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose down

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [2/8] Delete vendor/ bin/ folders."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  rm -Rf vendor/ bin/

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [3/8] Build docker images."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose build

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [4/8] Starting infrastructure dependencies."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose up -d redis
  docker-compose up -d mysql

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [5/8] Install PHP libraries."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose run --rm composer install

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [7/8] Start new containers as daemons."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose up -d exam

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# [8/8] Initialize database and seed data."
  printf "$green" "# "
  printf "$green" "#################################################################################################"
  sleep 5
  docker-compose run --rm php artisan migrate:fresh --seed

  echo ""
  echo ""
  printf "$green" "#################################################################################################"
  printf "$green" "# "
  printf "$green" "# Awesome Technical Exam API installed!"
  printf "$green" "# "
  printf "$green" "#################################################################################################"


fi
