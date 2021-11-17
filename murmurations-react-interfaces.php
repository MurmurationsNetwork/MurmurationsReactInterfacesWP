<?php
/**
 * @wordpress-plugin
 * Plugin Name: Murmurations React Interfaces
 */

defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

define( 'ERW_WIDGET_PATH', plugin_dir_path( __FILE__ ) . 'widget' );
define( 'ERW_ASSET_MANIFEST', ERW_WIDGET_PATH . '/build/asset-manifest.json' );
define( 'MRI_INCLUDES', plugin_dir_path( __FILE__ ) . '/includes' );

require_once( MRI_INCLUDES . '/enqueue.php' );
require_once( MRI_INCLUDES . '/shortcodes.php' );

add_action('wp_head', function (){

  $defaults = array(
    "api_url" => get_rest_url( null, "murmurations-aggregator/v1/get/nodes" ),
    "map_origin" => "52, -97.1384",
    "map_scale" => 4,
    "map_allow_scroll_zoom" => 'true',
    "nodes_per_page" => 10,
    "api_node_format" => "JSON",
    "client_path_to_app" => plugin_dir_url( __FILE__ ) . 'widget/',
    "filter_fields" => array("country"),
    "filter_schema" => json_decode(
      file_get_contents(
        plugin_dir_path( __FILE__ ) . "config/default_filter_schema.json"
      ),
      true
    ),
    "directory_display_schema" => json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . "config/default_directory_display_schema.json") ) , true
  );

  if( is_callable( array( "Murmurations\Aggregator\Settings", "get" ) ) ){
    $agg_settings = Murmurations\Aggregator\Settings::get();
    $settings = wp_parse_args( $agg_settings, $defaults );
    $data_schema = Murmurations\Aggregator\Schema::get();

    $settings['filter_schema']['properties'] = generate_filter_schema_fields($settings['filter_fields'],$data_schema);

  }else{
    $settings = $defaults;
  }

  $settings = apply_filters( 'murmurations_interfaces_settings', $settings );


  ?>
  <script>

  var mriSettings = {}

  mriSettings.filterSchema = <?php  echo json_encode( $settings['filter_schema'] ) ?>;
  mriSettings.directoryDisplaySchema = <?php echo json_encode( $settings['directory_display_schema'] ) ?>;
  mriSettings.filterUiSchema = {};
  mriSettings.apiUrl = "<?php echo $settings['api_url']; ?>";
  mriSettings.apiNodeFormat = "<?php echo $settings['api_node_format']; ?>";
  mriSettings.schemaUrl = "";
  mriSettings.formData = {};
  mriSettings.mapCenter = [<?php echo $settings['map_origin']; ?>];
  mriSettings.mapZoom = <?php echo $settings['map_scale']; ?>;
  mriSettings.mapAllowScrollZoom = <?php echo $settings['map_allow_scroll_zoom']; ?>;
  mriSettings.clientPathToApp = "<?php echo $settings['client_path_to_app']; ?>";
  mriSettings.nodesPerPage = "<?php echo $settings['nodes_per_page']; ?>";

  window.wpReactSettings = mriSettings;

  </script>

  <?php
});

/**
* Take an array of fields and a JSON Schema and generate the filter JSON Schema, using the enum values and titles from the schema.
*/

function generate_filter_schema_fields( $filter_fields, $data_schema ){
  $filter_schema_fields = array();
  foreach ( $filter_fields as $field ) {
    if( isset($data_schema['properties'][$field]) ){
      $schema_field = $data_schema['properties'][$field];
      $filter_schema_fields[$field] = array(
        "title" => $schema_field['title'],
        "type" => $schema_field['type'] == "boolean" ? "boolean" : "string",
        "operator" => "includes"
      );

      $enum_data = get_field_enums( $schema_field );

      if ( $enum_data ){
        $filter_schema_fields[$field]['enum'] = $enum_data[0];
        $filter_schema_fields[$field]['enumNames'] = $enum_data[1];
      }

    }

  }
  return $filter_schema_fields;
}

function get_field_enums($field){
  $enum = false;
  $enumNames = false;
  if( isset( $field['enum'] ) ){
    $enum = $field['enum'];
    $enumNames = isset( $field['enumNames'] ) ? $field['enumNames'] : false;
  } else if( $field['type'] === 'array' && $field['items']['enum'] ){
    $enum = $field['items']['enum'];
    $enumNames = isset( $field['items']['enumNames'] ) ? $field['items']['enumNames'] : false;
  }
  if( $enum ){
    return array( $enum, $enumNames );
  }else{
    return false;
  }
}
