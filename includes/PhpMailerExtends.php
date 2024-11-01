<?php
namespace YaySMTPSendinBlue;

use YaySMTPSendinBlue\Helper\Utils;

defined( 'ABSPATH' ) || exit;

class PhpMailerExtends extends \PHPMailer\PHPMailer\PHPMailer {
	public function send() {
		$currentMailer = Utils::getCurrentMailer();
		if ( ! $this->preSend() ) {
			return false;
		}

		if ( $this->getSMTPerObj( $currentMailer ) ) {
			return $this->getSMTPerObj( $currentMailer )->send();
		}

		return false;
	}

	public function getSMTPerObj( $provider ) {
		$providers = array(
			'sendinblue' => 'Sendinblue',
		);
		$tyleFile  = $providers[ $provider ] . 'Controller';
		return $this->getObject( $tyleFile );
	}

	protected function getObject( $fileType ) {
		$obj = null;
		try {
			$class = 'YaySMTPSendinBlue\Controller\\' . $fileType;
			$file  = YAY_SMTP_SENDINBLUE_PLUGIN_PATH . 'includes/Controller/' . $fileType . '.php';
			if ( file_exists( $file ) && class_exists( $class ) ) {
				$obj = $this ? new $class( $this ) : new $class();
			}
		} catch ( \Exception $e ) {
		}

		return $obj;
	}
}
