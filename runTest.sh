#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : Runs the PHPUnit tests
# 
# NOTES : required -> PHPUnit !
#
#   PHPUnit - Unit Testing Framework
#   http://phpunit.de/getting-started.html
#  
#   mysqli issues not there?
#       sudo apt-get install php5-mysqlnd
#
#       possibly modify php.ini : 
#           php -i | grep php.ini 
#           vim /etc/php5/cli/conf.d/mysqli.ini 
#               pdo_mysql.default_socket=  /opt/lampp/var/mysql/mysql.sock
#                   mysql.defaul_socket =/opt/lampp/var/mysql/mysql.sock
#                   mysqli.defaul_socket=/opt/lampp/var/mysql/mysql.sock
#
#
#******************************************************************************


#
# check if phpunit is installed
#
phpunit --version 2>/dev/null | grep PHPUnit 2>&1 1>/dev/null
exit_sts=$?;
if [ $exit_sts -ne 0 ]; then
    echo "[$0] you do not have PHPUnit installed!";
    echo "[$0] http://phpunit.de/getting-started.html";
    exit $exit_sts;
fi

#
# check that we are under comp353-project directory
#
pwd | egrep 'comp353-project$' 2>&1 1>/dev/null
exit_sts=$?;
if [ $exit_sts -ne 0 ]; then
    echo "[$0] run the script from the root of the project";
    exit $exit_sts;
fi

rm -f src/log

#
# run all tests under /tests
#
#phpunit  --configuration ./tests/unit/phpunit.xml tests/unit 
phpunit --verbose  tests/unit 

## rm -f src/log

exit_sts=$?;
if [ $exit_sts -ne 0 ]; then
    echo -e "[$0] Unit tests...\t\t\t \e[31m [FAILURE]\e[0m"
else 
    echo -e "[$0] Unit tests...\t\t\t \e[32m [SUCCESS]\e[0m"
fi

#
# TODO run database test scripts
#

echo -e "[$0] \e[31mTODO\e[0m execute database tests";
