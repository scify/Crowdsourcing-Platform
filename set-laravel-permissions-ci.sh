#!/bin/bash

# Usage: ./set-laravel-permissions-ci.sh /path/to/laravel
# In GitHub Actions, just point to the Laravel app root (default: current directory)

set -ex

LARAVEL_ROOT="${1:-.}"

echo "🔧 Setting Laravel file permissions in CI environment at: $LARAVEL_ROOT"

# General project-wide permissions
# Only touch files/dirs owned by the current user to avoid "Operation not permitted"
# errors on runtime files created by the web server process (e.g. session files).
CURRENT_USER="$(whoami)"

echo "📁 Setting directory permissions to 755..."
find "$LARAVEL_ROOT" -type d -user "$CURRENT_USER" -exec chmod 755 {} +

echo "📄 Setting file permissions to 644..."
find "$LARAVEL_ROOT" -type f -user "$CURRENT_USER" -exec chmod 644 {} +

# Writable directories: storage & bootstrap/cache
echo "📝 Making storage/ and bootstrap/cache/ writable..."
find "$LARAVEL_ROOT/storage" "$LARAVEL_ROOT/bootstrap/cache" -type d -user "$CURRENT_USER" -exec chmod 775 {} +
find "$LARAVEL_ROOT/storage" "$LARAVEL_ROOT/bootstrap/cache" -type f -user "$CURRENT_USER" -exec chmod 664 {} +

echo "✅ CI permissions set successfully."
