<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Authentication class
 *
 * @package     Form_auth
 * @category    Library
 * @author      Renfrid Ngolongolo
 * @link        http://sacids.org
 */
class Form_auth
{

	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		log_message('debug', 'Form_auth library initialized');
	}


	// This function forces a login prompt
	function require_login_prompt($realm, $nonce)
	{
		$qop = "auth";
		//http_response_code(401);
		header("HTTP/1.1 401 Unauthorized");
		header('Content-Type:text/xml; charset=utf-8');
		header('WWW-Authenticate:Digest realm="' . $realm . '",qop="auth",nonce="' . $nonce . '",opaque="' . $nonce . '"');
		header('HTTP_X_OPENROSA_VERSION:1.0');
		header('X-OpenRosa-Version:1.0');
	}

	// This function extracts the separate values from the digest string
	function http_digest_parse($digest)
	{
		// protect against missing data
		$needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
		$data = array();

		preg_match_all('@(\w+)=(?:(?:")([^"]+)"|([^\s,$]+))@', $digest, $matches, PREG_SET_ORDER);

		foreach ($matches as $m) {
			$data[$m[1]] = $m[2] ? $m[2] : $m[3];
			unset($needed_parts[$m[1]]);
		}

		return $needed_parts ? FALSE : $data;
	}
}