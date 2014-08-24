

declare -A TABLE_NAMES
TABLE_NAMES=([facilitystock]='facilityStock' [facilitybalance]='facilityBalance')

for key in  "${!TABLE_NAMES[@]}"
do 
    echo "find . -name * | xargs sed  's/$key/${TABLE_NAMES[$key]}/g'"
    find . -name '*.php' | xargs sed  -i "s/$key/${TABLE_NAMES[$key]}/g"
done
