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
  ?>
  <script>

  var mriSettings = {}


  mriSettings.filterSchema = {
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
      country: {
        type: "string",
        enum: [
          "Canada",
          "United States"
        ],
        title: "Country",
        operator : "equals"
      }
    }
  };

  mriSettings.filterUiSchema = {};

  mriSettings.apiUrl = "http://localhost/projects/murmurations/wordpress-dev/wp-json/murmurations-aggregator/v1/get/nodes";

  mriSettings.schemaUrl = "http://localhost/projects/murmurations/wordpress-dev/wp-json/murmurations-aggregator/v1/get/nodes";

  mriSettings.formData = {};

  mriSettings.listFields = ['name','url','description','country'];

  mriSettings.mapCenter = [52, -97.1384];
  mriSettings.mapZoom = 4;
  mriSettings.mapAllowScrollZoom = true;

  mriSettings.clientPathToApp = "http://localhost/TestPress4/wp-content/plugins/murmurations-react-interfaces/widget/";

  window.wpReactSettings = window.wpReactSettings || {};
  window.wpReactSettings = mriSettings;

  </script>

  <?php
});
