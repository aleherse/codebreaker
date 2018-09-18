#!/bin/bash

php -dxdebug.remote_enable=1 -dxdebug.remote_autostart=1 -dxdebug.remote_mode=req $@
