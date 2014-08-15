#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# PURPOSE : Runs the PHPUnit tests
# 
# NOTES : required -> PHPUnit !
#
#******************************************************************************
# PHPUnit - Unit Testing Framework
# http://phpunit.de/getting-started.html
#
#


# TODO check that we are under comp353-project directory
# run all tests under /tests
phpunit  --configuration ./tests/unit/phpunit.xml tests/unit 
