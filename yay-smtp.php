<?php
/**
 * Plugin Name: SMTP for Sendinblue – YaySMTP
 * Plugin URI: https://yaycommerce.com/yaysmtp-wordpress-mail-smtp
 * Description: This plugin helps you send emails from your WordPress website via your Sendinblue SMTP.
 * Version: 1.1.1
 * Author: YayCommerce
 * Author URI: https://yaycommerce.com
 * Text Domain: smtp-sendinblue
 * Domain Path: /i18n/languages/
 */

namespace YaySMTPSendinBlue;

defined( 'ABSPATH' ) || exit;

// Define variables of SendinBlue mailer - start
if ( ! defined( 'YAY_SMTP_SENDINBLUE_PREFIX' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_PREFIX', 'yay_smtp_sendinblue' );
}

if ( ! defined( 'YAY_SMTP_SENDINBLUE_VERSION' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_VERSION', '1.1.1' );
}

if ( ! defined( 'YAY_SMTP_SENDINBLUE_PLUGIN_URL' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YAY_SMTP_SENDINBLUE_PLUGIN_PATH' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YAY_SMTP_SENDINBLUE_PLUGIN_BASENAME' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YAY_SMTP_SENDINBLUE_SITE_URL' ) ) {
	define( 'YAY_SMTP_SENDINBLUE_SITE_URL', site_url() );
}

// Define variables of SendinBlue mailer - end

spl_autoload_register(
	function ( $class ) {
		$prefix   = __NAMESPACE__; // project-specific namespace prefix
		$base_dir = __DIR__ . '/includes'; // base directory for the namespace prefix

		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) { // does the class use the namespace prefix?
			return; // no, move to the next registered autoloader
		}

		$relative_class_name = substr( $class, $len );

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( '\\', '/', $relative_class_name ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

if ( version_compare( get_bloginfo( 'version' ), '5.5-alpha', '<' ) ) {
	if ( ! class_exists( '\PHPMailer', false ) ) {
		require_once ABSPATH . 'wp-includes/class-phpmailer.php';
	}
} else {
	if ( ! class_exists( '\PHPMailer\PHPMailer\PHPMailer', false ) ) {
		require_once ABSPATH . 'wp-includes/PHPMailer/PHPMailer.php';
	}
	if ( ! class_exists( '\PHPMailer\PHPMailer\Exception', false ) ) {
		require_once ABSPATH . 'wp-includes/PHPMailer/Exception.php';
	}
	if ( ! class_exists( '\PHPMailer\PHPMailer\SMTP', false ) ) {
		require_once ABSPATH . 'wp-includes/PHPMailer/SMTP.php';
	}
}

function init() {
	Schedule::getInstance();
	Plugin::getInstance();
	I18n::getInstance();
}
add_action( 'plugins_loaded', 'YaySMTPSendinBlue\\init' );

register_activation_hook( __FILE__, array( 'YaySMTPSendinBlue\\Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'YaySMTPSendinBlue\\Plugin', 'deactivate' ) );
