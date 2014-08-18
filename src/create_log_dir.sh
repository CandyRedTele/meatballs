#
# create the /log folder and give WRITE permission to everyone...
#       (it would be MUCH better to make sure the GROUP has appropriate permissions, but it
#        would have to work on Linus, Max and Windows... hence for now we let this as it is)
mkdir -p log


if [  $(uname -o) == 'Cygwin' ]; then
    chown $USER:SYSTEM log
else 
    chown $USER:daemon log
fi

chmod g+w log
