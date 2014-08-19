#
# create the /log folder 
#
mkdir -p log


#
# add /log to group SYSTEM on Windows and daemon on Linux/Max and give WRITE permission to group
#
if [ $(uname) != 'Darwin' -a $(uname -o) == 'Cygwin' ]; then
    # Windows user that runs scripts from Cygwin
    chown $USER:SYSTEM log
else 
    # Linux, Unix and Mac users
    sudo chown $USER:daemon log
fi

chmod g+w log
