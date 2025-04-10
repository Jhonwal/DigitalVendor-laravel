#!/bin/bash

# Kill any existing PHP server
pkill -f "php -S 0.0.0.0:8080" || true

# Start PHP server in background
nohup php -S 0.0.0.0:8080 -t public > server.log 2>&1 &
SERVER_PID=$!
echo $SERVER_PID > server.pid
echo "Laravel server started on port 8080 with PID $SERVER_PID"

# Wait a moment to ensure server starts
sleep 2

# Check if server is running
if kill -0 $SERVER_PID 2>/dev/null; then
  echo "Server is running successfully!"
  echo "You can now access the application at http://localhost:8080"
else
  echo "Server failed to start. Check server.log for details."
  cat server.log
fi