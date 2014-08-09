#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : run sql scripts to create/populate meatballs DB
# 
# NOTES : works with BASH, not with DASH (arrays not supported, change your default shell!)
#
#******************************************************************************


USER="root"
HOST="127.0.0.1"
PWORD=''

SCRIPTS=('create_table.sql' 'populate.sql' 'staffgen.sql');

function display_usage
{
    echo "To be run from the root of the project"
}

cd ./sql

for file in ${SCRIPTS[@]} 
do
    echo -n "[initDb.sh] executing $file ..."
    mysql -u $USER --password="$PWORD" -h $HOST < $file || (display_usage)
    echo "... OK"
done
cd ../
