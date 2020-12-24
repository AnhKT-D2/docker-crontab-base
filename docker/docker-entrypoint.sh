#!/bin/sh
set -e

# Enable Laravel schedule
if [[ "${ENABLE_CRONTAB:-0}" = "1" ]]; then
  mv -f /etc/supervisor.d/cron.conf /etc/supervisor.d/cron.conf
  echo "* * * * * php /usr/share/nginx/api/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/www-data
fi

exec "$@"