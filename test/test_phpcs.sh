#!/bin/bash

set -e

cd "$(dirname "${BASH_SOURCE[0]}")/../"

eval vendor/bin/phpcs
