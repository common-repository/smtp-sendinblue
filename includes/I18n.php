<?php
namespace YaySMTPSendinBlue;

defined( 'ABSPATH' ) || exit;

class I18n {
	protected static $instance = null;

	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'loadPluginTextdomain' ) );
	}

	public function loadPluginTextdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			$locale = is_admin() ? get_user_locale() : get_locale();
		}
		unload_textdomain( 'smtp-sendinblue' );
		load_textdomain( 'smtp-sendinblue', YAY_SMTP_SENDINBLUE_PLUGIN_PATH . '/i18n/languages/smtp-sendinblue-' . $locale . '.mo' );
		load_plugin_textdomain( 'smtp-sendinblue', false, YAY_SMTP_SENDINBLUE_PLUGIN_PATH . '/i18n/languages/' );
	}
}
