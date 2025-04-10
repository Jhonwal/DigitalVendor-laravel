#!/bin/bash

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to start the server
start_server() {
  echo -e "${GREEN}Starting Laravel server on port 8080...${NC}"
  # Kill any existing PHP server
  pkill -f "php -S 0.0.0.0:8080" > /dev/null 2>&1
  
  # Start PHP server in background
  nohup php -S 0.0.0.0:8080 -t public > server.log 2>&1 &
  PID=$!
  echo $PID > server.pid
  
  # Wait a moment to ensure the server starts
  sleep 2
  
  # Check if server is running
  if ps -p $PID > /dev/null; then
    echo -e "${GREEN}✅ Server started successfully with PID: $PID${NC}"
    echo -e "${YELLOW}Access your application at:${NC}"
    echo -e "${GREEN}http://localhost:8080${NC}"
  else
    echo -e "${RED}❌ Failed to start server. See server.log for details.${NC}"
    cat server.log
    exit 1
  fi
}

# Function to check server status
check_status() {
  if [ -f server.pid ] && ps -p $(cat server.pid) > /dev/null; then
    echo -e "${GREEN}✅ Server is running with PID: $(cat server.pid)${NC}"
    echo -e "${YELLOW}Access your application at:${NC}"
    echo -e "${GREEN}http://localhost:8080${NC}"
  else
    echo -e "${RED}❌ Server is not running${NC}"
  fi
}

# Function to stop the server
stop_server() {
  if [ -f server.pid ]; then
    PID=$(cat server.pid)
    echo -e "${YELLOW}Stopping server with PID: $PID...${NC}"
    kill $PID > /dev/null 2>&1
    rm server.pid
    echo -e "${GREEN}✅ Server stopped${NC}"
  else
    echo -e "${RED}❌ No running server found${NC}"
  fi
}

# Command line parsing
case "$1" in
  start)
    start_server
    ;;
  stop)
    stop_server
    ;;
  restart)
    stop_server
    start_server
    ;;
  status)
    check_status
    ;;
  *)
    echo -e "Usage: $0 {start|stop|restart|status}"
    exit 1
    ;;
esac

exit 0