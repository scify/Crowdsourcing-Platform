#!/bin/bash

# Default variables
groupname="${1:-www-data}"
username="${2:-$USER}"
folder="${3:-.}"

# Add user to webserver group
usermod -a -G "$groupname" "$username"

# Change storage ownership to normal user/ webserver group
chown -R "$username":"$groupname" "$folder"/storage

chmod 775 "$folder"/storage

# Update permissions for all storage files
find "$folder"/storage -type f -exec chmod 664 {} \;

# Update permissions for all storage folders
find "$folder"/storage -type d -exec chmod 775 {} \;

# Update permissions for all storage folders
find "$folder"/storage/framework -type d -exec chmod 775 {} \;

# Update permissions for all storage folders
find "$folder"/storage/framework/cache -type d -exec chmod 775 {} \;
# Update permissions for all storage folders
find "$folder"/storage/framework/cache/data -type d -exec chmod 775 {} \;

# Change owner group to webserver group user for storage and bootstrap cache folder
chgrp -R "$groupname" "$folder"/storage "$folder"/bootstrap/cache
