#!/usr/bin/env bash
# Builds installable zips of the theme and plugin into wordpress/dist/.
set -euo pipefail
cd "$(dirname "$0")/.."
mkdir -p dist
rm -f dist/descasio-theme.zip dist/descasio-elements.zip
zip -qr dist/descasio-theme.zip descasio-theme -x "*.DS_Store"
zip -qr dist/descasio-elements.zip descasio-elements -x "*.DS_Store" "descasio-elements/bin/*"
ls -la dist
