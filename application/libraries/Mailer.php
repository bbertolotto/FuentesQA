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

use PHPmailer\PHPmailer\PHPMailer;
use PHPmailer\PHPmailer\Exception;
class Mailer
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPmailer/Exception.php';
        require_once APPPATH.'third_party/PHPmailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPmailer/SMTP.php';
        
        $mail = new PHPMailer();
        return $mail;
    }
}