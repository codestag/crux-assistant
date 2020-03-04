<?php
/**
 * Plugin Name: Crux Assistant
 * Plugin URI: https://github.com/Codestag/crux-assistant
 * Description: A plugin to assist Crux theme in adding widgets.
 * Author: Codestag
 * Author URI: https://codestag.com
 * Version: 1.0
 * Text Domain: crux-assistant
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Crux
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crux_Assistant' ) ) :
	/**
	 * Crux Assistant.
	 *
	 * @since 1.0
	 */
	class Crux_Assistant {

		/**
		 * Class instance.
		 *
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * Register method to create a new instance.
		 *
		 * @since 1.0
		 */
		public static function register() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Crux_Assistant ) ) {
				self::$instance = new Crux_Assistant();
				self::$instance->define_constants();
				self::$instance->includes();
			}
		}

		/**
		 * Defines plugin constants.
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'CA_VERSION', '1.0' );
			$this->define( 'CA_DEBUG', true );
			$this->define( 'CA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'CA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Method to define a constant.
		 *
		 * @param string $name
		 * @param string $value
		 * @since 1.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Includes plugin files.
		 *
		 * @since 1.0
		 */
		public function includes() {
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-category-box.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-section-category-boxes.php';
			require_once CA_PLUGIN_PATH . 'includes/widgets/widget-static-content.php';

			if ( function_exists( 'stag_is_woocommerce_active' ) && stag_is_woocommerce_active() ) {
				require_once CA_PLUGIN_PATH . 'includes/widgets/widget-woo-best-sellers.php';
				require_once CA_PLUGIN_PATH . 'includes/widgets/widget-woo-featured-products.php';
				require_once CA_PLUGIN_PATH . 'includes/widgets/widget-woo-latest-products.php';
				require_once CA_PLUGIN_PATH . 'includes/widgets/widget-woo-on-sale-products.php';
				require_once CA_PLUGIN_PATH . 'includes/widgets/widget-woo-top-rated.php';
			}
		}
	}
endif;


/**
 * Invokes Crux_Assistant Class.
 *
 * @since 1.0
 */
function crux_assistant() {
	return Crux_Assistant::register();
}

/**
 * Activation notice.
 *
 * @since 1.0
 */
function crux_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Crux Assistant requires Crux WordPress Theme to be installed and activated.', 'crux-assistant' );
	echo '</p></div>';
}

/**
 * Assistant activation check.
 *
 * @since 1.0
 */
function crux_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme.
	if ( 'Crux' === $theme->name || 'Crux' === $theme->parent_theme ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			add_action( 'after_setup_theme', 'crux_assistant' );
		} else {
			crux_assistant();
		}
	} else {
		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'crux_assistant_activation_notice' );
	}
}

// Plugin loads.
crux_assistant_activation_check();
