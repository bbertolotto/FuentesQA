 <?php   
  /**
   * @package Contact :  CodeIgniter Multi Language Loader
   *
   * @author TechArise Team
   *
   * @email  info@techarise.com
   *   
   * Description of Multi Language Loader Hook
   */
 
  class LanguageLoader
  {
      function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');

        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            $ci->lang->load('header',$ci->session->userdata('site_lang'));
        } else {
            $ci->lang->load('header','english');
        }
    }
  }
  ?>