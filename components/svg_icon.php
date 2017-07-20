<?php

/**
 * Display svg icons
 */

function get_svg_icon($icon_name) {
  return sprintf('<i class="icon icon-%1$s"><svg class="svg"><use xlink:href="#svg-%1$s"></svg></i>', $icon_name);
}

function the_svg_icon($icon_name) {
  echo get_svg_icon($icon_name);
}
