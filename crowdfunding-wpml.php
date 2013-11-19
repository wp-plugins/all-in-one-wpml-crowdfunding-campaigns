<?php
/*
Plugin Name: All-in-one WPML Crowdfunding Campaigns
Plugin URI: https://github.com/Studio164a/crowdfunding-wpml
Description: Unite all your WPML translations of a single crowdfunding campaign, so that the statistics for each are counted towards the whole.
Version: 1.0.2
Author: Eric Daams
Author URI: http://164a.com

All-in-one WPML Crowdfunding Campaigns is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

All-in-one WPML Crowdfunding Campaigns is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with All-in-one WPML Crowdfunding Campaigns. If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check that Easy Digital Downloads, Appthemer Crowdfunding and WPML are all installed. 
 * @return void
 */
function sofa_crowdfunding_init() {
	// Make sure that Easy Digital Downloads, Appthemer Crowdfunding and WPML are all activated
	if ( class_exists('Easy_Digital_Downloads') 
		&& class_exists('ATCF_CrowdFunding')
		&& defined('ICL_SITEPRESS_VERSION') ) {

		include_once('crowdfunding-wpml.class.php');	

		// Start 'er up
		get_sofa_crowdfunding_wpml();
	}
}

add_action('plugins_loaded', 'sofa_crowdfunding_init');

/**
 * Returns the one and only instance of this plugin
 * @return Sofa_Crowdfunding_WPML
 */
function get_sofa_crowdfunding_wpml() {
	return Sofa_Crowdfunding_WPML::get_instance();
}
