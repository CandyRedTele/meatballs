#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : run sql scripts to create/populate meatballs DB
# 
# NOTES : works with BASH, not with DASH (arrays not supported)
#         use 'bash initDb.sh'
#
#******************************************************************************

DB_USER="root"
HOST="127.0.0.1"
PWORD=''
SKIP=0

<<<<<<< HEAD
#while getopts "u:h:p:" opt; do
 #   case "$opt" in
  #      u) USER=$OPTARG
   #     ;;
    #    h) HOST=$OPTARG 
     #   ;;
      #  p) PWORD=$OPTARG
       # ;;
#    esac 
#done
=======
while getopts "u:h:p:s" opt; do
    case "$opt" in
        u) DB_USER=$OPTARG
        ;;
        h) HOST=$OPTARG 
        ;;
        p) PWORD=$OPTARG
        ;;
        s) SKIP=1;
        ;;
    esac 
done
>>>>>>> 49bef3386cb627c9acbe10d114cfa0ce4977756c


### NOTE Please do not remove all those scripts to replace with populate.sql, I want to execute them one by one, :-)
SCRIPTS=('create_table.sql' 'trigger_on_order.sql' 'after_bill_trigger.sql'
         'pay.sql' 'staffgen.sql' 'gen_admin.sql' 'gen_access_level.sql'
         'menu_item.sql' 'supply.sql' 'ingredients.sql' 'menu.sql' 'wine.sql' 'food.sql'  'vendor.sql' 'catalog.sql'
         'gen_facility.sql' 'gen_localStaff.sql' 'gen_facilityHours.sql' 'facility_stock.sql' 'facility_balance.sql' 'order.sql'
         'bill.sql' 'bill_has_menu_item.sql' 'gen_golden.sql' 'golden_has_bills.sql' 'gen_shift.sql' 'gen_schedule.sql'
         )
TEMPO=tempo

function display_usage
{
    echo "To be run from the root of the project";
    exit
}

if [ $SKIP -eq 0 ]; then
    bash src/check_if_all_script_are_in_initDb.sh

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
        if [[ "$OSTYPE" == "darwin"* ]]; then
            mysql -uroot -h $HOST < $TEMPO/$file || display_usage;
        else
            mysql -u $DB_USER --password="$PWORD" -h $HOST < $TEMPO/$file || display_usage;
        fi
        echo "... OK"
    done

    rm -r $TEMPO

    cd ../
fi

#
# create log dir, set permissions
#
bash src/create_log_dir.sh
