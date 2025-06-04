#!/bin/bash

# Wait for SQL Server to start
echo "Waiting for SQL Server to start..."
sleep 30

# Check if SQL Server is ready
COUNTER=0
MAX_ATTEMPTS=60

while ! /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$MSSQL_SA_PASSWORD" -C -Q "SELECT 1" > /dev/null 2>&1 && [ $COUNTER -lt $MAX_ATTEMPTS ]; do
    echo "SQL Server is not ready yet. Waiting... ($((COUNTER + 1))/$MAX_ATTEMPTS)"
    sleep 1
    COUNTER=$((COUNTER + 1))
done

if [ $COUNTER -eq $MAX_ATTEMPTS ]; then
    echo "ERROR: SQL Server failed to start within $MAX_ATTEMPTS seconds"
    exit 1
fi

echo "SQL Server is ready! Running initialization script..."

# Run the setup script
/opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "$MSSQL_SA_PASSWORD" -C -i setup.sql

echo "Database initialization completed!"

# Keep the container running
wait
