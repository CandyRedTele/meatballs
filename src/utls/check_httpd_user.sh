#
# check which user is running HTTPD
#



find /opt -name httpd.conf  2>/dev/null | xargs egrep -iw --color=auto '^user|^group'

