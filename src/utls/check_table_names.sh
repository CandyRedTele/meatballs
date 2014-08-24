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

declare -A TABLE_NAMES
#
# Add some more in the array, if needed
#
TABLE_NAMES=([facilitystock]='facilityStock' 
             [facilitybalance]='facilityBalance'
             [facilityhours]='facilityHours'
             [getSingleInstace]='getSingleInstance'
             )

for key in  "${!TABLE_NAMES[@]}"
do 
    echo "find . -name * | xargs sed  's/$key/${TABLE_NAMES[$key]}/g'"
    find . -name '*.php' | xargs sed  -i "s/$key/${TABLE_NAMES[$key]}/g"
done
