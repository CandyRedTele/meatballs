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

SCRIPTS=('create_table.sql' 'pay.sql' 'menu_item.sql' 'supply.sql' 'ingredients.sql' 'menu.sql' 'wine.sql' 'food.sql' 'staffgen.sql' 'gen_facility.sql' 'gen_facilityHours.sql')
TEMPO=tempo

function display_usage
{
    echo "To be run from the root of the project";
    exit
}

cd ./sql

mkdir -p $TEMPO 

cp *.sql $TEMPO

#
# copy all sql un 
#
for dir in $(ls -d */); do
    if [ $dir != "tempo/" ]; then 
        echo -n "[initDb.sh] "
        echo "cp $dir*.sql $TEMPO" 
        cp $dir*.sql $TEMPO 
    fi
done


for file in ${SCRIPTS[@]}
do
    echo -n "[initDb.sh] executing $file ..."
    mysql -u $USER --password="$PWORD" -h $HOST < $TEMPO/$file || display_usage;
    echo "... OK"
done

rm -r $TEMPO

cd ../
