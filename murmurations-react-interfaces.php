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
    "apiUrl" => get_rest_url( null, "murmurations-aggregator/v1/get/nodes" ),
    "mapCenter" => [52, -97.1384],
    "mapZoom" => 4,
    "mapAllowScrollZoom" => 'true',
    "clientPathToApp" => plugin_dir_url( __FILE__ ) . 'widget/',
    "filter_fields" => array("country"),
    "filterSchema" => json_decode(
      file_get_contents(
        plugin_dir_path( __FILE__ ) . "config/default_filter_schema.json"
      ),
      true
    ),
    "directoryDisplaySchema" => json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . "config/default_directory_display_schema.json") ) , true
  );

  if( is_callable( array( "Murmurations\Aggregator\Settings", "get" ) ) ){
    $agg_settings = Murmurations\Aggregator\Settings::get();
    $settings = wp_parse_args( $agg_settings, $defaults );
    $data_schema = Murmurations\Aggregator\Schema::get();

    $settings['filterSchema']['properties'] = generate_filter_schema_fields($settings['filter_fields'],$data_schema);

  }else{
    $settings = $defaults;
  }

  ?>
  <script>

  var mriSettings = {}

  mriSettings.filterSchema = <?php echo json_encode( $settings['filterSchema'] ) ?>
/*
  {
    title: "Filter Nodes",
    type: "object",
    properties: {
      community_types: {
        type: "string",
        enum: [
          "Eco Project",
          "Ecovillage",
          "Other, not specified"
        ],
        title: "Community type",
        operator : "includes"
      },
      gen_community_setting : {
        type: "string",
        enum: [
          "Rural",
          "Urban",
          "Other"
        ],
        title: "Community setting",
        operator : "includes"
      },
      project_status: {
        type: "string",
        enum: [
          "Established",
          "Forming"
        ],
        title: "Project Status",
        operator : "equals"
      }
    }
  };
  */

  mriSettings.directoryDisplaySchema = <?php echo json_encode( $settings['directoryDisplaySchema'] ) ?>
/*
  {
    name : {
      showLabel : false,
      link : "gen_project_url"
    },
    url : {
      showLabel : false,
      link : "url"
    },
    description : {
      showLabel : false,
      truncate : 250
    },
    gen_community_setting : {
      showLabel : true,
      label : "Setting"
    },
    community_types : {
      showLabel : true,
      label : "Community Types"
    },
    languages_spoken : {
      showLabel : true,
      label : "Languages Spoken"
    }
  }

  */

  mriSettings.filterUiSchema = {};

  mriSettings.apiUrl = "<?php echo $settings['apiUrl']; ?>";

  mriSettings.schemaUrl = "";

  mriSettings.formData = {};

  mriSettings.mapCenter = [<?php echo join(', ', $settings['mapCenter']); ?>];
  mriSettings.mapZoom = <?php echo $settings['mapZoom']; ?>;
  mriSettings.mapAllowScrollZoom = <?php echo $settings['mapAllowScrollZoom']; ?>;

  mriSettings.clientPathToApp = "<?php echo $settings['clientPathToApp']; ?>";

  window.wpReactSettings = window.wpReactSettings || {};
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
