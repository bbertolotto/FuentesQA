<?php
//extendemos CI_Model
class Parameters_model extends CI_Model
{

public function __construct()
{
    parent::__construct();
    $this->load->database(); /*Load catalogo base datos*/
}

/**
 * Begin:: CC033
 **/
public function get_secureByRol($userROL, $codProduct)
    {
        $this->db->join('ta_secure_parameters', 'ta_secure_parameters.codSecure = ta_secure_product.codSecure');
        $this->db->where('ta_secure_product.id_rol', $userROL);
        $this->db->where('ta_secure_product.codProduct', $codProduct);
        $this->db->where('ta_secure_parameters.flgVigencia', 'S');
        $query = $this->db->get('ta_secure_product');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

public function get_secureById($codSecure)
{
    $this->db->where('codSecure', $codSecure);
    $this->db->where('flgVigencia', 'S');
    $query = $this->db->get('ta_secure_parameters');
    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return false;
    }
}

/**
 * End:: CC033
 **/

/** Begin::CC028:: **/ 
public function get_card_lock_descriptions($id){

      $this->db->where('id_status', $id);
      $query = $this->db->get('ta_card_lock_descriptions');
      if ($query->num_rows() > 0) {
          return $query->row();
      } else {
          return false;
      }
}
public function get_parameters_log_transfer($data){

    $this->db->select("count(*) as count_transfer");
    $this->db->where("username", $data["username"]);
    $this->db->where("rut_client", $data["rut_client"]);
    $this->db->where("date_request", $data["date_request"]);
    $query = $this->db->get('ta_journal_log_transfer');
    return $query->row();
}
public function put_parameters_log_transfer($data){

    $data_transfer = array(
        "username" => $data["username"],
        "request" => $data["request"],
        "date_request" => date("Ymd"),
        "rut_client" => $data["rut_client"],
    );
    $this->db->insert('ta_journal_log_transfer', $data_transfer);
}
public function get_parameters_eval_product($data){

      $this->db->where('id_status', $data["id_status"]);
      $this->db->where('id_product', $data["id_product"]);
      $this->db->where('id_type', $data["id_type"]);
      $this->db->where('id_channel', $data["id_channel"]);
      $query = $this->db->get('ta_parameters_eval_products');
      if ($query->num_rows() > 0) {
          return $query->row();
      } else {
          return false;
      }
}
/** End::CC028:: **/ 


/***
 * Begin::CC0023 
 * Comprobante entrega tarjetas
 */

public function get_productById($id){

      $this->db->where('id_product', $id);
      $query = $this->db->get('ta_journal_products');
      if ($query->num_rows() > 0) {
          return $query->row();
      } else {
          return false;
      }
}

/***
 * End::CC0023 
 * Comprobante entrega tarjetas
 */

public function get_motivo_bloqueo($id){

  $this->db->where('KEY', $id);
  $query = $this->db->get('vi__motivo_bloqueos');
  if ($query->num_rows() > 0) {
      return $query->row();
  } else {
      return false;
  }
}

public function get_blocking($id, $product){

  $this->db->where('LOCK_CODE', $id);
  $this->db->where('CODE_PRODUCT', $product);
  $query = $this->db->get('vi__blocking');
  if ($query->num_rows() > 0) {
      return $query->row();
  } else {
      return false;
  }
}

    public function getall_activity()
    {

        $query = $this->db->get('vi__activity');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

public function get_generalParameters()
{
    $this->db->reconnect();
    $query = $this->db->get('ta_general_parameters');
    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return false;
    }
}


    public function get_activity($id)
    {
        $this->db->where('KEY', $id);
        $query = $this->db->get('vi__activity');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getall_requestStatus()
    {

        $query = $this->db->get('vi__requestStatus');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function count_renegotiationByRut($request)
    {

        $nroRut = str_replace('.', '', $request["nroRut"]);
        $nroRut = str_replace('-', '', $nroRut);
        $nroRut = substr($nroRut, 0, -1);

        $this->db->select("count(*) as count_renegotiation");
        $this->db->where("number_rut_client", $nroRut);
        $this->db->where("status_approval", $request["status_approval"]);
        $query = $this->db->get('ta_journal_renegotiation');

        return $query->row();
    }

    public function getall_renegotiationStatus()
    {

        $query = $this->db->get('vi__REN_estado');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function get_renegotiationStatusById($id)
    {
        $this->db->where("ID", $id);
        $query = $this->db->get('vi__REN_estado');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function get_renegotiationSituationById($id)
    {
        $this->db->where("ID", $id);
        $query = $this->db->get('vi__REN_situacion');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function getall_renegotiationDiasMora()
    {

        $query = $this->db->get('vi__REN_diasmora');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function getall_renegotiationMontoMora()
    {

        $query = $this->db->get('vi__REN_montomora');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function getall_renegotiationMontoCuota()
    {

        $query = $this->db->get('vi__REN_montocuota');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function getall_renegotiationOpers()
    {

        $query = $this->db->get('vi__REN_numeronegocios');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function getall_office()
    {

        $query = $this->db->get('ta_office');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->result();
        }
    }

    public function get_officeById($id_office)
    {
        $this->db->where("id_office", $id_office);
        $query = $this->db->get('ta_office');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function get_rolById($rol)
    {
        $this->db->where("id_rol", $rol);
        $query = $this->db->get('ta_users_roles');

        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function get_requestStatus($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('vi__requestStatus');
        if ($query->num_rows() == 0) {
            return false;
        } else {
            return $query->row();
        }
    }

    public function get_quotasByProduct($codProduct)
    {
        $this->db->where('name', $codProduct);
        $query = $this->db->get('vi__cuotaProductos');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_deferredByProduct($codProduct)
    {
        $this->db->where('name', $codProduct);
        $query = $this->db->get('vi__cuotaDiferirProductos');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_channelById($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('ta_users_channel');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getall_channel()
    {

        $query = $this->db->query('SELECT DISTINCT channel FROM ta_users_channel');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getall_boss()
    {

        $query = $this->db->query('SELECT id_user, username FROM ta_users WHERE id_boss = 1');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_quotasDeferredByProduct($codProduct)
    {
        $this->db->where('name', $codProduct);
        $query = $this->db->get('vi__cuotaDiferirProductos');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_amountByProduct($codProduct)
    {
        $this->db->where('name', $codProduct);
        $query = $this->db->get('vi__tipoProductos');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

public function get_task()
{
    $this->db->select('a.*, b.name as name_office, u.username as username ');
    $this->db->select('a.* ');
    $this->db->from('ta_tasks a');
    $this->db->join('ta_office b', 'a.id_office=b.id_office', 'left');
    $this->db->join("ta_users u", "a.id_user=u.id_user", "left");
    $this->db->order_by('a.correl', 'asc');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return false;
    }
}

} //End Class
