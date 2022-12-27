<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends CI_Controller
{

/**
 * Index Page for this controller.
 *
 * Maps to the following URL
 *         http://example.com/index.php/welcome
 *    - or -
 *         http://example.com/index.php/welcome/index
 *    - or -
 * Since this controller is set as the default controller in
 * config/routes.php, it's displayed at http://example.com/
 *
 * So any other public methods not prefixed with an underscore will
 * map to /index.php/welcome/<method_name>
 * @see https://codeigniter.com/user_guide/general/urls.html
 */

public function __construct()
{
    parent::__construct();

    $this->load->model("Usuario_model", "user");

    $this->load->library("session");
    $this->load->library('form_validation');
    $this->load->model("News_model", "news");
    $this->load->model("Task_model", "task");
    $this->load->model("Journal_model", "journal");

    $this->load->library(array('Rut', 'Soap', 'form_validation'));
    $this->load->helper(array('funciones_helper', 'teknodatasystems_helper', 'ws_solventa_helper'));

    $site_lang = $this->session->userdata('site_lang');
    if($site_lang){$this->lang->load('header',$this->session->userdata('site_lang'));}
    else{$this->lang->load('header','spanish');}

    date_default_timezone_set('America/Santiago');
}
public function index()
{
    $datos['selectnews'] = $this->news->sp_select_task_new();
    $this->load->view('task/index', $datos);

}

public function savetask()
{
    $value = $_POST["value"];
    $id = $this->session->userdata('id');
    $this->news->sp_task($id, $value);
    echo json_encode(array('mensaje' => "Almacenado"));
}

public function renegotiation()
{

		if( $this->input->is_ajax_request() ) {
				$data["retorno"] = COD_ERROR_INIT;
				$data["descRetorno"] = "Error, Esta tarea solo esta disponible en modalidad batch..!";
				echo json_encode($data);
				exit(0);
		}

    $currentUser = $this->session->userdata('current_user');

    $stamp_begin = date("Y-m-d H:i:s");
		$this->load->database();
    $count_renegotiation = 0;

    if($currentUser['nombre']==USERNAME_MAXBOT)
              print_r("Start automatic renegotiation process -> ". date("d-m-Y H:i:s")."</br>");

    $getJournal = $this->journal->getRenegotiationAcceptByDay();

    if(!$getJournal){
          $data = [
              "type_environment" => "cron",
              "stamp_begin" => $stamp_begin,
              "detail_issues" => "No hay Renegociaciones pendientes de Procesar..",
              "detail" => "Sin pendientes por Procesar",
              "type_status" => "TERMINADO",
              "status" => 2
          ];
          $this->journal->ins_Task($data);

          if($currentUser['nombre']==USERNAME_MAXBOT)
          print_r("Finish automatic renegotiation process -> ". date("d-m-Y H:i:s")."</br>");

  				echo json_encode($data);
  				exit(0);
    }

    if($currentUser['nombre']==USERNAME_MAXBOT)
          print_r("registros a procesar ". $getJournal->num_rows."</br>");

    foreach ($getJournal->result() as $row){

          $nroRut = $row->number_rut_client . "-" . $row->digit_rut_client;
          $status_payment1 = $row->status_payment1; $status_payment2 = $row->status_payment2;
          $status_payment3 = $row->status_payment3; $status_payment4 = $row->status_payment4;
          $status_payment5 = $row->status_payment5; $status_payment6 = $row->status_payment6;
          $status_payment7 = $row->status_payment7;

          $continue = true;
          $dataHomologador = ws_GET_HomologadorByRut($nroRut, USERNAME_MAXBOT);
          if ($dataHomologador["retorno"] != 0) {

              if($currentUser['nombre']==USERNAME_MAXBOT)
                    print_r("Error Homologador ".$dataHomologador["descRetorno"]."</br>");

              $data = [
                  "status_name" => "PROCESADA",
                  "date_authorizes" => date("Y-m-d H:i:s"),
                  "detail" => "Error, Homologador: ".$dataHomologador["descRetorno"]
              ];
              $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
              $continue = false;
          }

          if($continue){

              if($dataHomologador["flg_flujo"]!="001"){

                  $data = [
                      "date_authorizes" => date("Y-m-d H:i:s"),
                      "detail" => "Warning, Cliente VISSAT sera procesada en trabajo nocturno!"
                  ];
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                  $continue = false;
              }
          }

          if($currentUser['nombre']==USERNAME_MAXBOT){

            if($continue){
                print_r("Inicio Proceso Renegociación N° ".$row->autorizador."</br>");
            }else{
                print_r("Renegociación cancelada N° ".$row->autorizador."</br>");
            }

          }

          if($continue){

              $dataInput = array(
                  "idRefinanciamiento" => $row->autorizador,
                  "username" => USERNAME_MAXBOT,
                  "flg_flujo" => $dataHomologador["flg_flujo"],
                  "tipoRef" => "RM",
              );

              $dataRene = ws_GET_ConsultaDetalleRene($dataInput);
              if ($dataRene["retorno"] != 0) {

                  $data = [
                      "status_name" => "PROCESADA",
                      "date_authorizes" => date("Y-m-d H:i:s"),
                      "detail" => "Error, DetalleRene: ".$dataRene["descRetorno"]
                  ];
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                  $continue = false;

                  if($currentUser['nombre']==USERNAME_MAXBOT)
                  print_r("Renegociación cancelada -> Error Consulta Detalle Rene N° -> ". $dataRene["descRetorno"]."</br>");

              }

          }

          if($continue){

              if($status_payment1==0){

                $dataInput = array(
                    'nroRut' => $row->number_rut_client.$row->digit_rut_client,
                    'nroTcv' => $dataHomologador["nroTcv"],
                    'contrato' => $dataRene["idContrato"],
                    'flg_flujo' => $dataHomologador["flg_flujo"],
                    'username' => USERNAME_MAXBOT,
                );

                $dataDeuda = ws_GET_ConsultaDeudaClienteTC($dataInput);
                if($dataDeuda["retorno"] != 0) {

                    $data = [
                        "status_name" => "PROCESADA",
                        "date_authorizes" => date("Y-m-d H:i:s"),
                        "detail" => "Error Deuda Cliente: ".$dataDeuda["descRetorno"]
                    ];
                    $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                    $continue = false;

                    if($currentUser['nombre']==USERNAME_MAXBOT)
                    print_r("Renegociación cancelada -> Error Consulta Deuda Cliente ". $dataDeuda["descRetorno"]."</br>");

                }else{

                    $deudaActual = (float) $dataDeuda["deudaActual"];
                }

                if($continue){

                  if($deudaActual>=$dataRene["deudaRef"]){

                      $dataInput = array(
                          "rut" => $dataRene["rut"],
                          "contrato" => $dataRene["idContrato"],
                          "deudaRef" => $dataRene["deudaRef"],
                          "username" => USERNAME_MAXBOT,
                      );
                      $eval = ws_PUT_PagoOnlineRenegotiation($dataInput);
                      if($eval["retorno"]==0){

                          $data = array(
                              "status_payment1" => 1,
                              "detail" => "Pago Online OK",
                              "response_payment1" => $eval["descRetorno"]
                          );
                          $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                          $status_payment1 = 1;

                          if($currentUser['nombre']==USERNAME_MAXBOT)
                          print_r("Acepta Pago Online ". $eval["descRetorno"]."</br>");

                      }else{

                          $data = [
                              "status_name" => "PROCESADA",
                              "date_authorizes" => date("Y-m-d H:i:s"),
                              "detail" => "Error Pago Online",
                              "response_payment1" => $eval["descRetorno"]
                          ];
                          $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                          $continue = false;

                          if($currentUser['nombre']==USERNAME_MAXBOT)
                          print_r("Renegociación cancelada -> Error Pago Online ". $eval["descRetorno"]."</br>");

                      }

                  }else{

                      $data = [
                          "status_name" => "PROCESADA",
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "detail" => "Deuda Actual es menor que Deuda a Refinanciar",
                      ];
                      $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                      $continue = false;

                      if($currentUser['nombre']==USERNAME_MAXBOT)
                      print_r("Renegociación cancelada -> Deuda actual es menor que deuda a REFINANCIAR</br>");

                  }

                }

              }
          }

          if($continue){

            if ($status_payment1 == 1 AND $status_payment2==0) {

                $dataInput = array(
                    "rut" => $dataRene["rut"],
                    "contrato" => $dataRene["idContrato"],
                    "monto" => $dataRene["deudaRef"],
                    "nroCuotas" => $dataRene["nroCuotas"],
                    "mesesDiferidos" => $dataRene["mesesDiferidos"],
                    "username" => USERNAME_MAXBOT,
                    "producto" => $dataDeuda["producto"],
                    "subproducto" => $dataDeuda["subproducto"]
                );
                $eval = ws_PUT_AltaRenegotiation($dataInput);
                if($eval["retorno"] != 0) {

                    if($currentUser['nombre']==USERNAME_MAXBOT)
                    print_r("Cancela Proceso -> Error Alta Rene ". $eval["descRetorno"]."</br>");

                    $data = [
                        "date_authorizes" => date("Y-m-d H:i:s"),
                        "response_payment2" => $eval["descRetorno"]
                    ];
                    $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);

                    $dataInput = array(
                        "rut" => $dataRene["rut"],
                        "contrato" => $dataRene["idContrato"],
                        "fechaFacturacion" => date("d-m-Y"),
                        "tipoFacturacion" => 615,
                        "username" => USERNAME_MAXBOT
                    );
                    $eval = ws_PUT_ReversaPagoRenegociacion($dataInput);
                    if($eval["retorno"]==0) {

                        if($currentUser['nombre']==USERNAME_MAXBOT)
                        print_r("Pago y Reversa Aceptada". $eval["descRetorno"]."</br>");
                        $data = [
                            "status_payment1" => 0,
                            "status_name" => "PROCESADA",
                            "date_authorizes" => date("Y-m-d H:i:s"),
                            "detail" => "Pago reversado X Error Alta Renegociacion",
                            "response_payment1" => $eval["descRetorno"]
                        ];

                    }else{

                        if($currentUser['nombre']==USERNAME_MAXBOT)
                        print_r("Error Reversa Rene ". $eval["descRetorno"]."</br>");

                        $data = [
                            "status_payment1" => 1,
                            "status_name" => "PROCESADA",
                            "date_authorizes" => date("Y-m-d H:i:s"),
                            "detail" => "Pago no fue reversado",
                            "response_payment1" => $eval["descRetorno"]
                        ];
                    }
                    $continue = false;

                }else{

                    $data = array(
                        "status_payment2" => 1,
                        "detail" => "Alta Renegotiation OK",
                        "response_payment2" => $eval["descRetorno"],
                    );
                    $status_payment2 = 1;
                }
                $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);

              }

          }

          if($continue){

              if($status_payment3==0){

                  $dataInput = array(
                      'contrato' => $dataRene["idContrato"],
                      'codigo_bloqueo' => 17,
                      'fecha_estado' => date("d-m-Y H:i:s"),
                      'rut' => $dataRene["rut"],
                      'indicador_bloqueo' => "B",
                      'pan' => "",
                      'texto_bloqueo' => "",
                      'flag_flujo' => $dataHomologador["flg_flujo"],
                      'username' => USERNAME_MAXBOT
                  );

                  $eval = ws_PUT_GrabaEstadosCuenta($dataInput);
                  if ($eval["retorno"] != 0) {

                      $data = [
                          "status_name" => "OBSERVADA",
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "detail" => "Error Graba Desbloqueo Cuenta",
                          "response_payment3" => $eval["descRetorno"]
                      ];

                      if(substr($eval["descRetorno"],0,7)=="MPA0301"){

                          $dataInput["indicador_bloqueo"] = "D";
                          $eval = ws_PUT_GrabaEstadosCuenta($dataInput);
                          if($eval["retorno"]==0) {

                            $dataInput["indicador_bloqueo"] = "B";
                            $eval = ws_PUT_GrabaEstadosCuenta($dataInput);
                            if($eval["retorno"]==0) {

                              $data = array(
                                  "status_payment3" => 1,
                                  "date_authorizes" => date("Y-m-d H:i:s"),
                                  "response_payment3" => $eval["descRetorno"]
                              );
                              $status_payment3 = 1;

                            }

                          }

                      }


                  }else {

                      $data = array(
                          "status_payment3" => 1,
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "response_payment3" => $eval["descRetorno"]
                      );
                      $status_payment3 = 1;
                  }
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);

              }
          }

          if($continue){

              if($status_payment4==0){

                  if ((float) $dataRene["deudaRef"] >= MONTO_DEUDA_RENEGOCIACION) {
                      $cupoCompra = 100000;
                      $cupoAvance = 0;
                  } else {
                      $cupoCompra = 50000;
                      $cupoAvance = 0;
                  }

                  $tipolin = "LREV";
                  if(($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0001") OR
                     ($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0002")){
                        $tipolin = "LNCC";}
                  if($dataDeuda["producto"]=="01" and $dataDeuda["subproducto"]=="0004"){
                        $tipolin = "LREV";}
                  if($dataDeuda["producto"]=="02" and $dataDeuda["subproducto"]=="0001"){
                        $tipolin = "LREV";}

                  $eval = digitoRUTCL($dataRene["rut"]);
                  $dataInput = array(
                      "contrato" => $dataRene["idContrato"],
                      "idClient" => $dataRene["rut"],
                      "cupo" => $cupoCompra,
                      "username" => USERNAME_MAXBOT,
                      "tipolin" => $tipolin,
                      "flg_flujo" => $dataHomologador["flg_flujo"],
                  );
                  $eval = ws_PUT_AltaCuposRenegotiation($dataInput);
                  if ($eval["retorno"] != 0) {

                      if($currentUser['nombre']==USERNAME_MAXBOT)
                      print_r("Continua Proceso -> Warning Alta Cupo Compra ". $eval["descRetorno"]."</br>");

                      $data = [
                          "status_name" => "OBSERVADA",
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "detail" => "Error Alta Cupos Compra ",
                          "response_payment4" => $eval["descRetorno"]
                      ];

                  }else{

                      $data = array(
                          "status_payment4" => 1,
                          "response_payment4" => $eval["descRetorno"]
                      );
                      $status_payment4 = 1;
                  }
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);

              }
          }

          if($continue){

              if($status_payment5==0){

                  if ((float) $dataRene["deudaRef"] >= MONTO_DEUDA_RENEGOCIACION) {
                      $cupoCompra = 100000;
                      $cupoAvance = 0;
                  } else {
                      $cupoCompra = 50000;
                      $cupoAvance = 0;
                  }

                  $tipolin = "LNAV";
                  if($dataDeuda["producto"]=="02" and $dataDeuda["subproducto"]=="0001"){
                        $tipolin = "LNAM";}

                  $eval = digitoRUTCL($dataRene["rut"]);
                  $dataInput = array(
                      "contrato" => $dataRene["idContrato"],
                      "idClient" => $dataRene["rut"],
                      "cupo" => $cupoAvance,
                      "username" => USERNAME_MAXBOT,
                      "tipolin" => $tipolin,
                      "flg_flujo" => $dataHomologador["flg_flujo"],
                  );
                  $eval = ws_PUT_AltaCuposRenegotiation($dataInput);
                  if ($eval["retorno"] != 0) {

                      if($currentUser['nombre']==USERNAME_MAXBOT)
                      print_r("Continua Proceso -> Warning Alta Cupo Avance ". $eval["descRetorno"]."</br>");

                      $data = [
                          "status_name" => "OBSERVADA",
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "detail" => "Error Alta Cupos Avance",
                          "response_payment5" => $eval["descRetorno"]
                      ];

                  }else{

                      $data = array(
                          "status_payment5" => 1,
                          "response_payment5" => $eval["descRetorno"]
                      );
                      $status_payment5 = 1;
                  }
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);

              }
          }

          if($status_payment1==1 AND $status_payment2==1 AND $status_payment3==1 AND $status_payment4==1 AND $status_payment5==1){

              if($status_payment6==0){

                  $status_exception = "";
                  if($dataRene["estadoExcepcion"]=="CVN") $status_exception = "AVNS";
                  if($dataRene["estadoExcepcion"]=="AVE") $status_exception = "AVES";
                  if($dataRene["estadoExcepcion"]=="CTN") $status_exception = "ATNS";
                  if($dataRene["estadoExcepcion"]=="ATE") $status_exception = "ATES";
                  if($status_exception=="") $status_exception = $dataRene["estadoExcepcion"];

                  $dataInput = array(
                      "nroRut" => $dataRene["rut"]."-".$dataRene["dv"],
                      "username" => USERNAME_MAXBOT,
                  );
                  $eval = ws_GET_CountRenegotiation($dataInput);
                  if ($eval["retorno"] == 0) {
                      $nroReneg = $eval["nroReneg"];
                      $status_payment7 = 0;
                  } else {
                      $nroReneg = 0;
                      $status_payment7 = 1;
                  }

                  $dataInput = array(
                      "flg_flujo" => $dataHomologador["flg_flujo"],
                      "idUnicoDeTrx" => $dataRene["idRefinanciamiento"],
                      "username" => USERNAME_MAXBOT,
                      "username_visa" => "",
                      "status_visa" => "A",
                      "date_stamp_visa" => date("d-m-Y"),
                      "username_accept" => USERNAME_MAXBOT,
                      "date_stamp_accept" => date("d-m-Y"),
                      "username_liquidation" => USERNAME_MAXBOT,
                      "date_stamp_liquidation" => date("d-m-Y"),
                      "username_exception" => "",
                      "date_stamp_exception" => "",
                      "status_exception" => $status_exception,
                      "codDeny" => "",
                      "aprobadoConRevision" => $row->status_check,
                  );
                  $eval = ws_PUT_ActualizaEstadoRenegotiation($dataInput);
                  if($eval["retorno"]==0){

                      $data = [
                          "status_payment6" => 1,
                          "status_payment7" => $status_payment7,
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "response_payment6" => "Renegociación Aceptada con estado excepcion -> ".$status_exception,
                      ];
                      $status_payment6 = 1;

                  }else{

                      $data = [
                          "date_authorizes" => date("Y-m-d H:i:s"),
                          "response_payment6" => $eval["descRetorno"],
                      ];
                  }
                  $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
              }

              if($status_payment6==1){

                  if($status_payment7==0){

                      if($nroReneg>0){

                          $dataInput = array(
                              "nroRut" => $dataRene["rut"]."-".$dataRene["dv"],
                              "username" => USERNAME_MAXBOT,
                          );

                          $eval = ws_PUT_ActualizaRenesANoVigentes($dataInput);
                          if ($eval["retorno"]==0){

                              $data = array(
                                  "status_payment7" => 1,
                                  "response_payment7" => $eval["descRetorno"]
                              );
                              $status_payment7 = 1;

                          }else{

                              if($currentUser['nombre']==USERNAME_MAXBOT)
                              print_r("Continua Proceso -> Warning Actualiza Renes No Vigentes ". $eval["descRetorno"]."</br>");

                              $data = [
                                  "status_name" => "OBSERVADA",
                                  "date_authorizes" => date("Y-m-d H:i:s"),
                                  "detail" => "Error Actualiza Rene No Vigentes -> Registra ".$nroReneg." vigente",
                                  "response_payment7" => $eval["descRetorno"]
                              ];
                          }

                      }else{

                          $data = array(
                              "status_payment7" => 1,
                              "response_payment7" => "No registra Renegociaciones anteriores.."
                          );
                          $status_payment7 = 1;
                      }
                      $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
                  }
              }
          }

          if($status_payment6==1 and $status_payment7==1){

              $data = [
                  "status" => 4,
                  "status_name" => "PROCESADA",
                  "date_authorizes" => date("Y-m-d H:i:s"),
                  "detail" => "Renegociacion procesada OK"
              ];
              $eval = $this->journal->upd_RenegotiationById($row->autorizador, $data);
          }

          if($currentUser['nombre']==USERNAME_MAXBOT)
          print_r("Termino proceso Rene: ".$row->autorizador."</br>");

          $count_renegotiation = $count_renegotiation + 1;
      }

      $data = [
          "type_environment" => "cron",
          "stamp_begin" => $stamp_begin,
          "detail_issues" => "Tarea automatica de servidor crontab",
          "detail" => $count_renegotiation." RENEGOCIACIONES PROCESADAS..",
          "type_status" => "TERMINADO",
          "status" => 1
      ];
      $this->journal->ins_Task($data);

      if($currentUser['nombre']==USERNAME_MAXBOT)
      print_r("Finish automatic renegotiation process -> ". date("d-m-Y H:i:s")."</br>");

}

}
