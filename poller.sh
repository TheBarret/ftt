#!/bin/bash

file="./reports.json"
while [[ 1 ]]; do /usr/bin/inotifywait -e modify $file; /usr/bin/php -f ./report.php $file; done
