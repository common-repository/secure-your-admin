<?php
/*
Plugin Name: Secure your Admin
Plugin URI: http://zeidan.info/secure-uradmin
Description: A Plugin to extra secure your admin access
Version: 1.0
Author: Eric Zeidan
Author URI: http://zeidan.info/
twitter: ericjanzei
License: GPL2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include('inc/class_suadm.php');

//redireccionamos al activar

register_activation_hook(__FILE__, "secure_uradmin_plugin_activate");
add_action('admin_init', 'secure_uradmin_plugin_redirect');

function secure_uradmin_plugin_activate() {
    add_option('secure_uradmin_plugin_do_activation_redirect', true);
}

function secure_uradmin_plugin_redirect() {
    if (get_option('secure_uradmin_plugin_do_activation_redirect', false)) {
        delete_option('secure_uradmin_plugin_do_activation_redirect');
        if (!isset($_GET['activate-multi'])) {
            wp_redirect("options-general.php?page=secure-your-admin%2Finc%2Fclass_suadm.php");
        }
    }
}

//creamos la instancia para poder utilizarlo 
$suadmplugin = new Suadm_plugin();