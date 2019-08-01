#!bin/bash
#IRAP_DIR='/home/ubuntu/irap/irap_install'

data_dir=$1
species=$2
username=$3

reference_dir=$data_dir/data/reference/$species
raw_data_dir=$data_dir/data/raw_data/$species

mkdir -p $reference_dir
mkdir -p $raw_data_dir

# get the genome data
cp /home/ubuntu/genome_data/$species/*.gtf $reference_dir/$species.gtf

cp /home/ubuntu/genome_data/$species/*.fa.gz $reference_dir/$species.fa.gz

# get the raw data
ln -s $data_dir/*fastq* $raw_data_dir

# set up irap environment
# source /home/ubuntu/irap/irap_install/irap_setup.sh
