#!/bin/bash

# This creates the files assets/images/sprite-congratulations.png and
# assests/scss/_spritecongratulations.scss
#
# It doesn't need to be run again unless when of the congratulations icons
# changes.

set -x
set -e

cd "$(dirname "${BASH_SOURCE[0]}")"

rm -rf make_spritecongratulations_output/

sprity create make_spritecongratulations_output/ assets/images/congratulations/*.png --engine gm -s _spritecongratulations.scss

cp make_spritecongratulations_output/sprite.png assets/images/sprite-congratulations.png

sed \
    -e 's/sprite.PNG/sprite-congratulations.png/g' \
    -e 's/\.icon/.congratulations-icon/g' \
    -e 's/\([^ ][^ ]*\)-white/.button:hover \1/g' \
    make_spritecongratulations_output/_spritecongratulations.scss > assets/scss/_spritecongratulations.scss

rm -rf make_spritecongratulations_output/
