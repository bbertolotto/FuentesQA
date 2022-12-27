
    <?php
    /**
     * @package Contact :  CodeIgniter Multi Language Switcher
     *
     * @author TechArise Team
     *
     * @email  info@techarise.com
     *   
     * Description of Multi Language Switcher Controller
     */
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
     
    class MultiLanguageSwitcher extends CI_Controller
    {
        public function __construct() {
            parent::__construct();    
             $this->load->helper('url'); 
        }
        // create language Switcher method
        function switch($language = "") {      

            $language = ($language != "") ? $language : "english";
            $this->session->set_userdata('site_lang', $language);    
            redirect($_SERVER['HTTP_REFERER']);        
        }
    }