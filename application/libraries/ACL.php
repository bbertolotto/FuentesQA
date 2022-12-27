<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Short escription of ACL
 *
 * Long description
 *
 * @author Nicolás Tavella
 * @author nicolastavella@gmail.com
 */
class ACL {

    private $CI;
    private $router;
    private $permisos;

    public function __construct() {
        $this->CI = & get_instance();
        $this->router = & load_class('Router');
        $this->permisos = array();
        /**
         * SACAR el clear
         */
        $this->clear();
        if ($this->CI->session->userdata('acl')) {
            $this->permisos = unserialize($this->CI->session->userdata('acl'));
        } else {
            $acl = $this->cargar();
            $this->permisos = $acl;
        }
    }



public  function print_eventlog($data) {

$fp = fopen(SHOW_NAME_LOGFILE.date('Y-m-d').'.log', 'a');
$data = ">>>>>> " . $data ." <<<<<<<" . PHP_EOL;
fwrite($fp, $data);
fclose($fp);

}

public function checkAccess() {


/***
        $datos = json_encode($_POST);
        $palabras_reservadas = array('script', 'select', 'delete', 'update', 'insert', 'truncate', 'remove', 'confirm', 'alert');
        $palabras_reservadas_count = count($palabras_reservadas);
        for ($i = 0; $i < $palabras_reservadas_count; ++$i){

            if(preg_match("/" . $palabras_reservadas[$i] ."/i", $datos)) {

                if ($this->CI->input->is_ajax_request()) {

                    $this->data = array();
                    $this->data['retorno'][] = -1;
                    $this->data['descRetorno'][] = "Alerta de seguridad, uso de palabras reservadas..!";
                    echo json_encode($this->data);
                    exit();

                }else{

                    $this->CI->session->set_flashdata('message_name', 'Alerta de seguridad, uso de palabras reservadas..!');
                    redirect(base_url('dashboard/noaccess'));

                }

            }
        }
****/
        $currentUser = $this->CI->session->userdata('current_user');

        if (!$currentUser || !isset($currentUser['id_rol'])) {
            $currentUser = array(
                'id' => 55,
                'email' => '',
                'nombre' => 'MAXBOT',
                'id_rol' => 5
            );

            $this->CI->session->set_userdata('current_user', $currentUser);
            $this->CI->session->set_userdata('referer', base_url() . $this->router->fetch_class() . "/" . $this->router->fetch_method());
        }

        if (isset($this->permisos[strtolower($this->router->fetch_class())][$this->router->fetch_method()])) {

            if (in_array((int) $currentUser['id_rol'], $this->permisos[strtolower($this->router->fetch_class())][$this->router->fetch_method()], 0)) {
                return;
                exit();
            } else {
                $this->CI->session->set_userdata('referer', base_url() . $this->router->fetch_class() . "/" . $this->router->fetch_method());
            }
        } else {
            $this->CI->session->set_userdata('referer', base_url() . $this->router->fetch_class() . "/" . $this->router->fetch_method());
        }

        if ($this->CI->input->is_ajax_request()) {

            $this->data = array();
            $this->data['retorno'][] = 600;
            $this->data['descRetorno'][] = "Permisos insuficientes.";
            $this->data['class'][] = $this->router->fetch_class();
            $this->data['method'][] = $this->router->fetch_method();

            echo json_encode($this->data);
            exit();

        }


        if(isset($currentUser['id_rol'])){

            $id = $this->CI->session->userdata('id');
            if(isset($id)){

                 $this->CI->session->set_flashdata('message_name', 'Permisos insuficientes.');
                 redirect(base_url('dashboard/noaccess'));

            }else{

                $this->CI->session->set_flashdata('message_name', 'Permisos insuficientes.');

                  redirect(base_url());

            }

        }

    }

    public function clear() {

        $this->CI->session->unset_userdata('acl');

    }

    public function cargar() {

        $acl = array();
        $this->CI->db->select('*');
        if ($res = $this->CI->db->get('ta_users_permits')) {
            if ($res->num_rows()) {
                foreach ($res->result_array() as $permiso) {
                    $acl[$permiso['controlador']][$permiso['accion']] = explode(',', $permiso['roles']);
                }
            }
        }

        $this->CI->session->set_userdata('acl', serialize($acl));
        return $acl;

    }

    public function guardar($acl = array()) {

        if (count($acl)) {
            if ($this->CI->db->truncate('ta_users_permits')) {
                $query = "INSERT INTO ta_users_permits (controlador, accion, roles) VALUES ";
                foreach ($acl as $controller => $acciones) {
                    foreach ($acciones as $accion => $roles) {
                        $query.="('" . $controller . "','" . $accion . "','" . implode(',', $roles) . "'),";
                    }
                }
                $query = substr($query, 0, -1);
                if ($this->CI->db->query($query)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

}

?>
