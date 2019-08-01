import sys
import os

userName = sys.argv[1]

os.system("mkdir -p /var/www/html/users/" + userName)
os.system("mkdir -p /var/www/data/users/" + userName)
os.system("mkdir -p /var/www/result/users/" + userName)
#os.system("mkdir -p /var/www/upload/users/" + userName)
#os.system("mkdir -p /var/www/script/users/" + userName)
