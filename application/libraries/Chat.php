<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use Chatkit\Chatkit;



class Chat
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load($instancia,$key){
        // Include PHPMailer library files
               require_once APPPATH.'third_party/firebase/php-jwt/src/JWT.php';
               require_once APPPATH.'third_party/Chatkit/Chatkit.php';

        
        $chatkit = new Chatkit([
                'instance_locator' => $instancia,
                'key' => $key
        ]);
        return $chatkit;
    }
}