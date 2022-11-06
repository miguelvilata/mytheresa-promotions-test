#!/usr/bin/env bash
sleep 10;
/var/www/bin/console messenger:consume async -vv >&1;