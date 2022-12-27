<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
public function __construct() {

	parent::__construct();
  $this->load->model("Usuario_model","user");
  $this->load->library("session");
  $this->load->library('form_validation');
  $this->load->library('Mailer.php');
  $this->load->library('Chat.php');
 $this->data['errores'] = array();

  $site_lang = $this->session->userdata('site_lang');
  if ($site_lang) {
	$this->lang->load('header',$this->session->userdata('site_lang'));
  }else{$this->lang->load('header','spanish');}

}
      public function login(){
        echo "gol";
        exit;
      	$this->load->view('login/login');
      }



}
