#!/bin/bash
python3 generate_conf.py --name=project1 --species=human --reference=reference.fasta --gtf_file=file.gtf --user_trans=auto --data_dir=/data/ --cont_index=no --mapper=star --quant_method=cufflinks2 --quant_norm_tool=irap --quant_norm_method=fpkm --de_method=cuffdiff2 --template_dir=/var/www/script/irap_conf_template.conf --output_dir=/home/ubuntu/temp_upload/0614_irap_conf.conf


