<?php


function get_REN_cuotas(){

    $CI = get_instance();
    $CI->load->model("Glossary_model", "glossary");

    $datos = $CI->glossary->get_REN_cuotas();
    return $datos;
}

function get_REN_cuotasdiferidas(){

    $CI = get_instance();
    $CI->load->model("Glossary_model", "glossary");

    $datos = $CI->glossary->get_REN_cuotasdiferidas();
    return $datos;
}

function usuariobuscar($id)
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model("Usuario_model","user");

    // Call a function of the model
    $datos = $CI->user->sp_user($id);
    return $datos->name ." ".$datos->last_name;
}


function motivosrechazo()
{

    $CI = get_instance();
    $CI->load->model("Motivosrechazo_model","rechazo");
    $datos = $CI->rechazo->getall();
    return $datos;
}

function listBeneficiaries()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->glossary->listBeneficiaries();
    return $datos;
}

function listOffices()
{
    $CI = get_instance();
    $CI->load->model("Parameters_model","parameters");
    $datos = $CI->parameters->getall_office();

    return $datos;
}

function listBancos()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->glossary->getall_Bancos();

    return $datos;
}

function listTipoCuentas()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->glossary->getall_tipoCuentas();

    return $datos;
}


function listRechazaLiquida()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->glossary->getall_rechazaLiquida();

    return $datos;
}

function listRechazaAutoriza()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->glossary->getall_rechazaAutoriza();

    return $datos;
}

function listRolesDeUsuarios()
{
    $CI = get_instance();
    $CI->load->model("Usuario_model","users");
    $datos = $CI->users->get_allRoles();

    return $datos;
}

function listPaisesTecnocom()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->users->getall_paisesTecnocom();

    return $datos;
}

function listComunasTecnocom()
{
    $CI = get_instance();
    $CI->load->model("Glossary_model","glossary");
    $datos = $CI->users->getall_comunasTecnocom();

    return $datos;
}


function searchdocument($id)
{
        $ci =& get_instance();
        $ci->load->database();
        $table  = 'ta_documents_images';

        $row = $ci->db->select("*")
              ->from($table)
              ->where("idDocument", $id)
              ->get()
              ->row();

        return $row;
}
