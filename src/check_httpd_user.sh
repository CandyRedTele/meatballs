#
# check which user is running HTTPD
#
HTTPD_FILE=$(find / -name httpd.conf  2>/dev/null)
egrep -iw --color=auto '^user|^group' $HTTPD_FILE
