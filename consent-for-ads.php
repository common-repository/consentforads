<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Plugin Name: ConsentForAds
 * Description: Ad Consent Management Plugin by UnveilMedia
 * Author: UnveilMedia.com
 * Author URI: https://www.unveilmedia.com/
 * Text Domain: consent-for-ads
 * Version: 1.0
 */



if ( ! defined( 'CONSENT_FOR_ADS_VERSION' ) ) {
	define( 'CONSENT_FOR_ADS_VERSION', '1.0' );
}
if ( ! defined( 'CONSENT_FOR_ADS_CMP_VERSION' ) ) {
	define( 'CONSENT_FOR_ADS_CMP_VERSION', '0.1.0' );
}

class Consent_For_Ads {

	static $instance = null; // singleton pattern

	protected $enable_debug;
	protected $plugin_url;

	protected function __construct() {
		$this->enable_debug = ! empty( $_COOKIE['um-debug'] ) || get_option( 'consent_for_ads_enable_debug' );
		$this->plugin_url   = plugins_url( '/', __FILE__ );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );

		if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
			add_action( 'wp', array( $this, 'init' ) );
		}

		// need to remove to avoid prefetching in firefox (HELLO WORLD developers), @see http://www.ebrueggeman.com/blog/wordpress-relnext-and-firefox-prefetching
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

		register_activation_hook( __FILE__, array( $this, 'install' ) );
		register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );
	}

	function get_environment() {
		$baseDomain  = '';
		$devDomains  = array(
			'wptestbed.vubuntu.spottmedia.co.uk',
			'wm.vubuntu.spottmedia.co.uk',
			'gm.vubuntu.spottmedia.co.uk'
		);
		$testDomains = array(
			'wptestbed.spottmedia.com',
			'test.watchmarvel.com',
			'test.gmotors.co.uk'
		);

		if ( isset( $_SERVER ) && array_key_exists( "SERVER_NAME", $_SERVER ) ) {
			$baseDomain = $_SERVER["SERVER_NAME"];
		}

		if ( in_array( $baseDomain, $devDomains ) ) {

			return 'dev';

		} elseif ( in_array( $baseDomain, $testDomains ) ) {

			return 'test';

		} else {

			return 'live';
		}

	}

	public function uninstall() {
		$this->remove_plugin_options();
	}

	public function get_plugin_options() {
		global $wpdb;

		$sql = "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'consent_for_ads_%'";

		return $wpdb->get_results( $sql );
	}

	public function remove_plugin_options() {
		foreach ( $this->get_plugin_options() as $option ) {
			delete_option( $option->option_name );
		}
	}


	function enqueue_scripts() {
		$environment = $this->get_environment();

		if ( $environment === 'dev' ) {

			$url = '//unveilmediacmp.vubuntu.spottmedia.co.uk';

		} elseif ( $environment === 'test' ) {

			$url = '//cmp.test.unveilmedia.com';

		} else {

			$url = '//unveilmedia.mgr.consensu.org';

		}

		wp_enqueue_script( 'consent_for_ads', $url . '/cmp-' . CONSENT_FOR_ADS_CMP_VERSION . '.js?v=' . CONSENT_FOR_ADS_VERSION );
	}

	function enqueue_admin_styles() {
		wp_enqueue_style( 'consent_for_ads', plugin_dir_url( __FILE__ ) . 'css/main-admin.css?v=' . CONSENT_FOR_ADS_VERSION );
	}

	function install() {
		$installed_ver = get_option( 'consent_for_ads_version' );

		if ( $installed_ver != CONSENT_FOR_ADS_VERSION ) {
			foreach ( $this->getDefaultOptions() as $optionName => $value ) {
				update_option( $optionName, $value );
			}
		}
	}


	protected function getDefaultOptions() {
		return array(
			'consent_for_ads_version' => CONSENT_FOR_ADS_VERSION
		);
	}

	/**
	 * makes a message compatible with a theme, just a quick and dirty way for now
	 *
	 * @param $msg
	 */
	protected function display_debug( $msg ) {
		echo '<div class="site"><div class="site-content">' . $msg . '</div></div>';
	}

	public function init() {
		if ( $this->enable_debug ) {
			$this->display_debug( '*ConsentForAds is active*' );
		}

		if(get_option( 'consent_for_ads_terms_accepted' )) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		} else {
			$this->display_debug( '*ConsentForAds Terms & Conditions are not accepted - plugins does not work*' );
		}
	}

	public function admin_menu() {
		add_menu_page( 'ConsentForAds by UnveilMedia', 'ConsentForAds', 'manage_options', 'consent-for-ads', array( $this, 'plugin_options' ), $this->plugin_url . 'img/um-avatar.png' );
	}

	public function plugin_options() {
		require "consent-for-ads.admin.inc.php";
	}

	/**
	 * @return Consent_For_Ads
	 */
	public static function get_instance() {
		return self::instance();
	}

	public static function instance() {
		if ( ! Consent_For_Ads::$instance ) {
			Consent_For_Ads::$instance = new self();
		}

		return Consent_For_Ads::$instance;
	}

}

$unveil_Media_Videowall = Consent_For_Ads::instance();

/**
 * Class Consent_For_Ads_Hard_Exception
 * can't ever be recovered
 */
class Consent_For_Ads_Hard_Exception extends Exception {

}

/**
 * Class Consent_For_Ads_Soft_Exception
 * upon certain circumstances we may gracefully handle this exception
 */
class Consent_For_Ads_Soft_Exception extends Exception {

}