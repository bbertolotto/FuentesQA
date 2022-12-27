<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager  extends CI_Controller {

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

        $site_lang = $this->session->userdata('site_lang');
        if ($site_lang) {$this->lang->load('header',$this->session->userdata('site_lang'));
        } else {$this->lang->load('header','spanish'); }

    }
	public function index()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/search');
	}

	public function search()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock"));}
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/search');
	}

	public function valid()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/valid');
	}

	public function documents()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/documents');
	}

	public function approbation()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/approbation');
	}

	public function linked()
	{
        if ($this->session->userdata('lock') === NULL) {redirect(base_url());}
        if( $this->session->userdata('lock') == "0"){redirect(base_url("dashboard/lock")); }
				$this->session->set_userdata('selector', '4.1.3');
				$this->load->view('manager/linked');
	}

}
