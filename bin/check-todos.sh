#!/usr/bin/env bash

printf "\n\n\n"
printf "=============================================================\n"
printf "Check ToDos ...\n"
printf "=============================================================\n"

PATTERN='todo[[:space:]@:].*'
DESCRIPTION="Checking project for missing ToDos"

if [[ -n "$1" ]]; then
    IFS='/'
    BRANCH=($1)
    unset IFS;

    TICKET_NR="${BRANCH[0]}"
    PATTERN+="${TICKET_NR}\\s.*"
    DESCRIPTION+="\n regarding the current ticket number: ${TICKET_NR}"
fi

DESCRIPTION+="\n"
printf "${DESCRIPTION}"

RESULT=$(grep -inRw "${PATTERN}" --exclude-dir={\*node_modules,var,bin,build,dist,vendor,public,.git\*} --exclude=\*.md . | awk -F":" '{print "\033[1;37m"$1"\n\033[0;31m"$2":\t"$3"\033[0m\n"}')

if [[ -n "$RESULT" ]]; then
    printf "\n"
    printf '\e[1;31m%-6s\e[m' "[ERROR] ToDos found"
    printf "\n\n${RESULT}\n"
    printf "=============================================================\n\n"
    exit 1
else
    printf "\n"
    printf '\e[1;32m%-6s\e[m' "[OK] No ToDos"
    printf "\n"
    printf "=============================================================\n\n"
fi
