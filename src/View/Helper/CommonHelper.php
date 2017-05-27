<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Common helper
 */
class CommonHelper extends Helper {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function dateFormat($date, $format = 'M j, Y') {
    	if(!empty($date)) {
        	return date($format, strtotime($date));
    	} else {
    		return $date;
    	}
    }
    
    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * PHP 5.4.9
     *
     * this is a beginners template for simple encryption decryption
     * before using this in production environments, please read about encryption
     *
     * @param string $action: can be 'encrypt' or 'decrypt'
     * @param string $string: string to encrypt or decrypt
     *
     * @return string
     */
    function encrypt_decrypt($action, $string) {
        $output = false;        
        $encrypt_method = ENC_METHOD;
        $secret_key     = ENC_KEY;
        $secret_iv      = ENC_IV;
		// hash
        $key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
		if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
		return $output;
    }
    
    function encrypt($string) {
        return $this->encrypt_decrypt('encrypt', $string);
    }
    
    function decrypt($string) {
        return $this->encrypt_decrypt('decrypt', $string);
    }
}
