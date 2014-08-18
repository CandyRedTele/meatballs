#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : check if all .sql are included in the initDb.sh script
# 
# NOTES : works with BASH, not with DASH (arrays not supported)
#         -> to be run from the root of the project
#
#******************************************************************************
TEMPO='tempo.txt'
TARGET='initDb.sh'

# exclude those files : 
EXCLUDE_LIST='populate.sql|test_if_populated.sql'; 

RESULT=0;
#
# List all sql files under /sql
#
ALL_SQL=$(find sql -name "*.sql"  | awk -F "/"  '{print $NF}' | grep sql | egrep -v $EXCLUDE_LIST)

for sql in ${ALL_SQL[@]}; do
    #
    # If not in initDb.sh, store in $TEMPO
    #
    grep $sql $TARGET  2>&1 1>/dev/null;
    if [ $? -eq 1 ];  then
        echo $sql >> $TEMPO
    fi
done


while read line; do
    #
    # exclude those under sql/scripts, they do not contribute to the creation/population of the database 
    #
    exclude=$(find sql/scripts -name $line 2>/dev/null);

    if [ "$exclude" == "" ]; then
        #
        # exclude : those that are just use to 'source' others
        #
        grep  "^source" $(find . -name $line)  2>&1 1>/dev/null;
        if [ $? -eq 1 ];  then
            RESULT=1;
            echo -n "Files missing in $TARGET : ";
            echo $line
        fi
    fi
done < $TEMPO

if [ $RESULT -eq 0 ]; then 
    echo "[CHECK] initDb.sh is up to date.";
fi

rm -f $TEMPO

exit $RESULT
