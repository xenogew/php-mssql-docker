#!/bin/bash

# Start the script to create the DB and user
/usr/config/configure-db.sh &

# Start SQL Server in the background
/opt/mssql/bin/sqlservr
