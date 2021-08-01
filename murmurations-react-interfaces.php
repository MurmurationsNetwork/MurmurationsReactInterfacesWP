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

  mriSettings.directoryDisplaySchema = {
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

  mriSettings.filterUiSchema = {};

  mriSettings.apiUrl = "http://localhost/projects/murmurations/wordpress-dev/wp-json/murmurations-aggregator/v1/get/nodes";

  mriSettings.schemaUrl = "http://localhost/projects/murmurations/wordpress-dev/wp-json/murmurations-aggregator/v1/get/nodes";

  mriSettings.formData = {};

  mriSettings.mapCenter = [52, -97.1384];
  mriSettings.mapZoom = 4;
  mriSettings.mapAllowScrollZoom = true;

  mriSettings.clientPathToApp = "http://localhost/TestPress4/wp-content/plugins/murmurations-react-interfaces/widget/";

  window.wpReactSettings = window.wpReactSettings || {};
  window.wpReactSettings = mriSettings;

  </script>

  <?php
});
