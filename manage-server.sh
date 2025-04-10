#!/bin/bash

# Script to manage the Laravel server

function start_server() {
  echo "Starting Laravel server..."
  nohup ./start-laravel.sh > laravel.log 2>&1 &
  echo "Server started in background. Check laravel.log for details."
  echo "Access the server at: https://${REPL_SLUG}.${REPL_OWNER}.repl.co"
}

function stop_server() {
  echo "Stopping Laravel server..."
  pkill -f "php artisan serve" || echo "No server running."
}

function restart_server() {
  stop_server
  sleep 2
  start_server
}

function server_status() {
  if pgrep -f "php artisan serve" > /dev/null; then
    echo "Laravel server is running."
  else
    echo "Laravel server is not running."
  fi
}

function show_logs() {
  if [ -f "laravel.log" ]; then
    tail -n 50 laravel.log
  else
    echo "Log file not found."
  fi
}

# Main menu
case "$1" in
  start)
    start_server
    ;;
  stop)
    stop_server
    ;;
  restart)
    restart_server
    ;;
  status)
    server_status
    ;;
  logs)
    show_logs
    ;;
  *)
    echo "Usage: $0 {start|stop|restart|status|logs}"
    exit 1
    ;;
esac

exit 0