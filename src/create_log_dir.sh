#
# create the /log folder 
#

echo "[create_log_dir.sh] create log directory and setup permission... "

mkdir -p log

#
# add /log to group SYSTEM on Windows and daemon on Linux/Max and give WRITE permission to group
#
# NB : `uname -o` does not work on MAC, `uname` does... $OSTYPE is another option that should work on
#       Cygwin, Linux and Mac
#
if [ $(uname) == 'Darwin' -o $OSTYPE == 'linux-gnu' ]; then
    # Linux, Unix and Mac users
    sudo chown $USER:daemon log
else 
    # Windows user that runs scripts from Cygwin
    chown $USER:SYSTEM log
fi

chmod g+w log
