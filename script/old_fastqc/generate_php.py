import sys

templatePhp = sys.argv[1]
userName = sys.argv[2]

# template file
f1 = open("/var/www/html/" + templatePhp, "r")
lines1 = f1.readlines()
f1.close()

f2 = open("/var/www/html/users/" + userName + "/" + templatePhp, "w")
for line in lines1:
    if line.find("users/{usr}/") != -1:
        line = line.format(usr = userName)
    f2.write(line)
f2.close()



