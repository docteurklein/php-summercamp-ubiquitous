#!/usr/bin/env bash

set -exuo pipefail

composer install -n

curl -sSL https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2 > phantomjs
