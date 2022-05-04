<?php
/**
 * Murmurations Interfaces class
 *
 * @package Murmurations React Interfaces
 */

namespace Murmurations\Interfaces;

/**
 * Main interfaces class
 */
class Interfaces {

  public static function prepare(){

    // Set the default settings
    $settings_defaults = array(
      "api_url" => get_rest_url( null, "murmurations-aggregator/v1/get/nodes" ),
      "map_origin" => "52, -97.1384",
      "map_scale" => 4,
      "map_allow_scroll_zoom" => 'true',
      "nodes_per_page" => 10,
      "api_node_format" => "JSON",
      "client_path_to_app" => MRI_BASE_URL . 'widget/',
      "filter_fields" => [],
      "filter_schema" => [],
      "show_filters" => false,
      "directory_display_schema" => json_decode( file_get_contents( MRI_BASE_PATH . "config/default_directory_display_schema.json") ) , true
    );

    // Get settings from the aggregator if available
    if( is_callable( array( "\Murmurations\Aggregator\Settings", "get" ) ) ){
      $agg_settings = \Murmurations\Aggregator\Settings::get();
      $settings = wp_parse_args( $agg_settings, $settings_defaults );
      $data_schema = \Murmurations\Aggregator\Schema::get();

      $settings['filter_schema']['properties'] = self::generate_filter_schema_fields($settings['filter_fields'],$data_schema);

      if( count($settings['filter_fields']) > 0 ){
        $settings['show_filters'] = true;
      }

    }else{
      $settings = $settings_defaults;
    }

    // Run filters, in case wrappers or other plugins are modifying settings
    $settings = apply_filters( 'murmurations_interfaces_settings', $settings );

    // Output the settings to client
    ?>
    <script>

    var mriSettings = {}

    mriSettings.filterSchema = <?php  echo json_encode( $settings['filter_schema'] ) ?>;
    mriSettings.showFilters = <?php echo $settings['show_filters'] ? "true" : "false" ?>;
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
  }

  /**
  * Take an array of fields and a JSON Schema and generate the filter JSON Schema, using the enum values and titles from the schema.
  */

  static function generate_filter_schema_fields( $filter_fields, $data_schema ){
    $filter_schema_fields = array();

		$local_values = get_option('murmurations_aggregator_filter_options');

    foreach ( $filter_fields as $field ) {
      if( isset( $data_schema['properties'][$field] ) ){
        $field_attribs = $data_schema['properties'][$field];
        $filter_schema_fields[$field] = array(
          "title" => $field_attribs['title'],
          "type" => $field_attribs['type'] == "boolean" ? "boolean" : "string",
          "operator" => "includes"
        );

        $enum_data = self::get_field_enums( $field, $field_attribs, $local_values );

        if ( $enum_data ){
          $filter_schema_fields[$field]['enum'] = $enum_data[0];
          $filter_schema_fields[$field]['enumNames'] = $enum_data[1];
        }

      }

    }
    return $filter_schema_fields;
  }

  static function get_field_enums( $field, $field_attribs, $local_values ){
    $enum = array();
    $enumNames = array();
		$enum_keys = array();
		if ( isset( $local_values[ $field ] ) ) {

			$local_values[ $field ] = array_values( $local_values[ $field ] );

			if( isset( $field_attribs['enum'] ) ){
				foreach ( $field_attribs['enum'] as $key => $value ) {
					if ( in_array( $value, $local_values[ $field ] ) ) {
						$enum_keys[] = $key;
					}
				}

				foreach ($enum_keys as $key) {
					$enum[$key] = $field_attribs['enum'][$key];
					if ( isset( $field_attribs['enumNames'] ) ) {
						$enumNames[$key] = $field_attribs['enumNames'][$key];
					}
				}

			} else {
				$enum = $local_values[ $field ];
			}

			// Arrays need to be reindexed, because otherwise json_encode turns them into
			// objects
			return array( array_values( $enum ), array_values( $enumNames ) );

		} else {
			return false;
		}
  }
}
