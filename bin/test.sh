#!/usr/bin/env bash

PROJECT_DIR="$( cd "$(dirname "$0")/.." && pwd )"

cd "$PROJECT_DIR" || exit

case "$1" in
    static)
        make phpcs
        ;;
    static-analyze)
        make phpstan
        ;;
    static-fix)
        make phpcbf
        ;;
    unit)
        make tests
        ;;
    php81-compatibility)
        make php74compatibility
        ;;
    php82-compatibility)
        make php81compatibility
        ;;
    *)
        echo "Use $0 {static|static-analyze|static-fix|unit|php81-compatibility|php82-compatibility} in order to run static or unit tests"
        exit 1;
        ;;
esac
