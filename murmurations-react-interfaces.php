<?php
/**
 * Plugin Name:       Murmurations React Interfaces
 * Plugin URI:        https://murmurations.network
 * Description:       Client-side interfaces for the Murmurations Aggregator
 * Version:           0.2.0
 * Author:            A. McKenty / Photosynthesis
 * Author URI:        Photosynthesis.ca
 * License:           GPLv3
 * License URI:				https://www.gnu.org/licenses/gpl-3.0.html
 */

/*
The Murmurations React Interfaces plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Murmurations React Interfaces is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with the Murmurations Aggregator plugin. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

namespace Murmurations\Interfaces;

defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

define( 'MRI_WIDGET_PATH', plugin_dir_path( __FILE__ ) . 'widget' );
define( 'MRI_ASSET_MANIFEST', MRI_WIDGET_PATH . '/build/asset-manifest.json' );
define( 'MRI_INCLUDES', plugin_dir_path( __FILE__ ) . '/includes' );
define( 'MRI_BASE_PATH', plugin_dir_path( __FILE__ ) . '/' );
define( 'MRI_BASE_URL', plugin_dir_url( __FILE__ ) . '/' );

require_once( MRI_INCLUDES . '/enqueue.php' );
require_once( MRI_INCLUDES . '/shortcodes.php' );
require_once( MRI_INCLUDES . '/class-murmurations-interfaces.php' );
