#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : do a global search and replace on frequently mistype 
#           table names/methods
# 
# NOTE : tested on BASH
#
#******************************************************************************

DIR=.
SKIP=0

while getopts "d:s" opt; do
    case "$opt" in
        d) DIR=$OPTARG;
           echo "DIR : $DIR";
        ;;
        s) SKIP=1
        ;;
    esac 
done

declare -A TABLE_NAMES
count=0
#
# Add some more in the array, if needed
#
TABLE_NAMES=([facilitystock]='facilityStock'
             [facilitybalance]='facilityBalance'
             [facilityhours]='facilityHours'
             [getSingleInstace]='getSingleInstance'
             )

#
# Need to skip some checks? put them here and use the -s option
#
if [ $SKIP -eq 0 ]; then
    TABLE_NAMES+=(  ['\([^\<|^element ]\)select ']='\1SELECT '
                    ['from ']='FROM '
                    ['where ']='WHERE '
                    [' join ']=' JOIN '
                    [getTrainingQuery]='GetTrainingQuery'
                  )
fi

for key in  "${!TABLE_NAMES[@]}"
do 
    echo -n '.'

    grep -r --include='*.php' "$key" $DIR 
    if [ $? -eq 0 ]; then
        count=$(($count + 1))
    fi

    find $DIR -name '*.php' | xargs sed  -i "s/$key/${TABLE_NAMES[$key]}/g"
done


if [ $count -gt 0 ]; then
    echo "[$0] replaced some commonly misspelled identifier, please review the changes and push."
fi

exit $count;
