<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/** We create the class for the plugin
 * author: Eric Zeidan
 */
class Suadm_plugin{

	public function __construct() {
		add_action( 'admin_menu',array($this,"add_option_menu"));
		add_action( 'admin_enqueue_scripts', array($this, "fpadmin_admin_init"));
		add_action( 'init', array($this, 'secure_uradmin_block'));
		add_filter( 'plugin_row_meta', array($this,"suadm_row_meta"), 10, 2);
		add_filter( 'plugin_action_links_secure-uradmin/secure-uradmin.php', array($this,'suadm_action_links'));
		add_action( 'plugins_loaded', array($this, 'suadmplugin_text'));
	}

	public function suadmplugin_text() {
		load_plugin_textdomain('suadmplugin', false, basename(dirname(__FILE__)) . '/langs');
	}

	public function add_option_menu(){
		add_options_page("Suadm_plugin", "Secure ur Admin", "read", __FILE__,array($this, 'admin_menu'));
	}

	public function fpadmin_admin_init() {
		wp_enqueue_script( "jquery" );
        wp_enqueue_script( 'suadm-admin-script', plugins_url( '../js/adminscript.js', __FILE__ ), array( 'jquery') );
		wp_enqueue_script( 'suadm-bswitch-script', plugins_url( '../js/bootstrap-switch.min.js', __FILE__ ), array( 'jquery') );
		wp_enqueue_style( 'suadm-bswitch-stylesheet', plugins_url( '../css/bootstrap-switch.min.css', __FILE__ ));
        wp_enqueue_style( 'suadm-admin-stylesheet', plugins_url( '../css/adminstyle.css', __FILE__ ));
	}


	public function admin_menu(){
		include('optionssuadm.php');
	}

	function secure_uradmin_block() {
		global $pagenow;
		$option_name = 'wp_suadm_options';
		$inputs = get_option($option_name);
		if ( ('wp-login.php' == $pagenow && !isset($_REQUEST['redirect_to'])) && $_REQUEST['action'] != 'logout' || (is_admin() && !current_user_can( 'administrator' ) &&
			! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && !isset($_REQUEST[$inputs[0]['varname']]) && md5(sanitize_text_field($_REQUEST[$inputs[0]['varname']])) != $inputs[0]['hashname'])) {
			wp_redirect( home_url() );
			exit;
		}
	}

	public function suadm_row_meta( $links, $file ) {
		if ( strpos( $file, 'secure-uradmin/secure-uradmin.php' ) !== false ) {
			$new_links = array(
				'twitter' => '<a href="http://twitter.com/ericjanzei" target="_blank">Twitter</a>',
				'Donate' => '<a href="http://paypal.me/EricZeidan" target"_blank">Donate</a>'
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}

	public function suadm_action_links ( $links ) {
		$mylinks = array(
			'<a href="' . admin_url( 'options-general.php?page=secure-uradmin/inc/class_suadm.php' ) . '">' . __('Settings','suadmplugin') . '</a>',
		);
		return array_merge( $links, $mylinks );
	}

}