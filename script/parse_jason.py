import json, sys

usr = sys.argv[1]
case_id = sys.argv[2]

json_dir = "/var/www/html/users/" + usr + '/' + case_id + '/' + 'irap_options.json'
print(json_dir)

with open('irap_options.json') as f:
    content = json.load(f)
    f.close()

conds = list(content['meta_dict']['cond_lib'].keys())
tsv_file_name = conds[0] + 'Vs' + conds[1] + '.genes_de.tsv'
root_dir = "/var/www/html/users/" + usr + '/' + case_id + '/' + content['name'] + '/'
de_dir = 'irap_qc/' + content['method_dict']['mapper'] + '/' + content['method_dict']['quantification'] + '/' + content['method_dict']['de_method'] + '/'

tsv_dir = root_dir + de_dir + tsv_file_name
print(tsv_dir)