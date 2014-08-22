#******************************************************************************
#
# AUTHOR : Joseph, comp353-project TEAM 3
#
# FILE : create_log_dir.sh
#
# PURPOSE : Creates the log folder, change the group and permissions
#           so that the server can write to it.
# 
# NOTES : tested with BASH on Linux, Windows (Cygwin) and Mac 
#         -> to be run from the root of the project
#
#******************************************************************************
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
if [ $(uname) == 'Darwin' -o $(uname) == 'Linux' ]; then
    # Linux, Unix and Mac users
    sudo chown $USER:daemon log
else 
    # Windows user that runs scripts from Cygwin
    chown $USER:SYSTEM log
fi

# temporarily grant write to everyone
chmod g+w log
chmod o+w log
