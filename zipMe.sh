#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : creates the package to deliver
#
# NOTES : group3.zip will be saved in you home directory
#
#******************************************************************************
#
# Project Submission
# 
# Only one member of the group needs to submit the final materials. All material should be organized  as follows. 
# On your local machine, create a folder using your group name (e.g., "group1"). 
#
# Inside this folder, add the README file that lists the contributions of each member, along with any other 
# information or highlights you think might be useful.
# 
# Inside the main folder, add the following subfolders:
# 
# ./source: your PHP source code
# 
# ./gui: a complete set of screen shots showing what your system actually does
# 
# ./report: sample output from your major reports
# 
# ./diagrams: the relational diagrams that support your design
# 
# Package the entire directory structure into a zip file called group#.zip. 
# This file should be submitted by the end of the demo day (i.e., August 25th). 
# Note that for the graphics files, you should use a standard format like jpg or png so 
# that the files are not too large. 
# There is a maximum submission size of 50 MB for the zip file. 
# 
# 

NAME=group3
ZIP_FILE=$NAME.zip
FILES="$NAME"
EXCLUDE_LIST="src/utls/exclude_file.txt"


rsync -a . ~/$NAME/ --exclude-from $EXCLUDE_LIST

#
# cd to home directory
#
pushd .
cd ~

if [ -f $ZIP_FILE ]; then
    rm $ZIP_FILE
fi


zip -r --quiet $ZIP_FILE $FILES 

#
# remove the temporary directory
#
rm -fr $NAME
popd

echo "[zipMe.sh] $ZIP_FILE has been saved to your HOME directory";
