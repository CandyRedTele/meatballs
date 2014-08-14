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


#
# List all sql files under /sql
#
ALL_SQL=$(find sql -name "*.sql"  | awk -F "/"  '{print $3}' | grep sql --exclude populate)

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
    exclude=$(find sql/scripts -name $line); 

    if [ "$exclude" == "" ]; then
        #
        # exclude : those that are just use to 'source' others
        #
        grep  "^source" $(find . -name $line)  2>&1 1>/dev/null;
        if [ $? -eq 1 ];  then
            echo -n "Files missing in $TARGET : ";
            echo $line
        fi
    fi
done < $TEMPO


rm $TEMPO
