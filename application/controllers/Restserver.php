<?php

require APPPATH.'/libraries/REST_Controller.php';

class Restserver extends REST_Controller
{




    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function consulta_requerimiento_embozado_post()
    {

        $rut = (string)$this->post('rut');


    $time_start = microtime_float();
    $date_start = date("Y-m-d H:i:s");

    $this->db->select('a.autorizador, a.origen, a.rutvend');
    $this->db->from('ta_journal_capturing a');
    $this->db->where('(a.rut = "' . $rut . '")');
    $this->db->order_by('a.autorizador', 'desc');
    $this->db->limit(1);
    $query = $this->db->get();


        if($query->num_rows()==0){

            $response = array(

                "response" => array(

                    "cabecera_salida" => array(

                            "retorno" => 100,
                            "descRetorno" => "No hay solicitudes de embozado pendientes..",

                        ),
                    "data_response" => array(

                            "nro_requerimiento" => "",
                            "rut" => $rut,
                            "rutvend" => "",
                        )

                    )

                );

            $result = "ERROR";

        }else{


            foreach ($query->result() as $row) {


                $response = array(

                    "response" => array(

                        "cabecera_salida" => array(

                                "retorno" => 0,
                                "descRetorno" => "Transaccion Aceptada",

                            ),
                        "data_response" => array(

                                "nro_requerimiento" => $row->autorizador,
                                "rut" => $rut,
                                "rutvend" => substr($row->rutvend,0,8),
                            )

                        )

                    );

            }

            $result = "OK";

        }

        $time_end = microtime_float();
        $time = $time_end - $time_start;
        $date_end = date("Y-m-d H:i:s");

        $data = array(

            "date_begin" => $date_start,
            "time" => $time,
            "date_end" => $date_end,
            "username" => "API REST",
            "endPoint" => "https://api.certi.maximoerp.com/consultarequerimientoembozado",
            "action" =>  json_encode($this->input->request_headers()),
            "request" => '{ "rut" : ' . $this->post("rut") . '}',
            "response" => json_encode($response),
            "result" => $result
        );

        if($this->db->insert('ta_journal_log_event', $data))
        {
            $insert_id = $this->db->insert_id();
        }else{
            $insert_id = 0;
        }

        $this->response($response);
    }
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
