#!/bin/sh
DAEMON=/home/voodoo/www/voc/data/daemon
USER=voodoo
PID=`cat $DAEMON/daemon.pid`
case "$1" in
'start')
	echo -n "Starting Voc-daemon:"
	if [ "x$PID" != "x" ] && kill -0 $PID 2>/dev/null ; then
		echo "daemon is already running (pid $PID)"
		continue
	else
		export DAEMON
		su  $USER -c 'cd $DAEMON; ./daemon.pl' > /dev/null 2>&1
		echo
	fi
	;;
'status')
	echo "Voc-daemon status: "
	if [ "x$PID" != "x" ] && kill -0 $PID 2>/dev/null ; then
		echo "running with pid $PID"
	else
		echo "not running (pid $PID)"
	fi
	ps -up$PID
	;;
'stop')
	echo -n "Shutting down Voc-daemon:"
	kill `cat $DAEMON/daemon.pid`
	echo
	;;
esac
exit 0
