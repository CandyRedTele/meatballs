#
# create the /log folder 
#
mkdir -p log


#
# add /log to group SYSTEM on Windows and daemon on Linux/Max and give WRITE permission to group
#
if [  $(uname -o) == 'Cygwin' ]; then
    chown $USER:SYSTEM log
else 
    chown $USER:daemon log
fi

chmod g+w log
