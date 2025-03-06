#!/bin/zsh
set -e

# Install lefthook
if [ ! -f "/app/.git/hooks/pre-commit" ]; then
    su sirokouser -c 'cd /app && lefthook install -v'
fi

exec php-fpm -F -O