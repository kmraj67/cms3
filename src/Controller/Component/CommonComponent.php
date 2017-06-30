<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Mailer\Email;
use Cake\Core\Configure;

/**
 * Common component
 */
class CommonComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function genratePassword($length=8) {
        return strtoupper(substr(md5(time()),0,$length));
    }
    
    /*
     *@method genrateToken This function is used to generate token for forgot password
     *@param $value a string to append with time and rand functions
     *@return token
    */
    public function genrateToken($value, $is_base64=true) {
        if($is_base64 === true) {
            return base64_encode(md5(time()*rand()).''.md5($value));
        } else {
            return md5(time()*rand()).''.md5($value);    
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
    
    /*
     *@method sendEmail
     *@desc This function is used to send an email
     *@param $toEmail email of recipient
     *@param $subject email subject
     *@param $email_data array of email attributes
     *@param $template template of email
     *@param $layout layout of the email body
     *@param $ccEmail email of cc recipient
    */
    public function sendEmail($toEmail,$subject,$email_data=[],$template,$layout='default',$ccEmail=[]) {
        $email = new Email();
        $email->transport();
        try {
            $email->template($template,$layout)
                ->viewVars($email_data)
                ->emailFormat('html')
                //->from(Configure::read('from_email'))
                ->to($toEmail);
                
            if(!empty($ccEmail)) {
                $email->cc($ccEmail);
            }
            $email->subject($subject)->send();
        } catch (Exception $e) {
            echo 'Exception : ',  $e->getMessage(), "<br />";
        }
    }

    public function getResponse($code, $status=null, $message=null) {
        $response = Configure::read('http_codes.'.$code);
        if(!empty($status)) {
            $response['status'] = $status;    
        }
        if(!empty($message)) {
            $response['message'] = $message;    
        }
        return $response;
    }
    
    public function getErrors($errs) {
        $errors = [];
        foreach($errs as $key=>$val) {
            foreach($val as $errVal) {
                $errors[$key] = $errVal;
            }
        }
        return $errors;
    }
}
