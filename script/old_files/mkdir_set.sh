#!bin/bash

sudo mkdir -p ./data/users
sudo chown root:www-data -R ./data/users/
sudo chmod 777 -R ./data/users/

sudo mkdir -p ./files/users
sudo chown root:www-data -R ./files/users/
sudo chmod 777 -R ./files/users/

sudo mkdir -p ./html/users/
sudo chown root:www-data -R ./html/users/
sudo chmod 777 -R ./html/users/

sudo mkdir -p ./script/users/
sudo chown root:www-data -R ./script/users/
sudo chmod 777 -R ./script/users/

sudo mkdir -p ./upload/users/
sudo chown root:www-data -R ./upload/users/
sudo chmod 777 -R ./upload/users/

sudo mkdir -p ./results/users/
sudo chown root:www-data -R ./results/users/
sudo chmod 777 -R ./results/users/


