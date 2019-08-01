import os, sys

output_dir = sys.argv[1]
data_dir = sys.argv[2]
O = os.system('fastqc -q -o '+ output_dir + ' ' + data_dir)
#print('run fastqc: ')
#print('fastqc -o /var/www/results/users/lyr/ /var/www/upload/users/lyr/SRR12345678.fastq.gz > /var/www/script/process.txt')
#os.system('cd ' + output_dir + ' && zip result.zip ./*')
