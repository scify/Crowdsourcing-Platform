#!/bin/bash

# Usage: ./set-laravel-permissions.sh /path/to/laravel [owner_user] [webserver_group]
# Example: ./set-laravel-permissions.sh /var/www/my-app scify www-data

set -e

LARAVEL_ROOT="${1:-.}"
OWNER="${2:-$USER}"
GROUP="${3:-www-data}"

echo "🔧 Setting permissions for Laravel app at: $LARAVEL_ROOT"
echo "👤 Owner: $OWNER"
echo "👥 Group: $GROUP"

# Change ownership recursively
echo "📦 Changing ownership..."
sudo chown -R "$OWNER:$GROUP" "$LARAVEL_ROOT"

# Set general directory and file permissions
echo "📁 Setting directory permissions to 755..."
find "$LARAVEL_ROOT" -type d -exec chmod 755 {} \;

echo "📄 Setting file permissions to 644..."
find "$LARAVEL_ROOT" -type f -exec chmod 644 {} \;

# Set specific permissions for storage and bootstrap/cache
echo "📝 Setting correct permissions for storage and bootstrap/cache..."

find "$LARAVEL_ROOT/storage" "$LARAVEL_ROOT/bootstrap/cache" -type d -exec chmod 775 {} \;
find "$LARAVEL_ROOT/storage" "$LARAVEL_ROOT/bootstrap/cache" -type f -exec chmod 664 {} \;
sudo chown -R "$OWNER:$GROUP" "$LARAVEL_ROOT/storage" "$LARAVEL_ROOT/bootstrap/cache"

# Make executable project-level tools
echo "🔧 Making specific scripts executable..."

chmod +x "$LARAVEL_ROOT/artisan"

# Make all vendor/bin scripts executable
if [ -d "$LARAVEL_ROOT/vendor/bin" ]; then
  echo "🔧 Making vendor/bin scripts executable..."
  find "$LARAVEL_ROOT/vendor/bin" -type f -exec chmod +x {} \;
fi

# ...existing code...

# In node_modules/.bin, find all files from symbolic links and make them executable
if [ -d "$LARAVEL_ROOT/node_modules/.bin" ]; then
  echo "🔧 Making node_modules/.bin scripts executable..."
  find "$LARAVEL_ROOT/node_modules/.bin" -type l | while read -r symlink; do
    # Get the directory of the symlink
    dir="$(dirname "$symlink")"
    # Get the target (may be relative)
    target="$(readlink "$symlink")"
    # If target is not absolute, resolve it relative to the symlink's directory
    [[ "$target" != /* ]] && target="$dir/$target"
    # Only chmod if the target exists
    [ -e "$target" ] && chmod +x "$target"
  done
fi

# ...existing code...

echo "✅ Laravel permissions set successfully."
