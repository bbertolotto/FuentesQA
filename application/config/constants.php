<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('MESSAGE_EXIT_INVALID_CREDENTIAL') OR define('MESSAGE_EXIT_INVALID_CREDENTIAL', 'Error de Seguridad, credencial no es valida..!');

/** Begin::CC028:: **/ 
defined('TYPE__PRODUCT_SAV') OR define('TYPE__PRODUCT_SAV', 'SAV');
defined('TYPE__PRODUCT_REN') OR define('TYPE__PRODUCT_REN', 'REN');
defined('TYPE__PRODUCT_REF') OR define('TYPE__PRODUCT_REF', 'REF');

defined('NAME__PRODUCT_SAV') OR define('NAME__PRODUCT_SAV', 'SUPER AVANCE');
defined('NAME__PRODUCT_REN') OR define('NAME__PRODUCT_REN', 'RENEGOCIACION');
defined('NAME__PRODUCT_REF') OR define('NAME__PRODUCT_REF', 'REFINANCIAMIENTO');
/** End::CC028:: **/ 

/***
 * Begin CC0017
 ***/ 
defined('WS_ConsultaDeudaFacturacion') OR define('WS_ConsultaDeudaFacturacion', '/ClSlvFabric_ConsultaDeudaFacturacion');
defined('WS_Action_ConsultaDeudaFacturacion') OR define('WS_Action_ConsultaDeudaFacturacion', 'urn:execute');
defined('WS_ConsultaProductoClientePorRut') OR define('WS_ConsultaProductoClientePorRut', '/WSIVRHOMOLOG');
defined('WS_Action_ConsultaProductoClientePorRut') OR define('WS_Action_ConsultaProductoClientePorRut', 'urn:execute_bindQSService');

defined('PRODUCT_BRAND_SPIN') OR define('PRODUCT_BRAND_SPIN', 'VISA'); 
defined('PRODUCT_BRAND_PRIV') OR define('PRODUCT_BRAND_PRIV', 'PRIVADA'); 
defined('PRODUCT_BRAND_UNDEFINED') OR define('PRODUCT_BRAND_UNDEFINED', 'NO DEFINIDO'); 

defined('EXIT_TRANSACTION_DECLINED') OR define('EXIT_TRANSACTION_DECLINED', 'TRANSACCION RECHAZADA'); 
defined('EXIT_TRANSACTION_ACCEPTED') OR define('EXIT_TRANSACTION_ACCEPTED', 'TRANSACCION ACEPTADA'); 
defined('EXIT_TRANSACTION_ERROR') OR define('EXIT_TRANSACTION_ERROR', 'TRANSACCION CON ERROR'); 

/***
 * End CC0017
 ***/ 


/***********************************************/
/* Destino WS Ambiente Certificación Solventa  */
/***********************************************/
defined('WS_Ip') OR define('WS_Ip', '10.193.122.115');
defined('WS_Ip_Port') OR define('WS_Ip_Port', '14007');
defined('WS_http') OR define('WS_http', 'http://');
defined('WS_https') OR define('WS_https', 'https://');
/****/

/******************************/
/* Definiciones Mesa de Ayuda */
/******************************/
defined('ATENTION_HELPDESK') OR define('ATENTION_HELPDESK', 'Comuniquese con mesa de ayuda t&#233;cnica / email: soportetisolventa@solventa.cl');

defined('WS_CreacionSeguros') OR define('WS_CreacionSeguros', '/ClSlvCreacion_seguros');
defined('WS_Action_CreacionSeguros') OR define('WS_Action_CreacionSeguros', 'urn:CreacionSeguros');

/******************************************/
/* Definiciones Producto  Captaciones     */
/******************************************/
defined('SOURCE_PRODUCT_CHANGE_NAME') OR define('SOURCE_PRODUCT_CHANGE_NAME', "CAMBIOPRODUCTO");
defined('SOURCE_PRODUCT_CHANGE_TYPE') OR define('SOURCE_PRODUCT_CHANGE_TYPE', "CP");
defined('SOURCE_CAPTURING_NAME') OR define('SOURCE_CAPTURING_NAME', "CAPTACION");
defined('SOURCE_CAPTURING_TYPE') OR define('SOURCE_CAPTURING_TYPE', "CT");

defined('TIPO_ALTA_SEGURO_DESG') OR define('TIPO_ALTA_SEGURO_DESG', '1');
defined('TIPO_BAJA_Y_ALTA__SEGURO_DESG') OR define('TIPO_BAJA_Y_ALTA__SEGURO_DESG', '2');
defined('TIPO_BAJA_SEGURO_DESG') OR define('TIPO_BAJA_SEGURO_DESG', '3');
defined('CODIGO_BLOQUEO_TARJETA_INACTIVA') OR define('CODIGO_BLOQUEO_TARJETA_INACTIVA', '20');
defined('CODIGO_BLOQUEO_TARJETA_ROBADA') OR define('CODIGO_BLOQUEO_TARJETA_ROBADA', '13');

/******************************************/
/* Definiciones Producto  Renegociaciones */
/******************************************/
defined('SCRIPT_CONFIRMADO') OR define('SCRIPT_CONFIRMADO', 1);
defined('USERNAME_MAXBOT') OR define('USERNAME_MAXBOT', "MAXBOT");
defined('USERNAME_TASK_BOT') OR define('USERNAME_TASK_BOT', "MAXBOT");
defined('ID_USER_MAXBOT') OR define('ID_USER_MAXBOT', "55");
defined('ID_OFFICE_MAXBOT') OR define('ID_OFFICE_MAXBOT', "01000");
defined('TASK_RED') OR define('TASK_RED', "RED");
defined('TASK_URG') OR define('TASK_URG', "URG");
defined('USER_ROL_JEFE_COBRANZA') OR define('USER_ROL_JEFE_COBRANZA', 12);
defined('USER_ROL_SUPERVISOR_CALIDAD') OR define('USER_ROL_SUPERVISOR_CALIDAD', 13);
defined('USER_ROL_SUPERVISOR_EXCEPCIONES') OR define('USER_ROL_SUPERVISOR_EXCEPCIONES', 14);
defined('USER_ROL_EJECUTIVO_COBRANZA') OR define('USER_ROL_EJECUTIVO_COBRANZA', 15);


defined('COD_TRX_VENTA') OR define('COD_TRX_VENTA', "001");
defined('COD_TRX_AVANCE') OR define('COD_TRX_AVANCE', "009");
defined('COD_TRX_PAGO') OR define('COD_TRX_PAGO', "005");
defined('COD_TRX_CARGO') OR define('COD_TRX_CARGO', "999");
defined('COD_TRX_REN_SIN_DIFERIDO_001') OR define('COD_TRX_REN_SIN_DIFERIDO_001', "1227");
defined('COD_TRX_REN_CON_DIFERIDO_001') OR define('COD_TRX_REN_CON_DIFERIDO_001', "1228");
defined('COD_TRX_REN_SIN_DIFERIDO_002') OR define('COD_TRX_REN_SIN_DIFERIDO_002', "610");
defined('COD_TRX_REN_CON_DIFERIDO_002') OR define('COD_TRX_REN_CON_DIFERIDO_002', "611");
defined('COD_TRX_REF_SIN_DIFERIDO') OR define('COD_TRX_REF_SIN_DIFERIDO', "1275");
defined('COD_TRX_REF_CON_DIFERIDO') OR define('COD_TRX_REF_CON_DIFERIDO', "1276");
defined('COD_TRX_SIMULA_SAV') OR define('COD_TRX_SIMULA_SAV', "301");
defined('COD_TRX_SIMULA_REF') OR define('COD_TRX_SIMULA_REF', "301");
defined('MONTO_DEUDA_RENEGOCIACION') OR define('MONTO_DEUDA_RENEGOCIACION', "150000");

defined('MONTO_DEUDA_MAX_RENEGOCIACION_COMPRAS') OR define('MONTO_DEUDA_MAX_RENEGOCIACION_COMPRAS', "2000000");
defined('MONTO_DEUDA_MAX_RENEGOCIACION_REVOLVING') OR define('MONTO_DEUDA_MAX_RENEGOCIACION_REVOLVING', "11500000");
/*** Begin CC008 ***/
defined('MONTO_CUPO_ACTUALIZA_LNCC') OR define('MONTO_CUPO_ACTUALIZA_LNCC', "2000000");
/*** End CC008 ***/

/****************************/
/* Rutas WS Tarjeta Abierta */
/****************************/

defined('WS_PinpadTA') OR define('WS_PinpadTA', '/OSB/WSPinpadTA');
defined('WS_Action_PinpadTA') OR define('WS_Action_PinpadTA', 'urn:pinpadta_bindQSService');

defined('WS_ConsultaApiHSM') OR define('WS_ConsultaApiHSM', '/ClSlvFabric_ConsultaApiHSM');
defined('WS_Action_ConsultaApiHSM') OR define('WS_Action_ConsultaApiHSM', 'urn:execute');


defined('WS_ConsultaEstadoEmbozado') OR define('WS_ConsultaEstadoEmbozado', '/ClSlvFabric_ConsultaDatosEmbozadoTA');
defined('WS_Action_ConsultaEstadoEmbozado') OR define('WS_Action_ConsultaEstadoEmbozado', 'urn:execute');

defined('WS_AltaSeguroDesgravamen') OR define('WS_AltaSeguroDesgravamen', '/ClSlvConecta_AltaSeguroDesgravamenTC');
defined('WS_Action_AltaSeguroDesgravamen') OR define('WS_Action_AltaSeguroDesgravamen', 'urn:execute');

defined('WS_BajaSeguroDesgravamen') OR define('WS_BajaSeguroDesgravamen', '/ClSlvConecta_BajaDesgravamen');
defined('WS_Action_BajaSeguroDesgravamen') OR define('WS_Action_BajaSeguroDesgravamen', 'urn:execute');

/****************************/
/* Rutas WS Renegociaciones */
/****************************/
defined('WS_ActualizaRenesANoVigentes') OR define('WS_ActualizaRenesANoVigentes', '/ClSlvConecta_ActualizaRenesANoVigentes');
defined('WS_Action_ActualizaRenesANoVigentes') OR define('WS_Action_ActualizaRenesANoVigentes', 'urn:ActualizaRenesANoVigentes');
defined('WS_ConsultaPagosRene') OR define('WS_ConsultaPagosRene', '/ClSlvConecta_ConsultaControlPagosRene');
defined('WS_Action_ConsultaPagosRene') OR define('WS_Action_ConsultaPagosRene', 'urn:ConsultaControlPagosReneService');
defined('WS_ConsultaRenes30Dias') OR define('WS_ConsultaRenes30Dias', '/ClSlvConecta_ConsultaRenes30Dias');
defined('WS_Action_ConsultaRenes30Dias') OR define('WS_Action_ConsultaRenes30Dias', 'urn:ConsultaRenes30Dias');
defined('WS_ReversaPagoRenegociacion') OR define('WS_ReversaPagoRenegociacion', '/ClSlvConecta_ReversaPagoRenegociacion');
defined('WS_Action_ReversaPagoRenegociacion') OR define('WS_Action_ReversaPagoRenegociacion', 'urn:ReversaPagoRenegociacionService');
defined('WS_ParamsContract') OR define('WS_ParamsContract', '/CLSlvConecta_ConsultaParametrosContrato');
defined('WS_Action_ParamsContract') OR define('WS_Action_ParamsContract', 'urn:ConsultaParametrosContrato');
defined('WS_CountRenegotiation') OR define('WS_CountRenegotiation', '/ClSlvConecta_NroRenegVigentesTecnocom');
defined('WS_Action_CountRenegotiation') OR define('WS_Action_CountRenegotiation', 'urn:NroRenegVigentesTecnocom');
defined('WS_ConsultaMoraVirtual') OR define('WS_ConsultaMoraVirtual', '/ClSlvConecta_BuscarMoraVirtual');
defined('WS_Action_ConsultaMoraVirtual') OR define('WS_Action_ConsultaMoraVirtual', 'urn:BuscarMoraVirtual');
defined('WS_InsertarMoraVirtual') OR define('WS_InsertarMoraVirtual', '/ClSlvConecta_InsertarMoraVirtual');
defined('WS_Action_InsertarMoraVirtual') OR define('WS_Action_InsertarMoraVirtual', 'urn:InsertarMoraVirtual');
defined('WS_GrabaReneTC') OR define('WS_GrabaReneTC', '/ClSlvConecta_GrbDatosReneTC');
defined('WS_Action_GrabaReneTC') OR define('WS_Action_GrabaReneTC', 'urn:GrbDatosReneTC');
defined('WS_ListaOperxEstadoRene') OR define('WS_ListaOperxEstadoRene', '/ClSlvConecta_ListaOperacionesPorEstadoTC');
defined('WS_Action_ListaOperxEstadoRene') OR define('WS_Action_ListaOperxEstadoRene', 'urn:ListaOperacionesPorEstadoTC');
defined('WS_ConsultaDetalleRene') OR define('WS_ConsultaDetalleRene', '/ClSlvConecta_ConsultaDetalleRene');
defined('WS_Action_ConsultaDetalleRene') OR define('WS_Action_ConsultaDetalleRene', 'urn:ConsultaDetalleRene');
defined('WS_ConsultaConceptosRene') OR define('WS_ConsultaConceptosRene', '/ClSlvConecta_ConsultaConceptosRene');
defined('WS_Action_ConsultaConceptosRene') OR define('WS_Action_ConsultaConceptosRene', 'urn:ConsultaConceptosReneBindingQSService');
defined('WS_ConsultaUltimosPagosRene') OR define('WS_ConsultaUltimosPagosRene', '/ClSlvConecta_ConsultaUltimosPagosRene');
defined('WS_Action_ConsultaUltimosPagosRene') OR define('WS_Action_ConsultaUltimosPagosRene', 'urn:ConsultaUltimosPagosReneService');
defined('WS_ConsultaEstadoTransfer') OR define('WS_ConsultaEstadoTransfer', '/ClSlvConecta_EstadoTransferenciaTC');
defined('WS_Action_ConsultaEstadoTransfer') OR define('WS_Action_ConsultaEstadoTransfer', 'urn:EstadoTransferenciaTC');
defined('WS_ConsultaPreAprobadosPorRut') OR define('WS_ConsultaPreAprobadosPorRut', '/ClSlvConecta_ClientesPreAprobadosTecnocom');
defined('WS_Action_ConsultaPreAprobadosPorRut') OR define('WS_Action_ConsultaPreAprobadosPorRut', 'urn:ClientesPreAprobados');
defined('WS_Reprint_Credit_Card') OR define('WS_Reprint_Credit_Card', '/ClSlvConecta_EstampacionOnline');
defined('WS_Action_Reprint_Credit_Card') OR define('WS_Action_Reprint_Credit_Card', 'urn:EstampacionOnline');
defined('WS_Blocking_Credit_Card') OR define('WS_Blocking_Credit_Card', '/ClSlvConecta_BloqueoDesbloqueoTarjeta');
defined('WS_Action_Blocking_Credit_Card') OR define('WS_Action_Blocking_Credit_Card', 'urn:BloqueoDesbloqueoTarjeta');
defined('WS_ConsultaValorUF') OR define('WS_ConsultaValorUF', '/ClSlvConecta_ValorUFTC');
defined('WS_Action_ConsultaValorUF') OR define('WS_Action_ConsultaValorUF', 'urn:ValorUFTC');
defined('WS_PagoOnlineTecnocom') OR define('WS_PagoOnlineTecnocom', '/ClSlvConecta_PagoOnlineTecnocom');
defined('WS_Action_PagoOnlineTecnocom') OR define('WS_Action_PagoOnlineTecnocom', 'urn:PagoOnlineTecnocom');
defined('WS_AltaCompCuoTecnocom') OR define('WS_AltaCompCuoTecnocom', '/ClSlvConecta_AltaCompCuoTecnocom');
defined('WS_Action_AltaCompCuoTecnocom') OR define('WS_Action_AltaCompCuoTecnocom', 'urn:AltaCompCuoTecnocom');
defined('WS_ActualizaCuposTC') OR define('WS_ActualizaCuposTC', '/ClSlvConecta_ActualizaCuposTC');
defined('WS_Action_ActualizaCuposTC') OR define('WS_Action_ActualizaCuposTC', 'urn:ActualizaCuposTCService');
defined('WS_ActualizaEstadoRene') OR define('WS_ActualizaEstadoRene', '/ClSlvConecta_ActualizaEstadoRene');
defined('WS_Action_ActualizaEstadoRene') OR define('WS_Action_ActualizaEstadoRene', 'urn:ActualizaEstadoRene');
defined('WS_ConsultaDeudaDiaUno') OR define('WS_ConsultaDeudaDiaUno', '/ClSlvConecta_ConsultaDeudaDiaUnoMesTecno');
defined('WS_Action_WS_ConsultaDeudaDiaUno') OR define('WS_Action_WS_ConsultaDeudaDiaUno', 'urn:ConsultaDeudaDiaUnoMesTecno');
/*******/
/* End */
/*******/


/******************************************/
/* Definiciones Producto Súper Avance SAV */
/******************************************/
defined('DIAS_VIGENCIA_COTIZACIONES') OR define('DIAS_VIGENCIA_COTIZACIONES', 7);
defined('USER_ROL_SUPER_ADMIN') OR define('USER_ROL_SUPER_ADMIN', 1);
defined('USER_ROL_ADMIN') OR define('USER_ROL_ADMIN', 2);
defined('USER_ROL_EJECUTIVO_COMERCIAL') OR define('USER_ROL_EJECUTIVO_COMERCIAL', 3);
defined('USER_ROL_EJECUTIVO_TELEMARKETING') OR define('USER_ROL_EJECUTIVO_TELEMARKETING', 4);
defined('USER_ROL_JEFE_DE_OFICINA') OR define('USER_ROL_JEFE_DE_OFICINA', 5);
defined('USER_ROL_GERENTE_ZONAL') OR define('USER_ROL_GERENTE_ZONAL', 6);
defined('USER_ROL_GERENTE_DIVISION') OR define('USER_ROL_GERENTE_DIVISION', 7);
defined('USER_ROL_GERENTE_GENERAL') OR define('USER_ROL_GERENTE_GENERAL', 8);
defined('USER_ROL_CAJERO') OR define('USER_ROL_CAJERO', 9);

defined('COD_CRITERIO_CUOTAS') OR define('COD_CRITERIO_CUOTAS', "CUO");
defined('COD_CRITERIO_MONTO') OR define('COD_CRITERIO_MONTO', "MON");

defined('SHOW_NAME_ERRORFILE') OR define('SHOW_NAME_ERRORFILE', "/tmp/debug-err-");
defined('SHOW_NAME_LOGFILE') OR define('SHOW_NAME_LOGFILE', "/tmp/debug-log-");
defined('SHOW_DEBUG_LOGFILE') OR define('SHOW_DEBUG_LOGFILE', TRUE);

defined('MASCARA_MONEDA_UF') OR define('MASCARA_MONEDA_UF', "UF");
defined('MASCARA_MONEDA_DOLAR') OR define('MASCARA_MONEDA_DOLAR', "US");
defined('MASCARA_MONEDA_PESOS') OR define('MASCARA_MONEDA_PESOS', "$");
defined('COD_ERROR_INIT') OR define('COD_ERROR_INIT', 130);
defined('COD_ERROR_VALID_FORM') OR define('COD_ERROR_VALID_FORM', 131);
defined('COD_OTRO_MOTIVO_ATENCION') OR define('COD_OTRO_MOTIVO_ATENCION', 115999);

defined('MSG_ERROR_SERVICE') OR define('MSG_ERROR_SERVICE', "Fatal Error, al intentar conectar Web.Service Core ..!");
defined('MSG_ERROR_CARTERA_VENCIDA') OR define('MSG_ERROR_CARTERA_VENCIDA', "Error, Cliente en cartera vencida ..!");
defined('MSG_ERROR_SERVICE_NOOK') OR define('MSG_ERROR_SERVICE_NOOK', "Error, en respuesta del Web.Service Core ..!");
defined('MSG_ERROR_SESSION_EXPIRED') OR define('MSG_ERROR_SESSION_EXPIRED', "Tiempo Excedido inactividad, Vuelva a Conectar");
defined('MSG_ERROR_VALID_FORM') OR define('MSG_ERROR_VALID_FORM', 'Error al leer datos de Entrada Formulario ..!');

defined('MSG_ERROR_INIT') OR define('MSG_ERROR_INIT', 'ERROR INIT');
defined('COD_ERROR_XML_INVALIDO') OR define('COD_ERROR_XML_INVALIDO', 300);
defined('MSG_ERROR_XML_INVALIDO') OR define('MSG_ERROR_XML_INVALIDO', 'Error, Respuesta en formato XML no es valido ..!');

defined('MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE') OR define('MSG_SIN_RESPUESTA_SERVICIOS_CLIENTE', 'SIN RESPUESTA DESDE EL CORE');
defined('MSG_RESPUESTA_CORE_INVALIDA') OR define('MSG_RESPUESTA_CORE_INVALIDA', 'RESPUESTA CORE NO ES POSIBLE PROCESARLA');
defined('MSG_ATRIBUTO_PENDIENTE') OR define('MSG_ATRIBUTO_PENDIENTE', 'DATO PENDIENTE');
defined('MSG_FIELD_EMPTY') OR define('MSG_FIELD_EMPTY', 'ATRIBUTO VACIO');
defined('MSG_ALERT_WARNING') OR define('MSG_ALERT_WARNING', 'Presta Mucha Atención ..!');
defined('MSG_ALERT_ERROR') OR define('MSG_ALERT_ERROR', 'Alerta, A ocurrido un Error ..!');
defined('MSG_ALERT_SUCCESS') OR define('MSG_ALERT_SUCCESS', 'Transacción Aceptada ..');

defined('MSG_SIN_OFERTAS') OR define('MSG_SIN_OFERTAS', 'CLIENTE NO TIENE OFERTAS');
defined('MSG_SIN_CUPOS') OR define('MSG_SIN_CUPOS', 'CLIENTE NO TIENE CUPOS APROBADOS');
defined('MSG_SIN_CARTERA_VENCIDA') OR define('MSG_SIN_CARTERA_VENCIDA', 'CLIENTE NO TIENE PRODUCTOS EN CARTERA VENCIDA');
defined('MSG_SIN_TARJETAS') OR define('MSG_SIN_TARJETAS', 'CLIENTE NO REGISTRA TARJETAS');
defined('MSG_ERROR_HTTP_ERROR_URL') OR define('MSG_ERROR_HTTP_ERROR_URL', 'HTTP method POST is not supported by this URL');
defined('MSG_PERMISOS_INSUFICIENTES') OR define('MSG_PERMISOS_INSUFICIENTES', 'Permisos Insuficientes');

defined('WS_Timeout') OR define('WS_Timeout', 10);
defined('WS_Timeout20') OR define('WS_Timeout20', 20);
defined('WS_Timeout30') OR define('WS_Timeout30', 30);
defined('WS_Timeout40') OR define('WS_Timeout40', 40);
defined('WS_Timeout60') OR define('WS_Timeout60', 60);
defined('WS_Timeout90') OR define('WS_Timeout90', 90);
defined('WS_ToXml') OR define('WS_ToXml', 'XML');
defined('WS_ToJson') OR define('WS_ToJson', 'JSON');
defined('WS_ToArray') OR define('WS_ToArray', 'ARRAY');

defined('SOAP_ERROR') OR define('SOAP_ERROR', 'ERROR');
defined('SOAP_OK') OR define('SOAP_OK', 'OK');


/****************************/
/* Rutas WS Renegociaciones */
/****************************/
defined('WS_ConsultaEstadoTransfer') OR define('WS_ConsultaEstadoTransfer', '/ClSlvConecta_EstadoTransferenciaTC');
defined('WS_Action_ConsultaEstadoTransfer') OR define('WS_Action_ConsultaEstadoTransfer', 'urn:EstadoTransferenciaTC');
defined('WS_ConsultaPreAprobadosPorRut') OR define('WS_ConsultaPreAprobadosPorRut', '/ClSlvConecta_ClientesPreAprobadosTecnocom');
defined('WS_Action_ConsultaPreAprobadosPorRut') OR define('WS_Action_ConsultaPreAprobadosPorRut', 'urn:ClientesPreAprobados');
defined('WS_Reprint_Credit_Card') OR define('WS_Reprint_Credit_Card', '/ClSlvConecta_EstampacionOnline');
defined('WS_Action_Reprint_Credit_Card') OR define('WS_Action_Reprint_Credit_Card', 'urn:EstampacionOnline');
defined('WS_Blocking_Credit_Card') OR define('WS_Blocking_Credit_Card', '/ClSlvConecta_BloqueoDesbloqueoTarjeta');
defined('WS_Action_Blocking_Credit_Card') OR define('WS_Action_Blocking_Credit_Card', 'urn:BloqueoDesbloqueoTarjeta');
defined('WS_GrabaPreAprobados') OR define('WS_GrabaPreAprobados', '/ClSlvConecta_CaptacionClientes');
defined('WS_Action_GrabaPreAprobados') OR define('WS_Action_GrabaPreAprobados', 'urn:CaptacionClientes');
defined('WS_ActualizaEstadoTransferencia') OR define('WS_ActualizaEstadoTransferencia', '/ClSlvConecta_ActualizaEstadoTransferencia');
defined('WS_Action_ActualizaEstadoTransferencia') OR define('WS_Action_ActualizaEstadoTransferencia', 'urn:ActualizaEstadoTransferencia');
defined('WS_ConsultaTasaMaxima') OR define('WS_ConsultaTasaMaxima', '/ClSlvConecta_ConsultaTasaMaxima');
defined('WS_Action_ConsultaTasaMaxima') OR define('WS_Action_ConsultaTasaMaxima', 'urn:ConsultaTasa');
defined('WS_EnvioSMS') OR define('WS_EnvioSMS', '/ClSlvConecta_EnvioSMS');
defined('WS_Action_EnvioSMS') OR define('WS_Action_EnvioSMS', 'urn:EnvioSMS');
defined('WS_SendEmail') OR define('WS_SendEmail', '/ClSlvConecta_EnvioEmail');
defined('WS_Action_SendEmail') OR define('WS_Action_SendEmail', 'urn:EnvioEmail');
defined('WS_PS_Transferencia_SAV') OR define('WS_PS_Transferencia_SAV', '/PS_Transferencia_SAV');
defined('WS_Action_PS_Transferencia_SAV') OR define('WS_Action_PS_Transferencia_SAV', 'urn:TransferenciaSAVService');
defined('WS_GrabarBeneficiarios') OR define('WS_GrabarBeneficiarios', '/ClSlvConecta_GrabarBeneficiarios');
defined('WS_Action_GrabarBeneficiarios') OR define('WS_Action_GrabarBeneficiarios', 'urn:GrabarBeneficiarios');
defined('WS_ListarBeneficiarios') OR define('WS_ListarBeneficiarios', '/ClSlvConecta_ListarBeneficiarios');
defined('WS_Action_ListarBeneficiarios') OR define('WS_Action_ListarBeneficiarios', 'urn:ListarBeneficiarios');
defined('WS_ActualizaCotizacion') OR define('WS_ActualizaCotizacion', '/ClSlvConecta_ActualizaCotizacion');
defined('WS_Action_ActualizaCotizacion') OR define('WS_Action_ActualizaCotizacion', 'urn:ActualizaCotizacion');
defined('WS_ActualizaEnlaceTC') OR define('WS_ActualizaEnlaceTC', '/ClSlvConecta_ActualizaEnlaceTC');
defined('WS_Action_ActualizaEnlaceTC') OR define('WS_Action_ActualizaEnlaceTC', 'urn:ActualizaEnlaceTC');
defined('WS_ConsultaCotizacionesSAV') OR define('WS_ConsultaCotizacionesSAV', '/ClSlvConecta_ConsultaCotizacionesSAV');
defined('WS_Action_ConsultaCotizacionesSAV') OR define('WS_Action_ConsultaCotizacionesSAV', 'urn:ConsultaCotizacionesSAV');
defined('WS_ActualizaRechazoTC') OR define('WS_ActualizaRechazoTC', '/ClSlvConecta_ActualizaRechazoTC');
defined('WS_Action_ActualizaRechazoTC') OR define('WS_Action_ActualizaRechazoTC', 'urn:ActualizaRechazoTC');
defined('WS_SimulacionTrxTC') OR define('WS_SimulacionTrxTC', '/ClSlvConecta_SimulacionTrxGtwTC');
defined('WS_Action_SimulacionTrxTC') OR define('WS_Action_SimulacionTrxTC', 'urn:SimulacionTrxTCConsultaCuposTCService');
defined('WS_ConsumoVigenteTC') OR define('WS_ConsumoVigenteTC', '/ClSlvConecta_ConsumoVigenteTC');
defined('WS_Action_ConsumoVigenteTC') OR define('WS_Action_ConsumoVigenteTC', 'urn:ConsumoVigenteTC');
defined('WS_CreaSimuCotiSavTC') OR define('WS_CreaSimuCotiSavTC', '/ClSlvConecta_CreaSimuCotiSavTC');
defined('WS_Action_CreaSimuCotiSavTC') OR define('WS_Action_CreaSimuCotiSavTC', 'urn:CreaSimuCotiSavTC');
defined('WS_DatosOpComercialTC') OR define('WS_DatosOpComercialTC', '/ClSlvConecta_DatosOpComercialTC');
defined('WS_Action_DatosOpComercialTC') OR define('WS_Action_DatosOpComercialTC', 'urn:DatosOpComercialTC');
defined('WS_ActEstadoSavYRefTC') OR define('WS_ActEstadoSavYRefTC', '/ClSlvConecta_ActEstadoSavYRefTC');
defined('WS_Action_ActEstadoSavYRefTC') OR define('WS_Action_ActEstadoSavYRefTC', 'urn:ActEstadoSavYRefTC');
defined('WS_ActualizaOfertaTC') OR define('WS_ActualizaOfertaTC', '/ClSlvConecta_ActualizaOfertaTC');
defined('WS_Action_ActualizaOfertaTC') OR define('WS_Action_ActualizaOfertaTC', 'urn:ActualizaOferta');
defined('WS_Action_ConsultaDatosClienteTC') OR define('WS_Action_ConsultaDatosClienteTC', 'urn:ConsultaDatosClienteTCService');
defined('WS_Homologador_BusquedaPorRut') OR define('WS_Homologador_BusquedaPorRut', '/operaciones/SolvCoreTarjHomo_BusquedaPorRut');
defined('WS_Homologador_BusquedaPorRutComercio') OR define('WS_Homologador_BusquedaPorRutComercio', '/operaciones/SolvCoreTarjHomo_BusquedaPorRutComercioProducto');
defined('WS_Homologador_BusquedaPorTarjeta') OR define('WS_Homologador_BusquedaPorTarjeta', '/operaciones/SolvCoreTarjHomo_BusquedaPorTarjeta');
defined('WS_Action_Homologador') OR define('WS_Action_Homologador', 'urn:tarjetasHomologadas');
defined('WS_GrabaDatosAcreditacionTC') OR define('WS_GrabaDatosAcreditacionTC', '/ClSlvConecta_GrbDatosAcreditacionTC');
defined('WS_Action_GrabaDatosAcreditacionTC') OR define('WS_Action_GrabaDatosAcreditacionTC', 'urn:GrbDatosAcreditacionTC');
defined('WS_GrabarRazonVisitaTC') OR define('WS_GrabarRazonVisitaTC', '/ClSlvConecta_GrabarRazonVisitaTC');
defined('WS_ConsultaRazonVisitaTC') OR define('WS_ConsultaRazonVisitaTC', '/ClSlvConecta_ConsultaRazonVisitaTC');
defined('WS_DatosProductoTC') OR define('WS_DatosProductoTC', '/ClSlvConecta_DatosProductoTC');
defined('WS_Action_DatosProductoTC') OR define('WS_Action_DatosProductoTC', 'urn:DatosProductoTCService');
defined('WS_GrabaEstadosCuenta') OR define('WS_GrabaEstadosCuenta', '/ClSlvConecta_GrabaEstadosCuenta');
defined('WS_Action_GrabaEstadosCuenta') OR define('WS_Action_GrabaEstadosCuenta', 'urn:GrabaEstadosCuentaService');
defined('WS_GrabarDatosCuenta') OR define('WS_GrabarDatosCuenta', '/ClSlvConecta_GrabarDatosCuenta');
defined('WS_Action_GrabarDatosCuenta') OR define('WS_Action_GrabarDatosCuenta', 'urn:GrabarDatosCuenta');
defined('WS_ConsultaUltimasTransaccionesTC') OR define('WS_ConsultaUltimasTransaccionesTC', '/ClSlvConecta_ConsultaUltimasTransaccionesTC');
defined('WS_Action_ConsultaUltimasTransaccionesTC') OR define('WS_Action_ConsultaUltimasTransaccionesTC', 'urn:ConsultaUltimasTransaccionesTCService');
defined('WS_ConsultaAutorizacionesTC') OR define('WS_ConsultaAutorizacionesTC', '/ClSlvConecta_ConsultaAutorizacionesTC');
defined('WS_Action_ConsultaAutorizacionesTC') OR define('WS_Action_ConsultaAutorizacionesTC', 'urn:ConsultaAutorizacionesTCBindingQSService');
defined('WS_ConsultaDeudaClienteTC') OR define('WS_ConsultaDeudaClienteTC', '/ClSlvConecta_ConsultaDeudaClienteTC');
defined('WS_Action_ConsultaDeudaClienteTC') OR define('WS_Action_ConsultaDeudaClienteTC', 'urn:ConsultaDeudaClienteTCService');
defined('WS_Action_GrabarRazonVisitaTC') OR define('WS_Action_GrabarRazonVisitaTC', 'urn:GrabarRazonVisitaTC');
defined('WS_Action_ConsultaDatosEECCTC') OR define('WS_Action_ConsultaDatosEECCTC', 'urn:');
defined('WS_ConsultaCarteraVencidaTC') OR define('WS_ConsultaCarteraVencidaTC', '/ClSlvConecta_ConsultaCarteraVencidaTC');
defined('WS_Action_ConsultaCarteraVencidaTC') OR define('WS_Action_ConsultaCarteraVencidaTC', 'urn:ConsultaCarteraVencidaTC');
defined('WS_ConsultaParametrosAdquirenteTC') OR define('WS_ConsultaParametrosAdquirenteTC', '/ClSlvConecta_ConsultaParametrosAdquirenteTC');
defined('WS_Action_ConsultaParametrosAdquirenteTC') OR define('WS_Action_ConsultaParametrosAdquirenteTC', 'urn:ConsultaParametrosAdquirenteTC');
defined('WS_ConsultaDatosDireccion') OR define('WS_ConsultaDatosDireccion', '/ClSlvConecta_ConsultaDatosDireccion');
defined('WS_Action_ConsultaDatosDireccion') OR define('WS_Action_ConsultaDatosDireccion', 'urn:ConsultaDatosDireccionBindingQSService');
defined('WS_ConsultaDatosContactoTC') OR define('WS_ConsultaDatosContactoTC', '/ClSlvConecta_ConsultaDatosContactoTC');
defined('WS_Action_ConsultaDatosContactoTC') OR define('WS_Action_ConsultaDatosContactoTC', 'urn:ConsultaDatosContactoTCBindingQSService');
defined('WS_DatosOfertaTC') OR define('WS_DatosOfertaTC', '/ClSlvConecta_DatosOfertaTC');
defined('WS_Action_DatosOfertaTC') OR define('WS_Action_DatosOfertaTC', 'urn:DatosOfertaTC');
defined('WS_ConsultaTransaccionesTC') OR define('WS_ConsultaTransaccionesTC', '/ClSlvConecta_ConsultaTransaccionesTC');
defined('WS_Action_ConsultaTransaccionesTC') OR define('WS_Action_ConsultaTransaccionesTC', 'urn:ConsultaTransaccionesTCBindingQSService');
defined('WS_ConsultaDatosEECCTC') OR define('WS_ConsultaDatosEECCTC', '/ClSlvConecta_ConsultaDatosEECCTC');
defined('WS_Action_ConsultaDatosEECCTC') OR define('WS_Action_ConsultaDatosEECCTC', 'urn:ConsultaDatosEECCTCBindingQSService');
defined('WS_ConsultaDatosAdicionales') OR define('WS_ConsultaDatosAdicionales', '/ClSlvConecta_ConsultaDatosAdicionales');
defined('WS_Action_ConsultaDatosAdicionales') OR define('WS_Action_ConsultaDatosAdicionales', 'urn:ConsultaDatosAdicionalesService');
defined('WS_ConsultaAcreditacionesTC') OR define('WS_ConsultaAcreditacionesTC', '/ClSlvConecta_ConsultaAcreditacionesTC');
defined('WS_Action_ConsultaAcreditacionesTC') OR define('WS_Action_ConsultaAcreditacionesTC', 'urn:ConsultaAcreditacionesTC');
defined('WS_ConsultaSegurosContratados') OR define('WS_ConsultaSegurosContratados', '/ClSlvConecta_ConsultaSegurosContratados');
defined('WS_Action_ConsultaSegurosContratados') OR define('WS_Action_ConsultaSegurosContratados', 'urn:ConsultaSegurosContratados');
defined('WS_ConsultaSegurosNoContratados') OR define('WS_ConsultaSegurosNoContratados', '/ClSlvConecta_ConsultaSegurosNoContratados');
defined('WS_Action_ConsultaSegurosNoContratados') OR define('WS_Action_ConsultaSegurosNoContratados', 'urn:ConsultaSegurosNoContratados');
defined('WS_ConsultaParametrosTasaTC') OR define('WS_ConsultaParametrosTasaTC', '/ClSlvConecta_ConsultaParametrosTasaTC');
defined('WS_Action_ConsultaParametrosTasaTC') OR define('WS_Action_ConsultaParametrosTasaTC', 'urn:ConsultaParametrosTasaTC');
defined('WS_ConsultaParametrosSobregiroTC') OR define('WS_ConsultaParametrosSobregiroTC', '/ClSlvConecta_ConsultaParametrosSobregiroTC');
defined('WS_Action_ConsultaParametrosSobregiroTC') OR define('WS_Action_ConsultaParametrosSobregiroTC', 'urn:ConsultaParametrosSobregiroTC');
defined('WS_ConsultaDatosClienteTC') OR define('WS_ConsultaDatosClienteTC', '/ClSlvConecta_ConsultaDatosClienteTC');
defined('WS_Action_ConsultaDatosClienteTC') OR define('WS_Action_ConsultaDatosClienteTC', 'urn:ConsultaDatosClienteTCService');
defined('WS_ActualizaDatosAdicionalesTC') OR define('WS_ActualizaDatosAdicionalesTC', '/ClSlvConecta_GrbDatosAdicionalesCT');
defined('WS_Action_ActualizaDatosAdicionalesTC') OR define('WS_Action_ActualizaDatosAdicionalesTC', 'urn:GrbDatosAdicionalesCTService"');
defined('WS_ActualizaDatosClienteTC') OR define('WS_ActualizaDatosClienteTC', '/ClSlvConecta_ActualizaDatosClienteTC');
defined('WS_Action_ActualizaDatosClienteTC') OR define('WS_Action_ActualizaDatosClienteTC', 'urn:ActualizaDatosClienteTCBindingQSService"');
defined('WS_ActualizaDatosDireccionTC') OR define('WS_ActualizaDatosDireccionTC', '/ClSlvConecta_ActualizaDatosDireccionTC');
defined('WS_Action_ActualizaDatosDireccionTC') OR define('WS_Action_ActualizaDatosDireccionTC', 'urn:ActualizaDatosDireccionTCService');
defined('WS_ActualizaDatosContactoTC') OR define('WS_ActualizaDatosContactoTC', '/ClSlvConecta_ActualizaDatosContactoTC');
defined('WS_Action_ActualizaDatosContactoTC') OR define('WS_Action_ActualizaDatosContactoTC', 'urn:ActualizaDatosContactoTCService"');
defined('WS_ConsultaDatosCuenta') OR define('WS_ConsultaDatosCuenta', '/ClSlvConecta_ConsultaDatosCuenta');
defined('WS_Action_ConsultaDatosCuenta') OR define('WS_Action_ConsultaDatosCuenta', 'urn:ConsultaDatosCuentaBindingQSService');
defined('WS_ConsultaDatosTarjetaTC') OR define('WS_ConsultaDatosTarjetaTC', '/ClSlvConecta_ConsultaDatosTarjetaTC');
defined('WS_Action_ConsultaDatosTarjetaTC') OR define('WS_Action_ConsultaDatosTarjetaTC', 'urn:ConsultaDatosTarjetaTCBindingQSService');
defined('WS_ConsultaSegmentosTC') OR define('WS_ConsultaSegmentosTC', '/ClSlvConecta_ConsultaSegmentoClientes');
defined('WS_Action_ConsultaSegmentosTC') OR define('WS_Action_ConsultaSegmentosTC', 'urn:WS_Segmentos');
defined('WS_ConsultaCuposTC') OR define('WS_ConsultaCuposTC', '/ClSlvConecta_ConsultaCuposTC');
defined('WS_Action_ConsultaCuposTC') OR define('WS_Action_ConsultaCuposTC', 'urn:ConsultaCuposTCService');
defined('WS_ConsultaEstadosBloqueo') OR define('WS_ConsultaEstadosBloqueo', '/ClSlvConecta_ConsultaEstadosBloqueo');
defined('WS_Action_ConsultaEstadosBloqueo') OR define('WS_Action_ConsultaEstadosBloqueo', 'urn:ConsultaEstadosBloqueoBindingQSService');
defined('WS_ConsultaDoctoEECC') OR define('WS_ConsultaDoctoEECC', '/ClSlvConecta_ConsultaDoctoEECC');
defined('WS_Action_ConsultaDoctoEECC') OR define('WS_Action_ConsultaDoctoEECC', 'urn:servicioOrquestadoEECC');

defined('CUOTAS_DIFERIR_PRODUCTOS') OR define('CUOTAS_DIFERIR_PRODUCTOS', '108');
defined('CODIGO_SUPER_AVANCE') OR define('CODIGO_SUPER_AVANCE', 'SAV');
defined('CODIGO_RENEGOCIACION') OR define('CODIGO_RENEGOCIACION', 'REN');
defined('CODIGO_REFINANCIAMIENTO') OR define('CODIGO_REFINANCIAMIENTO', 'REF');
defined('CODIGO_TARJETA_ABIERTA') OR define('CODIGO_TARJETA_ABIERTA', 'TAV');
defined('DESCRIP_SUPER_AVANCE') OR define('DESCRIP_SUPER_AVANCE', 'SUPER AVANCE');
defined('DESCRIP_RENEGOCIACION') OR define('DESCRIP_RENEGOCIACION', 'RENEGOCIACION');
defined('DESCRIP_REFINANCIAMIENTO') OR define('DESCRIP_REFINANCIAMIENTO', 'REFINANCIAMIENTO');
defined('DESCRIP_TARJETA_ABIERTA') OR define('DESCRIP_TARJETA_ABIERTA', 'TARJETA ABIERTA VISA');
defined('DESCRIP_TARJETA_PRIVADA') OR define('DESCRIP_TARJETA_PRIVADA', 'TARJETA CERRADA CRUZ VERDE');
defined('htmlSIMULACION') OR define('htmlSIMULACION', 'Simulaci&#243;n');
defined('DESCRIP_VIGENTE') OR define('DESCRIP_VIGENTE', 'VIGENTE');
defined('DESCRIP_NO_VIGENTE') OR define('DESCRIP_NO_VIGENTE', 'NO VIGENTE');
defined('DESCRIP_CONSUMO_VIGENTE') OR define('DESCRIP_CONSUMO_VIGENTE', 'CONSUMO VIGENTE');
defined('DESCRIP_CONSUMO_NO_VIGENTE') OR define('DESCRIP_CONSUMO_NO_VIGENTE', 'CONSUMO NO VIGENTE');
/*******/
/* End */
/*******/




/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
