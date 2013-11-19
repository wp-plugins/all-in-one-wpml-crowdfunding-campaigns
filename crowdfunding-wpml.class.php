<?php 

class Sofa_Crowdfunding_WPML {

	/** 
	 * @var Sofa_Crowdfunding_WPML
	 */
	private static $instance = null;

	/**
	 * Private constructor. Singleton pattern.
	 */
	private function __construct() {
		add_filter( 'atcf_shortcode_submit_fields', array(&$this, 'atcf_shortcode_submit_fields') );
		add_filter( 'atcf_campaign_backers_args', array(&$this, 'atcf_campaign_backers_args') );
	}

	/**
	 * Return the class instance.
	 * 
	 * @return Sofa_Crowdfunding_WPML
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new Sofa_Crowdfunding_WPML();
		}
		return self::$instance;
	}

	/**
	 * Filter the submit page fields
	 * 
	 * @uses atcf_shortcode_submit_fields
	 * @param array $fields
	 * @return array
	 * @since alpha-0.1
	 */
	public function atcf_shortcode_submit_fields( $fields ) {
		return $fields;
	}

	/**
	 * Filter the arguments passed to the campaign backers query.
	 * 
	 * @uses atcf_campaign_backers_args
	 * @param array $args
	 * @return array
	 * @since alpha-0.1
	 */
	public function atcf_campaign_backers_args( $args ) {		
		$args['post_parent__in'] = $this->get_all_campaign_ids( $args['post_parent'] );
		unset( $args['post_parent'] );
		return $args;
	}

	/**
	 * Returns the list of all IDs that belong under this campaign's umbrella.
	 *
	 * @param int $campaign_id
	 * @return array
	 * @since alpha-0.1
	 */
	private function get_all_campaign_ids( $campaign_id ) {
		global $sitepress;

		$trid = $sitepress->get_element_trid($campaign_id, 'post_download');
		$ids = array();

		foreach ($sitepress->get_element_translations($trid, 'post_download') as $translation) {
			$ids[] = $translation->element_id;
		}			

		return $ids;
	}

	/**
	 * Returns the list of IDs of all children campaigns. 
	 * 
	 * @global $wpdb;
	 * @param int $parent_id
	 * @return array
	 * @since alpha-0.1
	 * @deprecated
	 */
	private function get_merged_campaign_ids( $parent_id ) {
		global $wpdb;

		return array_merge( array( $parent_id ), 
			$wpdb->get_col( $wpdb->prepare( 
				"SELECT post_id 
				FROM $wpdb->postmeta
				WHERE meta_key = '_icl_lang_duplicate_of'
				AND meta_value = %d;", $parent_id
			) ) );
	}
}