<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('WS_Timeout') OR define('WS_Timeout', 10);
defined('WS_ToXml') OR define('WS_ToXml', 'XML');
defined('WS_ToJson') OR define('WS_ToJson', 'JSON');
defined('WS_ToArray') OR define('WS_ToArray', 'ARRAY');

defined('WS_Teknodata_Ip') OR define('WS_Teknodata_Ip', '200.73.112.250');
defined('WS_Teknodata_Ip_Port') OR define('WS_Teknodata_Ip_Port', '7005');
defined('WS_Teknodata_http') OR define('WS_Teknodata_http', 'http://');
defined('WS_Teknodata_https') OR define('WS_Teknodata_https', 'https://');
defined('WS_Teknodata_ConsultaDatosClienteTC') OR define('WS_Teknodata_ConsultaDatosClienteTC', '/solventa.maximoerp.com/consultaclientesTC.asmx?WSDL');
defined('WS_Teknodata_Action_ConsultaDatosClienteTC') OR define('WS_Teknodata_Action_ConsultaDatosClienteTC', 'http://www.solventa.cl/consultaDatosCliente');



defined('WS_Ip') OR define('WS_Ip', '10.193.122.141');
defined('WS_Ip_Port') OR define('WS_Ip_Port', '7005');
defined('WS_http') OR define('WS_http', 'http://');
defined('WS_https') OR define('WS_https', 'https://');

/*
 * Definición de Servicios y Metodos  
 */
defined('WS_ConsultaDatosClienteTC') OR define('WS_ConsultaDatosClienteTC', '/ClSlvConecta_ConsultaDatosClienteTC');
defined('WS_Action_ConsultaDatosClienteTC') OR define('WS_Action_ConsultaDatosClienteTC', 'urn:ConsultaDatosClienteTCService');
defined('WS_Homologador_BusquedaPorRut') OR define('WS_Homologador_BusquedaPorRut', '/operaciones/SolvCoreTarjHomo_BusquedaPorRut');
defined('WS_Homologador_BusquedaPorRutComercio') OR define('WS_Homologador_BusquedaPorRutComercio', '/operaciones/SolvCoreTarjHomo_BusquedaPorRutComercioProducto');
defined('WS_Homologador_BusquedaPorTarjeta') OR define('WS_Homologador_BusquedaPorTarjeta', '/operaciones/SolvCoreTarjHomo_BusquedaPorTarjeta');
defined('WS_Action_Homologador') OR define('WS_Action_Homologador', 'urn:tarjetasHomologadas');


defined('WS_ConsultaTransaccionesTC') OR define('WS_ConsultaTransaccionesTC', '/ClSlvConecta_ConsultaTransaccionesTC');

defined('WS_GrabarRazonVisitaTC') OR define('WS_GrabarRazonVisitaTC', '/ClSlvConecta_GrabarRazonVisitaTC');
defined('WS_ConsultaRazonVisitaTC') OR define('WS_ConsultaRazonVisitaTC', '/ClSlvConecta_ConsultaRazonVisitaTC');
defined('WS_DatosProductoTC') OR define('WS_DatosProductoTC', '/ClSlvConecta_DatosProductoTC');
defined('WS_DatosOfertaTC') OR define('WS_DatosOfertaTC', '/ClSlvConecta_DatosOfertaTC');
defined('WS_ConsultaAutorizacionesTC') OR define('WS_ConsultaAutorizacionesTC', '/ClSlvConecta_ConsultaAutorizacionesTC');
defined('WS_ActualizaDatosClienteTC') OR define('WS_ActualizaDatosClienteTC', '/ClSlvConecta_ActualizaDatosClienteTC');
defined('WS_ConsultaAcreditacionesTC') OR define('WS_ConsultaAcreditacionesTC', '/ClSlvConecta_ConsultaAcreditacionesTC');
defined('WS_ConsultaCarteraVencidaTC') OR define('WS_ConsultaCarteraVencidaTC', '/ClSlvConecta_ConsultaCarteraVencidaTC');
defined('WS_ConsultaDatosAdicionales') OR define('WS_ConsultaDatosAdicionales', '/ClSlvConecta_ConsultaDatosAdicionales');
defined('WS_ConsultaDatosEECCTC') OR define('WS_ConsultaDatosEECCTC', '/ClSlvConecta_ConsultaDatosEECCTC');
defined('WS_ConsultaEstadosBloqueo') OR define('WS_ConsultaEstadosBloqueo', '/ClSlvConecta_ConsultaEstadosBloqueo');
defined('WS_ConsultaDatosTarjetaTC') OR define('WS_ConsultaDatosTarjetaTC', '/ClSlvConecta_ConsultaDatosTarjetaTC');
defined('WS_ConsultaDatosCuenta') OR define('WS_ConsultaDatosCuenta', '/ClSlvConecta_ConsultaDatosCuenta');
defined('WS_ConsultaDatosContactoTC') OR define('WS_ConsultaDatosContactoTC', '/ClSlvConecta_ConsultaDatosContactoTC');

defined('WS_Action_ConsultaTransaccionesTC') OR define('WS_Action_ConsultaTransaccionesTC', 'urn:ConsultaRazonVisitaTC');
defined('WS_Action_GrabarRazonVisitaTC') OR define('WS_Action_GrabarRazonVisitaTC', 'urn:GrabarRazonVisitaTC');
defined('WS_Action_DatosProductoTC') OR define('WS_Action_DatosProductoTC', 'urn:DatosProductoTCService');
defined('WS_Action_ConsultaDatosAdicionales') OR define('WS_Action_ConsultaDatosAdicionales', 'urn:ConsultaDatosAdicionalesService');
defined('WS_Action_DatosOfertaTC') OR define('WS_Action_DatosOfertaTC', 'urn:DatosOfertaTC');
defined('WS_Action_ConsultaAutorizacionesTC') OR define('WS_Action_ConsultaAutorizacionesTC', 'urn:');
defined('WS_Action_ActualizaDatosClienteTC') OR define('WS_Action_ActualizaDatosClienteTC', 'urn:');
defined('WS_Action_ConsultaAcreditacionesTC') OR define('WS_Action_ConsultaAcreditacionesTC', 'urn:ConsultaAcreditacionesTC');
defined('WS_Action_ConsultaCarteraVencidaTC') OR define('WS_Action_ConsultaCarteraVencidaTC', 'urn:ConsultaCarteraVencidaTC');
defined('WS_Action_ConsultaDatosAdicionales') OR define('WS_Action_ConsultaDatosAdicionales', 'urn:ConsultaDatosAdicionalesService');
defined('WS_Action_ConsultaDatosEECCTC') OR define('WS_Action_ConsultaDatosEECCTC', 'urn:');
defined('WS_Action_ConsultaEstadosBloqueo') OR define('WS_Action_ConsultaEstadosBloqueo', 'urn:');
defined('WS_Action_ConsultaDatosTarjetaTC') OR define('WS_Action_ConsultaDatosTarjetaTC', 'urn:');
defined('WS_Action_ConsultaDatosCuenta') OR define('WS_Action_ConsultaDatosCuenta', 'urn:');
defined('WS_Action_ConsultaDatosContactoTC') OR define('WS_Action_ConsultaDatosContactoTC', 'urn:');



































defined('CUOTAS_DIFERIR_PRODUCTOS') OR define('CUOTAS_DIFERIR_PRODUCTOS', '108');

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
