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
    "clientPathToApp" => plugin_dir_path( __FILE__ ) . 'widget/',
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
