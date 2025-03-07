<?php
/**
 * Plugin Name:      Weave Environment Indicator for GridPane
 * Plugin URI:        https://github.com/weavedigitalstudio/environment-indicator-for-gridpane
 * Description:       MU Plugin to add environment indicator and change admin bar color on staging sites
 * Version:           1.1.0
 * Author:            Weave Digital Studio, G Bissland
 * Author URI:        https://weave.co.nz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * CUSTOMIZATION GUIDE:
 * - To change staging admin bar color: Edit #wpadminbar background-color value
 * - To change indicator appearance: Edit #wp-admin-bar-environment-indicator .ab-item styles
 * - To change indicator background: Edit the rgba(255,255,255,0.2) value
 * - To hide on frontend: Remove the wp_head action at the bottom
 */
 
// Basic security, prevents file from being loaded directly.
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Apply admin bar styles for staging environment and add indicator styling
 */
function weave_environment_styling() {
  if (!function_exists('wp_get_environment_type')) {
    return;
  }
  
  $environment_type = wp_get_environment_type();
  
  // Only change admin bar color for staging environments
  if ($environment_type === 'staging') {
    // Change this color to adjust staging environment admin bar
    echo '<style>#wpadminbar { background-color: #00a32a !important; }</style>';
  }
  
  // Add pill-shaped indicator styling
  echo '<style>
    /* Environment indicator container */
    #wp-admin-bar-environment-indicator {
      margin: 0 !important;
    }
    /* Environment indicator pill appearance */
    #wp-admin-bar-environment-indicator .ab-item {
      padding: 0 8px !important;
      font-size: 10px !important;
      font-weight: bold !important;
      line-height: 17px !important;
      height: auto !important;
      margin-top: 7px !important;
      margin-right: 5px !important;
      border-radius: 10px !important;
      background: rgba(255,255,255,0.2) !important;
      cursor: default !important;
      text-transform: uppercase !important;
    }
  </style>';
}

/**
 * Add the environment indicator to the admin bar
 */
function weave_add_environment_indicator($admin_bar) {
  if (!function_exists('wp_get_environment_type')) {
    return;
  }
  
  $environment_type = wp_get_environment_type();
  
  $admin_bar->add_node([
    'id'    => 'environment-indicator',
    'title' => ucfirst($environment_type),
    'parent' => 'top-secondary', // Add to the right side of admin bar
    'href'  => false,
    'meta'  => [
      'onclick' => 'javascript:void(0);',
      'class' => 'environment-indicator'
    ]
  ]);
}

// Apply admin bar styling and add environment indicator
add_action('admin_head', 'weave_environment_styling');
add_action('wp_head', 'weave_environment_styling');
add_action('admin_bar_menu', 'weave_add_environment_indicator', 100); // Higher priority for right side placement
