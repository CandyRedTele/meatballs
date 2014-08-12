#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : run sql scripts to create/populate meatballs DB
# 
# NOTES : works with BASH, not with DASH (arrays not supported, change your default shell!)
#                                        (or use 'bash initDb.sh')
#
#******************************************************************************


USER="root"
HOST="127.0.0.1"
PWORD=''

### NOTE Please do not remove all those scripts to replace with populate.sql, I want to execute them one by one, :-)
SCRIPTS=('create_table.sql' 
         'pay.sql' 'staffgen.sql' 'gen_admin.sql'
         'menu_item.sql' 'supply.sql' 'ingredients.sql' 'menu.sql' 'wine.sql' 'food.sql'  
         'gen_facility.sql' 'gen_facilityHours.sql' 'facility_stock.sql'
         )
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
# copy all sql under $TEMPO 
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
