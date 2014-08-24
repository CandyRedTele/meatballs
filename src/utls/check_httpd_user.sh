#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : find user that runs httpd
# 
# NOTES : BASH
#
#******************************************************************************
#
# check which user is running HTTPD
#
find /opt -name httpd.conf  2>/dev/null | xargs egrep -iw --color=auto '^user|^group'

