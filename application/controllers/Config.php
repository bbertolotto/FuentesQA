<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config  extends CI_Controller {

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
      //llamamos al constructor de la clase padre
    parent::__construct();

    $this->load->model("Usuario_model","user");
    $this->load->library("session");
    $this->load->library('form_validation');

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}
}

public function index(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '6.1.1');
    $this->load->view('config/monitorcampaign');
}
public function loadcampaign(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '6.1.1');
    $this->load->view('config/loadcampaign');
}
public function downloadcampaign(){
    if($this->session->userdata('lock') === NULL){redirect(base_url());}
    if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '6.1.2');
    $this->load->view('config/downloadcampaign');
}
public function monitorcampaign(){
		if($this->session->userdata('lock') === NULL){redirect(base_url());}
		if($this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
    $this->session->set_userdata('selector', '6.1.3');
		$this->load->view('config/monitorcampaign');
}

}
