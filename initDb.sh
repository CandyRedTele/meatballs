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
SCRIPTS=('create_table.sql' 'trigger.sql'
         'pay.sql' 'staffgen.sql' 'gen_admin.sql'
         'menu_item.sql' 'supply.sql' 'ingredients.sql' 'menu.sql' 'wine.sql' 'food.sql'  'vendor.sql' 'catalog.sql'
         'gen_facility.sql' 'gen_localStaff.sql' 'gen_facilityHours.sql' 'facility_stock.sql' 'order.sql'
         'gen_bills.sql' 'gen_bill_has_items.sql' 'gen_golden.sql' 'gen_golden_bills.sql'
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
    if [[ "$OSTYPE" == "darwin"* ]]; then
        mysql -uroot -h $HOST < $TEMPO/$file || display_usage;
    else
        mysql -u $USER --password="$PWORD" -h $HOST < $TEMPO/$file || display_usage;
    fi
    echo "... OK"
done

rm -r $TEMPO

cd ../
