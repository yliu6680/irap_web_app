
import sys, getopt, os
import pandas as pd

def usage():
	print("""A script to generate a configuration file for the irap pipeline: 
		all options are corresponded to the irap configuration file at github: https://github.com/nunofonseca/irap/wiki/8-Configuration-file
		some para of the conf file:
		-p --name                    : str, name of the project run with irap.
		-s --species                 : str, species name of the data, should be fastqc or bam file.
		-r --reference               : str, reference file name of the data, should be fasta file .
		-g --gtf_file                : str, reference file name of the data, should be gtf file.
		-u --user_trans              : auto, whether trimming the bad quality data. ?user_trans_biotype ?cdna_file
		-d --data_dir                : str, top directiory with the data, should include raw data, reference, contamination (if applicable) data.
		-c --cont_index              : yes, no, whether use the contamination set, contamination dataset should include in the data_dir, default no.
		
		some para of the irap running:
		-m --mapper                  : str, alignment method, e.g. STAR, bowtie1 (default), bowtie2
		-q --quant_method            : str, quantification method, e.g., featurecount, htseq2 (default)
		--quant_norm_tool            : str,e,g, (irap|kallisto|nurd|...|none), default irap 
		--quant_norm_method          : str, normalization method to use (fpkm|uq-fpkm|fpkm-uq|deseq_nlib|tpm|none), default fpkm
		-e --de_method               : str, e.g. deseq2 (default), edgeR.
		--gene_de_min_count          : default 0.
		--transcript_de_min_count    : default 0.
		--exon_de_min_count          : default 0.

		parameters of the user name and directory of the script are in args: [1]:template directory , [2]:out put directory. *** dirs should be full paths or base on the current work dir.

		other para:
		-h --help                    : help
		-t --template_dir            : template file directory, couldn't be none
		-o --output_dir              : output file directory, couldn't be none
		-a --meta_data               : meta_data directory, couldn't be none if do de analysis
		""")

def manipulate_args():
	"""
	manipulate the args and options in the script input
	"""
	# 1st part parameters
	name, species, reference, gtf_file, user_trans, data_dir, cont_index = None, None, None, None, "auto", "$(IRAP_DIR)/data/", "no"
	
	# 2nd part parameters
	mapper, quant_method, quant_norm_tool, quant_norm_method, de_method, gene_de_min_count, transcript_de_min_count, exon_de_min_count = "bowtie1", "htseq2", "irap", "fpkm", "deseq2", 0, 0, 0

	# other para
	template_dir, output_dir, meta_data = None, None, None

	try:
		opts, args = getopt.getopt(sys.argv[1:], "n:s:r:g:u:d:c:m:q:e:ht:o:a:", ["name=", "species=", "reference=", "gtf_file=", "user_trans=", "data_dir=", "cont_index=", "mapper=", "quant_method=", "quant_norm_tool=", "quant_norm_method=", "de_method=", "gene_de_min_count=", "transcript_de_min_count=", "exon_de_min_count=", "help", "template_dir=", "output_dir=", "meta_data="])
		for o, a in opts:
			if o in ("-h", "--help"):
				usage()
				sys.exit(0)

			# 1st part para
			elif o in ("-n" , "--name"):
				name = a
			elif o in ("-s" , "--species"):
				species = a
			elif o in ("-r" , "--reference"):
				reference = a
			elif o in ("-g" , "--gtf_file"):
				gtf_file = a
			elif o in ("-u" , "--user_trans"):
				user_trans = a
			elif o in ("-d" , "--data_dir"):
				data_dir = a
			elif o in ("-c" , "--cont_index"):
				cont_index = a
			
			# 2nd part para
			elif o in ("-m" , "--mapper"):
				mapper = a
			elif o in ("-q" , "--quant_method"):
				quant_method = a
			elif o in ("--quant_norm_tool"):
				quant_norm_tool = a
			elif o in ("--quant_norm_method"):
				quant_norm_method = a
			elif o in ("-e", "--de_method"):
				de_method = a
			elif o in ("--gene_de_min_count"):
				gene_de_min_count = a
			elif o in ("--transcript_de_min_count"):
				transcript_de_min_count = a
			elif o in ("--exon_de_min_count"):
				exon_de_min_count = a

			# other para
			elif o in ("-t", "--template_dir"):
				template_dir = a
			elif o in ("-o", "--output_dir"):
				output_dir = a
			elif o in ("-a", "--meta_data"):
				meta_data = a

			else:
				pass

	except getopt.GetoptError as err:
		print(err)  
		usage()
		sys.exit(2)

	# sys.exit(2)
	#print(opts)
	#print(args)
	#print(name, species, reference, gtf_file, user_trans, data_dir, cont_index, mapper, quant_method, quant_norm_tool, quant_norm_method, de_method, gene_de_min_count, transcript_de_min_count, exon_de_min_count, meta_data)

	temp_dict = {"name" : name, "species": species, "reference": reference, "gtf_file": gtf_file, "user_trans": user_trans, "data_dir": data_dir, "cont_index": cont_index, "mapper": mapper, "quant_method": quant_method, "quant_norm_tool": quant_norm_tool, "quant_norm_method": quant_norm_method, "de_method": de_method, "gene_de_min_count": gene_de_min_count, "transcript_de_min_count": transcript_de_min_count, "exon_de_min_count": exon_de_min_count, "template_dir": template_dir, "output_dir": output_dir, "meta_data": meta_data}
	#temp_list = [project_name, species, reference, gtf_file, user_trans, data_dir, cont_index, mapper, quant_method, quant_norm_tool, quant_norm_method, de_method, gene_de_min_count, transcript_de_min_count, exon_de_min_count]

	return temp_dict

def generate_conf(value_dict):
	"""
	write the conf file, use the template conf file
	"""
	template_dir, output_dir = value_dict['template_dir'], value_dict['output_dir']

	if template_dir == None or output_dir == None:
		return ValueError("Empty template file or output file directory")

	# template file
	f1 = open(template_dir, "r")
	lines1 = f1.readlines()
	f1.close()

	# write the file

	keys = list(value_dict.keys())

	f2 = open(output_dir, "w")
	for line in lines1:
		for k in keys:
			if line.find(k) != -1:
				line = line.format(value_dict[k])
		f2.write(line)
	f2.close()

	return "sucess; and write the file to {}".format(output_dir)

#import pandas as pd
#meta_file = "C:/Users/liuyu/Desktop/Spring2019/bidmc/html/scripts/meta_data.csv"
#output_dir = "C:/Users/liuyu/Desktop/Spring2019/bidmc/html/scripts/0708_new.conf"

def add_de_conf(value_dict):
	# read data
	output_dir, meta_file = value_dict['output_dir'], value_dict['meta_data']
	meta_data = pd.read_csv(meta_file)
	# seq type for each library
	seq_type = list(map(lambda x:x.lower(), meta_data['LibraryLayout'].tolist()))
	# file names in fastq1 fastq2 with the input index oreder
	fastqfile1, fastqfile2 = meta_data['fastq1'].tolist(), meta_data['fastq2'].tolist()
	# all conditions, oredered by the input index
	condition = meta_data['condition'].tolist()

	"""
	from the irap conf wiki, we could find that the de has 4 levels para.
	* contrat: it contain comaprisons between different conditions
	* condition (group): it could contain multiple libraries in one condition
	* libarary: it contain fastq files, if single seq, then one file; if paired seq, than two fastq files
	* fastq file: it correspond to one input file in the meata data fastq1 and fastq2 columns
	
	Therefore, I wnat to use dicts and lists to store these information, it will help to write the de part conf file
	
	1.
	I want to want to put fastq files in to a libarayFastqMap dict
	Put all libraries to a conditionLibaryMap dict
	
	2.
	After that, I want to store all lines I want to add behind the former conf file into a deDict
	Then generate the condition we want to compare into a contrasts string
	
	3.
	Finally, we could use the lines we have already saved in the deDict, and write all these lines into the conf file
	"""
    
    # libraryFastqMap: dict to correspond every fastq to one library, number of fastq files could be 1 for single seq or 2 for paired seq
    # groupLibraryMap: dict to correspond every library to one group, bumber could be various.
    # tempFstq, tempGroup: some temp variable during for loop
    # seqTypes: dict to correspond every libry to its types, only 2 keys in this dict (se, pe).
	libraryFastqMap, groupLibraryMap, tempFstq, tempLib, tempGroup, seqTypes = {}, {}, [], "", "", {'se':[], 'pe':[]}

	# handle the single and paired sequencing methods
	# each for loop will be a library, want to store them into the library fastq map, and condition library map.
	for i in range(len(seq_type)): 
		# create the library name, useful when we write the file
		tempLib = "Lib" + str(i)

		if seq_type[i] == 'single':
			tempFstq = [fastqfile1[i]]
			seqTypes['se'].append(tempLib)
		elif seq_type[i] == 'paired':
			tempFstq = [fastqfile1[i], fastqfile2[i]]
			seqTypes['pe'].append(tempLib)
		else:
			raise ValueError('meta data file LibraryLayout column should be "single" or "paired";')

		# add fastq files for each library, just append it, because each for loop, library name is unique
		libraryFastqMap[tempLib] = tempFstq

		# the correspond condition for this library sample
		tempGroup = condition[i]
		# add library for each condition, if have key just append it, if not create a new key 
		groupLibraryMap[tempGroup] = groupLibraryMap.get(tempGroup, []) + [tempLib]

	# after this step, we only need to manipulate the groupLibraryMap and libraryFastMap

	##########################################################
	##########################################################
	# this dic contains all lines need to be wrote on the conf, all string include the '\n' (***)
	deDict = {
		"contrasts": [],   # contrasts contain groups; just one line to show the comparisons want to perform
		"groups": [],  
		"seq_type": [],    # groups conatin libraries; lines to describe each group, each group only has one line to describe
		"libiraies": {}   # libraries contain fastq files; the dict contain lines that declare fastq in the lib, and their stat
	}

	# functions to parse the input data
	def __parse_maps(inputMap, key):
		tempList, tempStr = [], ""   # store lines that declare one library
		
		# store the first line: myLib3=f3_1.fastq f3_2.fastq
		tempStr = str(key) + "="           ### might be write as inner function and update decorator
		for f in inputMap[key]:
			tempStr += str(f) + " "
		tempStr += "\n"
		tempList.append(tempStr)
		return tempList

	# add fastq information for the library
	def add_fastq_info(parse_fun):
		def wrapper(inputMap, key):
			lines = parse_fun(inputMap, key)
            
			lines.append(str(key) + "_rs=50\n")
			lines.append(str(key) + "_qual=33\n")
			return lines
		return wrapper

	# add a blank line in the end
	def add_blank_line(parse_fun):
		def wrapper(inputMap, key):
			lines = parse_fun(inputMap, key)
            
			lines.append("\n")
			return lines
		return wrapper
    
	@add_blank_line
	@add_fastq_info
	def __parse_libraryFastqMap(inputMap, key):
		lines = __parse_maps(inputMap, key)
		return lines
    
    # could also parse the seqTypes dict
	@add_blank_line
	def __parse_groupLibraryMap(inputMap, key):
		lines = __parse_maps(inputMap, key)
		return lines

	# a final function could parse all data into the deDict, and get ready to write into the conf file
	# if the key of the deDict corresponds to a list object, __parse_groupLibraryMap will be used
	# if the key of the deDict corresponds to a dict object, __parse_libraryFastqMap will be used, only happen when writing fastq information
	def parseToDeDict(deDict, inputMap, deDict_key):
		for index, key in enumerate(inputMap.keys()):
			if type(deDict[deDict_key]) == type([]):
				tempLine = __parse_groupLibraryMap(inputMap, key)
				deDict[deDict_key] = deDict.get(deDict_key) + tempLine
			elif type(deDict[deDict_key]) == type({}):
				tempLine = __parse_libraryFastqMap(inputMap, key)
				deDict[deDict_key][key] = tempLine
			else:
				raise TypeError("invalid data type in deDict;")
	#@add_blank_line
	#def parse_seqTypes(inputMap, key):
	#	lines = __parse_maps(inputMap, key)
	#	return lines

	# 1
	## declare the sequencing types of the libraries.
	## se = Lib1 Lib2 # for single end
	## pe =           # for paried end
	## leave blank if there is only one seq type i.e. se= or pe=

	parseToDeDict(deDict, seqTypes, 'seq_type')

#	for index, key in enumerate(seqTypes.keys()):
#		tempType = parse_groupLibraryMap(seqTypes, key)
#		if type(deDict["seq_type"] == type([])):
#			deDict["seq_type"] = deDict.get('seq_type') + tempType

	# 2
	# prepare write from small to large, firstly, the describtion of library
	"""
	## Paired-end
	## LibName=Fastq files
	myLib3=f3_1.fastq f3_2.fastq
	## read size
	myLib3_rs=50
	## quality encoding (33 or 64)
	myLib3_qual=33
	## insert size
	myLib3_ins=350
	## standard deviation
	myLib3_sd=60
	"""
	parseToDeDict(deDict, libraryFastqMap, 'libiraies')

#	for index, key in enumerate(libraryFastqMap.keys()):
#		tempLib = parse_libraryFastqMap(libraryFastqMap, key)
#		deDict["libiraies"][key] = tempLib

	# 3 then the group definition
	"""
	# groups
	## GroupName= Library_name [Library_name ...]
	Purlple=myLib1 myLib2
	Pink=myLib3
	Grey=myLib4
	"""
	parseToDeDict(deDict, groupLibraryMap, 'groups')

#	for index, key in enumerate(groupLibraryMap.keys()):
#		tempGroup = parse_groupLibraryMap(groupLibraryMap, key)
#		deDict["groups"] = deDict.get('groups') + tempGroup

	# 4 finally the contracts definition
	"""
	## definition of each constrast
	#contrast= group group [ group ...]
	#purlpleVsPink=Purple Pink
	#purlpleVsGrey=Purple Grey
	""" 
	# we need more information to change this method to a handle more general cases, currently, only consider 2 conditions
	uniCondition = list(groupLibraryMap.keys())
	constrastGroupMap = {0: uniCondition[:2]}
	group1, group2 = constrastGroupMap[0][0], constrastGroupMap[0][1]
	groupVsGroup1, groupVsGroup2 = group1 + "Vs" + group2, group2 + "Vs" + group1
	l1 = "contrasts=" + groupVsGroup1 + " " + groupVsGroup2 + "\n"
	l2 = groupVsGroup1 + "=" + group1 + " " + group2 + "\n"
	l3 = groupVsGroup2 + "=" + group2 + " " + group1 + "\n"
	deDict["contrasts"] += [l1, l2, l3]

	# functions used to write conf file
	# iterate every lines in a list object
	def iter_write(f, list_object):
		for line in list_object:
			f.write(line)

	# write the conf by using the lines stored in the deDict
	f = open(output_dir, "a+")
	f.write("\n")
	iter_write(f, deDict['contrasts'])
	f.write("\n")
	iter_write(f, deDict['groups'])
	iter_write(f, deDict['seq_type'])
	for k, v in deDict['libiraies'].items():
		iter_write(f, v)
	f.close()
	return "sucess; and add differential expression para to the configuration file;"

def add_de_conf_old(value_dict):
	output_dir, meta_file = value_dict['output_dir'], value_dict['meta_data']
	meta_data = pd.read_csv(meta_file)
	samples = meta_data['samples'].tolist()
	treatment = meta_data['treatment'].tolist()
	new_dict = dict()
	conds = meta_data['treatment'].unique().tolist()
	for i in range(len(conds)):
		new_dict[conds[i]] = []
	for i in range(len(samples)):
		new_dict[treatment[i]].append(("F" + str(i), samples[i]))

	# start writing    
	
	f = open(output_dir, "a+")
	f.write('contrasts=' + conds[0] + 'vs' + conds[1] + ' ' + conds[1] + 'vs' + conds[0] + '\n')
	f.write(conds[0] + 'vs' + conds[1] + '=' + conds[0] + ' ' + conds[1] + '\n')
	f.write(conds[1] + 'vs' + conds[0] + '=' + conds[1] + ' ' + conds[0] + '\n')

	# prepare writing part of the file
	conds_0, conds_1, se = conds[0] + '=', conds[1] + '=', 'se='
	for i in range(len(new_dict[conds[0]])):
		conds_0 += new_dict[conds[0]][i][0] + ' '
		se += new_dict[conds[0]][i][0] + ' '
	for i in range(len(new_dict[conds[1]])):
		conds_1 += new_dict[conds[1]][i][0] + ' '
		se += new_dict[conds[1]][i][0] + ' '
    
	# continue writing
	f.write(conds_0 + '\n')
	f.write(conds_1 + '\n')
	f.write(se + '\n')

	# writing last part of the file
	for COND in conds:
		temp = new_dict[COND]
		for t in temp:
			f.write(t[0] + '=' + t[1] + '\n')
			f.write(t[0] + '_rs=50' + '\n')
			f.write(t[0] + '_qual=33' + '\n')
	f.close()
	
	return "sucess; and add differential expression para to the configuration file;"

def main():
	input_dict = manipulate_args()
	#print(input_dict)
	ret = generate_conf(input_dict)
	print(ret)
	ret = add_de_conf(input_dict)
	print(ret)

if __name__ == '__main__':
	main()
