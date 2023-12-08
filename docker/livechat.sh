#!/bin/bash

arg1="$1"

if [ "$arg1" = "up" ]; then
    echo "Starting LiveChat !............."
    echo "Running docker compose up --build"
    docker-compose up --build -d
    sleep 5
    echo "LiveChat started successfully!"
    echo "LiveChat running @ : http://localhost/public"
    echo "phpMyAdmin @ http://localhost:8001"
elif [ "$arg1" = "down" ]; then
    echo "Exporting the database !............."
    docker exec -i db mysqldump -uadmin -ppassword LiveChat > ../db/LiveChat.sql
    # Wait for a few seconds to allow the export to complete
    sleep 10

    echo "Successfully exported !"
    echo "Ending LiveChat server ....... running docker-compose down"
    docker-compose down
    echo "LiveChat ended successfully!"

else
    echo "Invalid Argument. Use 'up' or 'down'"
fi
