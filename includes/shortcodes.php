<?php
defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

add_shortcode( 'murmurations_react_directory', function( $atts ) {
  $default_atts = array();
  $args = shortcode_atts( $default_atts, $atts );

  return "<div id='murmurations-react-directory'></div>";
});

add_shortcode( 'murmurations_react_map', function( $atts ) {
  $default_atts = array();
  $args = shortcode_atts( $default_atts, $atts );

  return "<div id='murmurations-react-map'></div>";
});
