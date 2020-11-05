<?php
/**
* Plugin Name: Save and Share Cart for WooCommerce
* Description: This plugin allows user to save and share cart, receiver can directly import cart and purchase cart items.
* Version: 1.0
* Copyright: 2020
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  die('-1');
}
if (!defined('WOOSASC_PLUGIN_NAME')) {
  define('WOOSASC_PLUGIN_NAME', 'Save and Share Cart for WooCommerce');
}
if (!defined('WOOSASC_PLUGIN_VERSION')) {
  define('WOOSASC_PLUGIN_VERSION', '1.0');
}
if (!defined('WOOSASC_PLUGIN_FILE')) {
  define('WOOSASC_PLUGIN_FILE', __FILE__);
}
if (!defined('WOOSASC_PLUGIN_DIR')) {
  define('WOOSASC_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('WOOSASC_DOMAIN')) {
  define('WOOSASC_DOMAIN', 'woosasc');
}


if (!class_exists('WOOSASC')) {

    class WOOSASC {

        protected static $WOOSASC_instance;
        function __construct() {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            //check woocommerce plugin activted or not
            add_action('admin_init', array($this, 'WOOSASC_check_plugin_state'));
        }


        function WOOSASC_check_plugin_state(){
            if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
                set_transient( get_current_user_id() . 'woosascerror', 'message' );
            }
        }


        function init() {
            add_action( 'admin_notices', array($this, 'WOOSASC_show_notice'));
            add_action( 'wp_enqueue_scripts',  array($this, 'WOOSASC_load_front'));
            add_filter( 'wp_mail_content_type', array($this, 'WOOSASC_email_set_content_type' ));
        }


        function WOOSASC_show_notice() {
            if ( get_transient( get_current_user_id() . 'woosascerror' ) ) {

                deactivate_plugins( plugin_basename( __FILE__ ) );

                delete_transient( get_current_user_id() . 'woosascerror' );

                echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
            }
        }


        function WOOSASC_load_front() {
            wp_enqueue_style( 'WOOSASC_front_style', WOOSASC_PLUGIN_DIR . '/includes/css/woosasc_front_style.css', false, '1.0.0' );
            wp_enqueue_style( 'WOOSASC_front_fa_css', WOOSASC_PLUGIN_DIR . '/includes/css/font-awesome.min.css', false, '1.0.0' );
            wp_enqueue_style( 'WOOSASC_front_fa_css' );
            wp_enqueue_script( 'WOOSASC_admin_script', WOOSASC_PLUGIN_DIR . '/includes/js/woosasc_front_script.js', false, '1.0.0' );
            wp_localize_script( 'WOOSASC_admin_script', 'ajax_url', admin_url('admin-ajax.php') );
            $translation_array_img = WOOSASC_PLUGIN_DIR;
            wp_localize_script( 'WOOSASC_admin_script', 'woosasc_loader', $translation_array_img ); 
        }


        function WOOSASC_email_set_content_type(){
            return "text/html";
        }
        

        function includes() {
            include_once('admin/woosasc_admin_settings.php');           
            include_once('front/woosasc_front_cart.php');
        }

        //Flush rewrite rules update permalinks
        public static function WOOSASC_do_activation() {
          	flush_rewrite_rules();
        }


        public static function WOOSASC_instance() {
            if (!isset(self::$WOOSASC_instance)) {
                self::$WOOSASC_instance = new self();
                self::$WOOSASC_instance->init();
                self::$WOOSASC_instance->includes();
            }
            return self::$WOOSASC_instance;
        }
    }
    add_action('plugins_loaded', array('WOOSASC', 'WOOSASC_instance'));

    register_activation_hook( WOOSASC_PLUGIN_FILE, array('WOOSASC', 'WOOSASC_do_activation'));
}