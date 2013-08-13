#!/bin/bash
#
# Using git-subsplit
# https://github.com/dflydev/git-subsplit

GIT_SUBSPLIT="git subsplit"

$GIT_SUBSPLIT init https://github.com/ddd-php/ddd-components

$GIT_SUBSPLIT update

$GIT_SUBSPLIT publish "
    src/Ddd/Mail:git@github.com:ddd-php/Mail.git
    src/Ddd/Slug:git@github.com:ddd-php/Slug.git
    src/Ddd/Calendar:git@github.com:ddd-php/Calendar.git
    src/Ddd/Time:git@github.com:ddd-php/Time.git
" --heads=master
