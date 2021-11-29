#!/usr/bin/env bash

#
# Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
#

set -e

SCRIPT_DIR="$(dirname "$0")"
PHP_FILE="${SCRIPT_DIR}/cli-add-user.php"

# use clean path
PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
export PATH

printf "Create new user.\nUsername: "
read -r username
printf "Password: "
read -r -s password

# change paths for your needs
NEW_USERNAME="$username" NEW_PASSWORD="$password" php "$PHP_FILE"
