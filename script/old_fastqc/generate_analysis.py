import sys

# 1: the dir to store the analysis script
# 2: the dir of the fastqc data
# 3: the dir of the output directory

script_dir = sys.argv[1]
input_data = sys.argv[2]
output_dir = sys.argv[3]

###
userName = output_dir.split("/")[-2]
###

f = open(script_dir + "run_fastqc.py", "w")
f.write("import os\n")
f.write("import sys\n")
f.write("os.system('fastqc -o {} {} > {}process.txt')\n".format(output_dir, input_data, script_dir))
f.write("print('run fastqc: ')\n")
f.write("print('fastqc -o {} {} > {}process.txt')\n".format(output_dir, input_data, script_dir))
f.write("os.system('cd {} && zip result.zip *')\n".format(output_dir))
f.write("os.system('cp /var/www/results/users/{usr}/result.zip /var/www/html/users/{usr}/ && cp /var/www/results/users/{usr}/*.html /var/www/html/users/{usr}/result.html')\n".format(usr = userName))

f.write("print('</br>')\n")
f.write("print('finished;')\n")
f.write("os.system('rm -rf {}')\n".format(input_data))

f.close()

