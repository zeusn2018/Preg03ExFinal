<?php

include("Mysql.php");
include ("../_config/Configuracion.php");
$GLOBALS = $versionExcel;
$GLOBALS = $formato;
$GLOBALS = $cabeceraPDF;
$GLOBALS = $varglobal_rutaimpresion;
/* ESTABLECE LA VERSION DEL EXCEL EN TODOS LOS REPORTES */
//$varglobal_rutaimpresion =  "\\\\192.168.1.102\\EPSON LX-350 ESC/P";
$varglobal_rutaimpresion =  "\\\\192.168.1.45\\EPSON LX-300+ /II";
//$varglobal_rutaimpresion =  "\\\\localhost\\EPSON LX-350 ESC/P";
$cabeceraPDF = "130,130,130";
$formato = ".xls";
$versionExcel = "5"; /* ESTABLECE LA VERSION DEL EXCEL EN TODOS LOS REPORTES */

class Datos {

    public static function getCombo($mostrar, $vValores, $valorPorDefecto) {

        $objMysql = new Mysql();

        $salida = NULL;

        $val = $vValores[0]; // parametr 1 pasado por array

        $val2 = $vValores[1]; // parametr 2 pasado por array

        try {

            switch ($mostrar) {

                /*                 * ******************* LISTA LOS COMBOS **************** */
                case 'motivonotacredt':

                    $salida = $objMysql->getDropDownList("SELECT idmotivo AS 'codigo', nombre as 'descripcion' FROM motivo_notacredito order by nombre;", $valorPorDefecto);

                    break;

                case 'monedaCliente':
                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda order by idtipo_moneda;", $valorPorDefecto);

                    break;
                case 'motivotraslado':

                    $salida = $objMysql->getDropDownList("SELECT idtraslado AS 'codigo', nombre as 'descripcion' FROM motivo_traslado order by nombre;", $valorPorDefecto);

                    break;
                case 'moneda':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda order by nombre ASC;", $valorPorDefecto);

                    break;

                case 'departamento':

                    $salida = $objMysql->getDropDownList("SELECT codigo AS 'codigo', nombre as 'descripcion' FROM ubigeo where codprov=00 and coddist=00 order by nombre;", $valorPorDefecto);

                    break;

                case 'estado_cliente':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'tipo_cliente':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_cliente AS 'codigo', nombre as 'descripcion' FROM tipo_cliente ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'tipo_perfil':

                    $salida = $objMysql->getDropDownList("SELECT idperfil AS 'codigo', nombre as 'descripcion' FROM perfil WHERE estadoreg=1 ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'estado':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                /*                 * ****************FIN UPDUsuarios********************** */
                /*                 * ********************LISTA LOS COMBOS EN UPDUempleados************************************************************* */
                case 'tipo_perfilemp':

                    $salida = $objMysql->getDropDownList("SELECT idperfil AS 'codigo', nombre as 'descripcion' FROM perfil ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'empleados_lista':

                    $salida = $objMysql->getDropDownList("SELECT idempleados AS 'codigo', nombres as 'descripcion' FROM empleados ORDER BY nombres ASC;", $valorPorDefecto);

                    break;
                
                case 'estadoemp':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                /*                 * ****************FIN UPDUempleados********************** */

                /*                 * ******************COMBO ARTICULO******************* */
                case 'marcas':

                    $salida = $objMysql->getDropDownList("SELECT idmarca AS 'codigo', UPPER(nombre) as 'descripcion' FROM marca ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ****************FIN COMBO ARTICULO************* */
                case 'cmbClase':

                    $salida = $objMysql->getDropDownList("SELECT idclase AS 'codigo', nombre as 'descripcion' FROM " . DB_PREFIJO . "_clase WHERE eliminado<>1 and nombre<>'' ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ***************************** INSMarca ***************************** */
                case 'cmbCategoria':

                    $salida = $objMysql->getDropDownList("SELECT idcategoria AS 'codigo',  UPPER(nombre) as 'descripcion' FROM categoria WHERE estadoreg=1 ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ************************** Fin de Combo ************************** */
                case 'cmbGenero':

                    $salida = $objMysql->getDropDownList("SELECT idgenero AS 'codigo', nombre as 'descripcion' FROM " . DB_PREFIJO . "_genero WHERE eliminado<>1 and nombre<>'' ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'cmbPerfil':

                    $salida = $objMysql->getDropDownList("SELECT idperfil AS 'codigo', nombre as 'descripcion',IF(estadoreg=1,ACTIVO,NO ACTIVO) as estado FROM perfil ORDER BY nombre ASC;", $valorPorDefecto);

                    break;

                case 'cmbTipo':

                    $salida = $objMysql->getDropDownList("SELECT idtipag AS 'codigo', nomtipag as 'descripcion' from " . DB_PREFIJO . "_tipopag;", $valorPorDefecto);

                    break;

                /*                 * **************************UPDMarcas************************ */
                case 'categorias':

                    $salida = $objMysql->getDropDownList("SELECT idcategoria AS 'codigo', nombre as 'descripcion' from categoria;", $valorPorDefecto);

                    break;
                
                case 'categorias_stockmin':

                    $salida = $objMysql->getDropDownList("SELECT idcategoria AS 'codigo', nombre as 'descripcion' from categoria ORDER BY nombre asc;", $valorPorDefecto);

                    break;

                case 'codicion_pago':

                    $salida = $objMysql->getDropDownList("SELECT idcondicionFP AS 'codigo', nombre as 'descripcion' from condicionpagofp;", $valorPorDefecto);

                    break;

                case 'estado_marcas':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ************************************************************** */

                /*                 * **************************UPDCategorias************************ */
                case 'familia':

                    $salida = $objMysql->getDropDownList("SELECT idfamilia AS 'codigo', nombre as 'descripcion' from familia;", $valorPorDefecto);

                    break;
                /*                 * *************************************INSTipoCambio************************************** */
                case 'mostrarMoneda':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' from tipo_moneda;", $valorPorDefecto);

                    break;
                /*                 * ***********************************Fin************************************************** */
                case 'estado_cat':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ************************************************************** */

                /*                 * *********************UPDFamilias*********************** */
                case 'estado_fam':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * **************************************************** */
                /*                 * *********************UPDPerfiles*********************** */
                case 'estado_perfiles':

                    $salida = $objMysql->getDropDownList("SELECT estadoreg AS 'codigo', nombre as 'descripcion' FROM estado ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * **************************************************** */

                /*                 * *****************************UPDTIPOCAMBIO********************************** */
                case 'cmb_tipomoneda':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda;", $valorPorDefecto);

                    break;
                /*                 * ************************************************************************************ */
                /*                 * ****************************UPDPROVEEDORES******************************** */
                case 'persona_prov':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_cliente AS 'codigo', nombre as 'descripcion' FROM tipo_cliente ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ************************************************************************************ */
                /*                 * ****************************MANT. VENTAS POR VENDEDOR(USUARIOS)******************************** */
                case 'usuarios':

                    $salida = $objMysql->getDropDownList("SELECT idusuario AS 'codigo', nombre as 'descripcion' FROM usuario ORDER BY idusuario ASC;");

                    break;
                case 'articulos':

                    $salida = $objMysql->getDropDownList("SELECT idarticulo AS 'codigo', nombre as 'descripcion' FROM articulo ORDER BY nombre ASC;");

                    break;

                case 'cmb_cargo':

                    $salida = $objMysql->getDropDownList("SELECT idcargo AS 'codigo', nombre as 'descripcion' FROM cargo ORDER BY nombre ASC;", $valorPorDefecto);

                    break;
                /*                 * ************************************************************************************ */
                /*                 * *******************************PopUP de Caja(Modulo de Pago)******************************* */
                case 'moneda_popup':

                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda ORDER BY idtipo_moneda ASC;", $valorPorDefecto);

                    break;
                case 'condicion_pago_popup':

                    $salida = $objMysql->getDropDownList("SELECT idcondicionFP AS 'codigo', nombre as 'descripcion' FROM condicionpagofp ORDER BY idcondicionFP ASC;", $valorPorDefecto);

                    break;
                case 'forma_pago_popup':

                    $salida = $objMysql->getDropDownList("SELECT idcondicionPago AS 'codigo', condicion as 'descripcion' FROM condicionpago ORDER BY idcondicionPago ASC;", $valorPorDefecto);

                    break;
                case 'forma_pago_contado':
                    $salida = $objMysql->getDropDownList("SELECT idcondicionPago AS 'codigo',condicion as 'descripcion' FROM condicionpago where idcondicionPago in (1,2,7,8);", $valorPorDefecto);
                    break;
                case 'forma_pago_credito':
//                    $salida = $objMysql->getDropDownList("SELECT idcondicionPago AS 'codigo',condicion as 'descripcion' FROM condicionpago where idcondicionPago in (2,3,4,5,6,8,15,16,17,18);", $valorPorDefecto);
                    $salida = $objMysql->getDropDownList("SELECT idcondicionPago AS 'codigo',condicion as 'descripcion' FROM condicionpago where idcondicionPago in (3,4,5,6,15,16,17,18);", $valorPorDefecto);
                    break;
                /*                 * ************************************************************************************* */
                /*                 * *********************Movimiento de Caja*********************** */
                case 'mcaja_moneda':
                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda ORDER BY idtipo_moneda ASC;", $valorPorDefecto);
                    break;

                case 'mcaja_autorizado':
                    $salida = $objMysql->getDropDownList("SELECT idusuario AS 'codigo', nombre as 'descripcion' FROM usuario where estadoreg=1 and idperfil=1 ORDER BY idusuario ASC;", $valorPorDefecto);
                    break;
                /*                 * ************************Fin de Movimiento de Caja************************************ */

                /*                 * ************************Mantenimiento: Movimiento de Caja**************************************** */
                case 'mc_movimiento':
                    $salida = $objMysql->getDropDownList("SELECT id AS 'codigo', nombre as 'descripcion' FROM tipo_movimiento ORDER BY id ASC;", $valorPorDefecto);
                    break;

                case 'mc_usuario':
                    $salida = $objMysql->getDropDownList("SELECT idusuario AS 'codigo', nombre as 'descripcion' FROM usuario ORDER BY idusuario ASC;", $valorPorDefecto);
                    break;

                case 'mc_moneda':
                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda ORDER BY idtipo_moneda ASC;", $valorPorDefecto);
                    break;
                case 'mc_tipo_mov':
                    $salida = $objMysql->getDropDownList("SELECT id AS 'codigo', nombre as 'descripcion' FROM tipo_movimiento ORDER BY id ASC;", $valorPorDefecto);
                    break;
                /*                 * ************************Fin Mantenimiento: Movimiento de Caja************************************ */
                /*                 * ****************************       Consultar Kardex       ************************************* */
                case 'kardex_moneda':
                    $salida = $objMysql->getDropDownList("SELECT idtipo_moneda AS 'codigo', nombre as 'descripcion' FROM tipo_moneda ORDER BY idtipo_moneda ASC;", $valorPorDefecto);
                    break;
                /*                 * *********************************** Fin de Kardex *********************************************** */
                /*                 * ***********************************Cuentas Cobrar********************************************** */
                case 'tipo_documentoCC':
                    $salida = $objMysql->getDropDownList("SELECT idcomprobante AS 'codigo', nombre as 'descripcion' FROM comprobantes ORDER BY idcomprobante ASC;", $valorPorDefecto);
                    break;
                /*                 * *********************************************************************************************** */
                /*                 * ********************* Condicion de pago Ventas *************************** */
                case 'condicion_pagoV':
                    $salida = $objMysql->getDropDownList("SELECT idcondicionFP AS 'codigo', nombre as 'descripcion' FROM condicionpagofp ORDER BY idcondicionFP ASC;", $valorPorDefecto);
                    break;
                case 'Formas_pagoV':
                    $salida = $objMysql->getDropDownList("SELECT idcondicionPago AS 'codigo', condicion as 'descripcion' FROM condicionpago ORDER BY idcondicionPago ASC;", $valorPorDefecto);
                    break;
                /*                 * ********************************************************** */
                /*                 * ********************* Combo de Tarjeta en Caja ********************* */
                case 'tarjeta_caja':
                    $salida = $objMysql->getDropDownList("SELECT idtarjetas_credito as 'codigo', nombre as 'descripcion' FROM tarjetas_credito ORDER BY idtarjetas_credito ASC", $valorPorDefecto);
                    break;
                case 'bancoMC':
                    $salida = $objMysql->getDropDownList("SELECT idbanco as 'codigo', nombres as 'descripcion' FROM banco ORDER BY idbanco ASC", $valorPorDefecto);
                    break;
                /*                 * ******************************************************************** */
                case 'cmb_comprobante':
                    $salida = $objMysql->getDropDownList("SELECT idcomprobante as 'codigo', nombre as 'descripcion' FROM comprobantes ORDER BY nombre ASC", $valorPorDefecto);
                    break;

                case 'unidad_medida':
                    $salida = $objMysql->getDropDownList("SELECT idunidad as 'codigo', nombre as 'descripcion' FROM unidad_medida ORDER BY idunidad ASC", $valorPorDefecto);
                    break;
            }
        } catch (Exception $exc) {

            $salida = $exc->getTraceAsString();
        }

        return $salida;
    }

    public static function getConsulta(array $vParam) {

        $objMysql = new Mysql();

        $salida = NULL;

        $mostrar = $vParam[0]; // parametr 1 pasado por array

        $val1 = $vParam[1]; // parametr 2 pasado por array

        $ordenarPorCampo = $vParam[2];

        $ordenarEnForma = $vParam[3];

        $campoaBuscar = $vParam[4];

        $valoraBuscar = $vParam[5];

        $page = $vParam[6];

        $mostrarRegistros = $vParam[7];

        $queryOedenar = "";

        /* --------  instrucciones de orden ----------------------- */

        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {

            if ($ordenarEnForma == "ASC") {

                $ordenarEnForma = "DESC";
            } else {

                $ordenarEnForma = "ASC";
            }

            $queryOedenar = " order by " . $ordenarPorCampo . " " . $ordenarEnForma . " ";
        }

        /* -------------------------------------- */


        try {

            switch ($mostrar) {
                /*                 * **********************GRILLA SERIES**************************** */
                case 'listarSeries':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where s.idserie='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where s.nro_serie like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        s.idserie AS 'codigo' 

                                                        FROM serie s

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            
                                                            s.idserie as 'codigo',

                                                            s.nro_serie as 'nom',
                                                            
                                                            $_GET[id]

                                                            FROM serie s
                                                            
                                                            where idarticulo = '$_GET[id]'
                                                            "
                            . $queryBuscar . " " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarSeriesTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM serie where idarticulo = '$_GET[id]'");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                /*                 * ******************FIN GRILLA SERIE************************** */

                /*                 * ************************** GRILLA TIPO CAMBIO********************** */
                case 'listarBanco':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where b.idbanco='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where b.nombres like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        b.idbanco AS 'codigo' 

                                                        FROM banco b

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            b.idbanco as 'codigo',

                                                            b.nombres as 'nom'

                                                            FROM banco b

                                                            "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarBancoTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM banco");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;
                /*                 * **************************FIN BANCO********************** */

                case 'listarTipoCambio':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";
                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " where t.fecha like '%" . $valoraBuscar . "%' ";
                        } else {
                            $queryBuscar = " where m.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */
                    $datos = $objMysql->ejecutar("SELECT t.idtipo_cambio AS 'codigo',m.nombre as 'moneda' 
                                                    FROM tipo_cambio as t
                                                    left join(tipo_moneda as m)
                                                    on t.idtipo_moneda=m.idtipo_moneda "
                            . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;
                    $salida = $objMysql->ejecutar("SELECT t.idtipo_cambio as 'codigo',
                                                          m.nombre as 'moneda',
                                                          t.fecha,
                                                          t.compra,
                                                          t.venta,
                                                          t.promedio
                                                          FROM tipo_cambio as t 
                                                          LEFT JOIN (tipo_moneda as m)
                                                          ON t.idtipo_moneda=m.idtipo_moneda "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarTipoCambioTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM tipo_cambio");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;

                /*                 * **************************FIN TIPO CAMBIO********************** */

                /*                 * ************************** GRILLA FORMAS DE PAGO********************** */
                case 'listarTipoDePago':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where f.idcondicionPago='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where f.condicion like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        f.idcondicionPago AS 'codigo' 

                                                        FROM condicionpago f

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            f.idcondicionPago as 'codigo',

                                                            f.condicion as 'nom'

                                                            FROM condicionpago f

                                                            "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarTipoDePagoTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM condicionpago");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;
                /*                 * **************************FIN GRILLA FORMAS DE PAGO********************** */

                /*                 * *******************************GRILLA TARJETAS*************************** */
                case 'listarTarjeta':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where t.idtarjetas_credito='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where concat_ws(' ',t.nombre,t.tipo) like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        t.idtarjetas_credito AS 'codigo' 

                                                        FROM tarjetas_credito t

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            t.idtarjetas_credito as 'codigo',

                                                            t.nombre as 'nom',

                                                            t.tipo as 'tipo'

                                                            FROM tarjetas_credito t

                                                            "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarTarjetaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM tarjetas_credito");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;
                /*                 * **************************FIN GRILLA TARJETAS********************** */
                /*                 * **************************GRILLA MONEDAS********************** */
                case 'listarMoneda':

                    /* --------  instrucciones de busqueda ----------------------- */
                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " where m.idtipo_moneda='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " where m.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT m.idtipo_moneda AS 'codigo' 
                                                        FROM tipo_moneda m
                                                        " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }

                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;

                    $salida = $objMysql->ejecutar("SELECT m.idtipo_moneda as 'codigo',
                                                          m.nombre as 'nom'
                                                          FROM tipo_moneda m "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarMonedaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM tipo_moneda");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                /*                 * ******************FIN GRILLA MONEDAS************************** */
                case 'listarClientes':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " where c.idcliente='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " where c.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }
                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT c.idcliente AS 'codigo'
                                                  FROM cliente c "
                            . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT c.idcliente as 'codigo',                                                                                                                  
                                                      c.direccion as 'direccion',
                                                      c.nombre as 'nombre',
                                                      c.num_documento as 'documento',
                                                      c.telefono_fijo as 'telefono',                                                                     
                                                      c.telefono_movil as 'movil',                                                            
                                                      c.correo_electronico as 'correo',                                                            
                                                      IF(c.idtipo_cliente=1, 'NATURAL', 'JURIDICO') as 'tip',                                                             
                                                      c.persona as persona,
                                                      c.lineaCredito,
                                                      IF(c.estadoreg=1, 'ACTIVO', 'NO ACTIVO') as estadoreg
                                               FROM cliente c 
                                               INNER JOIN tipo_cliente t on c.idtipo_cliente=t.idtipo_cliente"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");
                    break;

                case 'listarClientesTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM cliente");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                /*                 * ******************FIN GRILLA CLIENTES************************** */

                /*                 * **************************GRILLA USUSARIOS********************** */
                case 'listarUsuario':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where u.idusuario='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where u.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        u.idusuario AS 'codigo' 

                                                        FROM usuario u

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT u.idusuario as 'codigo',
                                                          u.nombre as 'nombre',
                                                          '********' as 'clave',
                                                          IF(u.estadolog=1, 'SI', 'NO') as 'log',                                                                     
                                                          u.idempleado,                                                            
                                                          IF(u.estadoreg=1, 'ACTIVO', 'NO ACTIVO') as 'estado',                                                            
                                                          p.nombre as 'perfil'
                                                          FROM usuario u 
                                                          INNER JOIN perfil p on u.idperfil=p.idperfil"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarUsuarioTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM usuario");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                /*                 * ******************FIN GRILLA USUARIOS************************** */

                /*                 * ****************************LISTA LA GRILLA DE EMPLEADOS*************************************** */
                case 'listarEmpleado':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where idempleados='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where nombres like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        e.idempleados AS 'codigo' 

                                                        FROM empleados e

                                                        " . $queryBuscar . " ;");


                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            idempleados as 'codigo',

                                                            nombres as 'nombres',

                                                            apellidop as 'apep',

                                                            apellidom as 'apem',
                                                             
                                                            dni,
                                                            
                                                            /*correo,
                                                            
                                                            telfono,
                                                            
                                                            celular,
                                                            
                                                            direccion,*/
                                                                                                                       
                                                            /*cv,*/
                                                            
                                                            IF(estadoreg=1, 'ACTIVO', 'NO ACTIVO') as 'estado',
                                                            
                                                             CONCAT('<img src=\"../Empleados/',imagen,'\" width=\"100\"/>') AS 'imagen'
                                                            
                                                            FROM empleados"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;



                case 'listarEmpleadoTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM empleados");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;
                /*                 * ******************FIN GRILLA EMPLEADOS************************** */

                /*                 * **************************MUESTRA LA GRILLA DE ARTICULOS**************************** */
                case 'listarArticulos':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where a.idarticulo='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where a.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        a.idarticulo AS 'codigo' 

                                                        FROM articulo a

                                                        " . $queryBuscar . " ;");


                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;
                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);
                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }
                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;

                    $salida = $objMysql->ejecutar("SELECT 

                                                            a.idarticulo as 'codigo',

                                                            a.nombre as 'nombre',

                                                            a.codigo as 'cod',
                                                            
                                                            /*a.nro_serie,*/
                                                                
                                                            /*a.precio,*/
                                                            
                                                            format(a.precio_igv,2),

                                                            /*a.stock,                                                
                                                           
                                                            a.stock_min,*/
                                                            
                                                            CONCAT(a.garantia,' ',a.tiempo) as 'garantia',
                                                                                                                                                              
                                                            m.nombre as nom,
                                                            
                                                            /*IF(a.switch_alerta=1,'SI','NO') AS 'switch_alerta',*/
                                                            
                                                            IF(a.estadoreg=1,'ACTIVO','NO ACTIVO') AS 'estado',  
                                                            
                                                            a.cantidad as 'cantidad'
                                                                                                                                                                                                                                
                                                        FROM articulo a
                                                        
                                                        INNER JOIN marca m on a.idmarca=m.idmarca"
                            . $queryBuscar . " and a.estadoreg=1 " . $queryOedenar . " " . $limit . " ;");
                            //CONCAT('<img src=\"../Articulos/',a.imagen,'\" width=\"100\"/>') AS 'imagen'
                    break;

                case 'listarArticulosTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM articulo");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                /*                 * ******************FIN GRILLA ARTICULOS************************** */

                /*                 * ****************** MUESTRA LA GRILLA DE PERFILES ***************** */
                case 'listarPerfiles':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " WHERE idperfil='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " WHERE nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT idperfil,
                                                         nombre 
                                                         FROM perfil  " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR PAGINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA PAGINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;
                    $salida = $objMysql->ejecutar("SELECT idperfil as 'codigo',                            
                                                        nombre as 'nombre',                                                       
                                                        IF(estadoreg=1,'ACTIVO','NO ACTIVO') AS 'estado'                                                        
                                                        FROM perfil "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit);
                    break;

                case 'listarPerfilTot':
                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM perfil");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;
                /*                 * ******************* FIN DE PERFIL *********************** */

                case 'mostrarOptMenu':
                    $salida = $objMysql->ejecutar("select dtm.iddet_menu,dtm.nombre, 
                                                    (select count(*) from perfil_detmenu pdtm where pdtm.idperfil=" . $val1 . " and dtm.iddet_menu=pdtm.iddet_menu ) as 'existe'
                                                    from det_menu dtm where estadoreg=1 order by orden;");

                    break;



                /*                 * ****************** MUESTRA LA GRILLA DE FAMILIAS ***************** */
                case 'listarFamilias':

                    /* --------------------  instrucciones de busqueda ----------------------- */
                    $queryBuscar = "";
                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " WHERE f.idfamilia='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " WHERE f.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT f.idfamilia AS 'codigo'
                                                        FROM familia f " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR PAGINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA PAGINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;

                    $salida = $objMysql->ejecutar("SELECT f.idfamilia as 'codigo',                            
                                                        f.nombre as 'nombre',                                                        
                                                        f.descripcion as 'descripcion',                                                            
                                                        IF(f.estadoreg=1,'ACTIVO','NO ACTIVO') AS 'estado'                                                        
                                                        FROM familia f"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit);
                    break;

                case 'listarFamiliasTot':
                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM familia");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;
                /*                 * ******************* FIN DE FAMILIAS *********************** */

                /*                 * *************************** MUESTRA LA GRILLA DE CATEGORIAS ************************* */
                case 'listarCategorias':

                    /* --------  instrucciones de busqueda ----------------------- */
                    $queryBuscar = "";
                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " WHERE c.idcategoria='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " WHERE c.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT c.idcategoria AS 'codigo' 
                                                         FROM categoria c " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR PAGINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA PAGINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;
                    $salida = $objMysql->ejecutar("SELECT c.idcategoria as 'codigo',                           
                                                        c.nombre as 'nombre',                                                        
                                                        c.descripcion as 'descripcion',                                                        
                                                        f.nombre as 'nombreFamilia',
                                                        IF(c.estadoreg=1,'ACTIVO','NO ACTIVO') AS 'estado'                                                        
                                                        FROM categoria as c                                                        
                                                        LEFT JOIN (familia as f)                                                        
                                                        on c.idfamilia=f.idfamilia"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit);
                    break;

                case 'listarCategoriasTot':
                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM categoria");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;
                /*                 * ************************** FIN DE CATEGORIAS *********************** */

                /*                 * *************************** MUESTRA LA GRILLA DE MARCAS ************************* */
                case 'listarMarcas':

                    /* --------  instrucciones de busqueda ----------------------- */
                    $queryBuscar = "";
                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " WHERE m.idmarca='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " WHERE m.nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */
                    $datos = $objMysql->ejecutar("SELECT m.idmarca AS 'codigo' 
                                                         FROM marca m " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR PAGINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA PAGINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;
                    $salida = $objMysql->ejecutar("SELECT m.idmarca as 'codigo',                            
                                                          m.nombre as 'nombre',                                                        
                                                          m.descripcion as 'descripcion'
                                                          /*CONCAT('<img src=\"../Marca/',m.imagen,'\" width=\"100\"/>') AS 'foto'*/
                                                          FROM marca m"
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit);
                    break;

                case 'listarMarcasTot':
                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM marca");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;

                /*                 * ************************** FIN DE MARCAS *********************** */

                /*                 * *************************** MUESTRA LA GRILLA DE PROVEEDORES ************************* */
                case 'listarProveedores':

                    /* --------  instrucciones de busqueda ----------------------- */
                    $queryBuscar = "";
                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {
                        if ($campoaBuscar == "codigo") {
                            $queryBuscar = " WHERE idproveedores='" . $valoraBuscar . "' ";
                        } else {
                            $queryBuscar = " WHERE nombre like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */
                    $datos = $objMysql->ejecutar("SELECT idproveedores AS 'codigo' 
                                                         FROM proveedores " . $queryBuscar . " ;");

                    //MIRO CUANTOS DATOS FUERON DEVUELTOS
                    $num_rows = $datos->rowCount();

                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR PAGINA , EN EL EJEMPLO PONGO 15
                    $rows_per_page = $mostrarRegistros;
                    $num_page_view = 2;
                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA
                    $lastpage = ceil($num_rows / $rows_per_page);

                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA PAGINA
                    $page = (int) $page;
                    if ($page > $lastpage) {
                        $page = $lastpage;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA
                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;
                    $salida = $objMysql->ejecutar("SELECT idproveedores as 'codigo', 
                                                          nombre,
                                                          IF(tipo_persona=1,'NATURAL','JURIDICA') as persona,
                                                          documento,
                                                          direccion,
                                                          telefono,
                                                          correo,
                                                          web,
                                                          IF(estadoreg=1,'ACTIVO','NO ACTIVO') as estado
                                                          FROM proveedores "
                            . $queryBuscar . "  " . $queryOedenar . " " . $limit);
                    break;

                case 'listarProveedoresTot':
                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM proveedores");
                    $fila = $rs->fetch(PDO::FETCH_ASSOC);
                    $salida = $fila["cant"];
                    break;

                /*                 * ************************** FIN DE PROVEEDORES *********************** */


                case 'listarCarrusel':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE car.idcarrusel='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE car.nom like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        car.idcarrusel AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_carrusel car " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            car.idcarrusel as 'codigo',

                                                            car.nom as 'nombre',

                                                            concat('<img width=100 src=\'../imgs_banner/',car.img,'\'>') as 'imagen',

                                                            car.url as 'url', 

                                                            car.orden as 'orden', 

                                                            IF(car.activo=1,'ACTIVO','NO ACTIVO') AS 'estado' 

                                                            FROM " . DB_PREFIJO . "_carrusel car     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . ";");



                    break;

                case 'listarCarruselTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_carrusel;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                case 'listarBanner':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where b.idbanner ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where b.titulobanner like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT b.idbanner AS 'codigo' FROM " . DB_PREFIJO . "_banner b " . $queryBuscar . " ;");



                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT b.idbanner as 'codigo', b.titulobanner as 'nombre', b.descripcion as 'descripcion', CONCAT('<img src=\"../imgs_banner/',b.direccimag,'\" width=\"80\"/>') AS 'foto', b.url, b.orden, IF(b.mostrado=1,'MOSTRADO','NO MOSTRADO') AS 'estado' FROM " . DB_PREFIJO . "_banner b " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarBannerTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_banner b;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;



                case 'listarPopup':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " where p.idpopup ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " where p.nom like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT p.idpopup AS 'codigo' FROM " . DB_PREFIJO . "_popup p " . $queryBuscar . " ;");



                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            p.idpopup as 'codigo',

                                                            p.nom as 'nombre',

                                                            CONCAT('<img src=\"../imgs_banner/',p.img,'\" width=\"100\"/>') AS 'foto', 

                                                            p.ancho,

                                                            p.alto,

                                                            p.position,

                                                            IF(p.swactivo=1,'ACTIVO','NO ACTIVO') AS 'estado' 

                                                            FROM " . DB_PREFIJO . "_popup p 	     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarPopupTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_popup p;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];

                    break;

                case 'listarVideo':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE v.idvideo ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE v.nomvideo like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                            v.idvideo AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_video v  

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            v.idvideo as 'codigo',

                                                            v.nomvideo as 'nombre',

                                                            v.orden,

                                                            IF(v.activo=1,'ACTIVO','NO ACTIVO') AS 'estado'

                                                            FROM " . DB_PREFIJO . "_video v 	     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarVideoTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_video v;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarCambio':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE c.idvideo ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE c.nomvideo like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        c.idcambio AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_cambiomonetario c

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            c.idcambio as 'codigo',

                                                            c.compra,

                                                            c.venta,

                                                            c.ibvl,

                                                            c.dj,

                                                            c.nikkei

                                                            FROM " . DB_PREFIJO . "_cambiomonetario c	     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarCambioTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_cambiomonetario c;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarGaleria':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE g.idfoto ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE g.titulo like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                            g.idfoto AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_galeria g  

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            g.idfoto as 'codigo',

                                                            g.titulo as 'nombre',

                                                            CONCAT('<img src=\"../imgs_banner/',g.direccimag,'\" width=\"80\"/>') AS 'foto',

                                                            g.descripcion,

                                                            g.fecrea

                                                            FROM " . DB_PREFIJO . "_galeria g	     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarGaleriaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_galeria g;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarProducto':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE g.idproducto ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE g.nomproducto like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                            g.idproducto AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_producto g  

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            g.idproducto as 'codigo',

                                                            g.nomproducto as 'nombre',

															c.nomcategoria,

															g.stock,

															g.precio,

                                                            g.orden,

															if(g.activo=1,'ACTIVO', 'NO ACTIVO'),

															if(g.destacado=1,'DESTACADO', 'NO DESTACADO')                                                            

                                                            FROM " . DB_PREFIJO . "_producto g	     

															INNER JOIN " . DB_PREFIJO . "_categoria c

															on c.idcategoria=g.idcategoria

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarProductoTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_producto g;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarArchivos':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE a.idarchivo ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE a.titulo like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                            a.idarchivo AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_archivos a 

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            a.idarchivo as 'codigo',

                                                            a.titulo as 'titulo',

                                                            a.direccimag,

                                                            a.descripcion,

                                                            IF(a.mostrar=1,'ACTIVO','NO ACTIVO') AS 'estado'

                                                            FROM " . DB_PREFIJO . "_archivos a	     

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarArchivosTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_archivos a;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarDatos':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE d.idconfig ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE d.correo like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT 

                                                        d.idconfig AS 'codigo' 

                                                        FROM " . DB_PREFIJO . "_datos d  

                                                        " . $queryBuscar . " ;");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT 

                                                            d.idconfig as 'codigo',

                                                            d.nomsite as 'nom',

                                                            d.correo as 'correo', 

                                                            CONCAT('<img src=\"../imgs_banner/',d.ico,'\" width=\"80\"/>') AS 'Ico', 

                                                            CONCAT('<img src=\"../imgs_banner/',d.logo,'\" width=\"80\"/>') AS 'Logo', 

                                                            CONCAT('<img src=\"../imgs_banner/',d.imgtelf,'\" width=\"80\"/>') AS 'Img' 

                                                            FROM " . DB_PREFIJO . "_datos d	     

                                                            " . $queryOedenar . " " . $limit . " ;");

                    break;

                case 'listarDatosTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_datos d;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarMenu':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "WHERE 1=1";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = "WHERE m.idmenu ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = "WHERE m.nommenu like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT m.idmenu AS 'codigo',

                                                             m.nommenu AS 'titulo',

                                                             IF(m.mostrar=1,'ACTIVO','NO ACTIVO') AS 'estado',

															 m.orden

                                                             FROM " . DB_PREFIJO . "_menu m

                                                             " . $queryBuscar . "  " . $queryOedenar . ";");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT m.idmenu AS 'codigo',

                                                             m.nommenu AS 'titulo',

                                                             IF(m.mostrar=1,'ACTIVO','NO ACTIVO') AS 'estado',

															 m.orden

                                                             FROM " . DB_PREFIJO . "_menu m

                                                             " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarMenuTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_menu;");

                    //".$queryBuscar."  ".$queryOedenar." ;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarPagina':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "WHERE p.tipo=1";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = "WHERE p.tipo=1 AND p.idpaginaweb ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = "WHERE p.tipo=1 AND p.titulopagweb like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT p.idpaginaweb AS 'codigo',

                                                             p.titulopagweb AS 'titulo',

                                                             IF(p.tipo=1,'PAGINA','NOTICIA') AS 'tipo', 

                                                             p.descriptag AS 'tag', 

                                                             IF(p.activo=1,'ACTIVO','NO ACTIVO') AS 'estado'

                                                             FROM " . DB_PREFIJO . "_pagina p

                                                             " . $queryBuscar . "  " . $queryOedenar . ";");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT p.idpaginaweb AS 'codigo',p.titulopagweb AS 'titulo', IF(p.tipo=1,'PAGINA','NOTICIA') AS 'tipo', p.descriptag AS 'tag',IF(p.activo=0,'NO ACTIVO','ACTIVO') AS 'estado' " .
                            "FROM " . DB_PREFIJO . "_pagina p  

                                                                    " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarPaginaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_pagina p WHERE tipo=1;");

                    //".$queryBuscar."  ".$queryOedenar." ;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarNoticia':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "WHERE p.tipo=2";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " WHERE p.tipo=2 AND p.idpaginaweb ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " WHERE p.tipo=2 AND p.titulopagweb like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT p.idpaginaweb AS 'codigo',

                                                             p.titulopagweb AS 'titulo',

                                                             IF(p.tipo=1,'PAGINA','NOTICIA') AS 'tipo', 

                                                             p.descriptag AS 'tag', 

                                                             IF(p.activo=1,'ACTIVO','NO ACTIVO') AS 'estado'

                                                             FROM " . DB_PREFIJO . "_pagina p

                                                            " . $queryBuscar . "  " . $queryOedenar . ";");



                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT p.idpaginaweb AS 'codigo',p.titulopagweb AS 'titulo', IF(p.tipo=1,'PAGINA','NOTICIA') AS 'tipo', p.descriptag AS 'tag',IF(p.activo=0,'NO ACTIVO','ACTIVO') AS 'estado' " .
                            "FROM " . DB_PREFIJO . "_pagina p  

                                                                    " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarNoticiaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_pagina p WHERE tipo=2;");

                    //".$queryBuscar."  ".$queryOedenar." ;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarClase':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " and c.idclase ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " and c.nomclase like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT c.idclase as 'codigo',c.nomclase,m.nommenu, IF(c.activo=0,'ELIMINADO','ACTIVO') AS 'estado', c.orden FROM " . DB_PREFIJO . "_clase c

															 inner join " . DB_PREFIJO . "_menu m

															 on m.idmenu=c.idmenu

                                                            " . $queryBuscar . "  " . $queryOedenar . ";");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT c.idclase as 'codigo',c.nomclase,m.nommenu, IF(c.activo=0,'ELIMINADO','ACTIVO') AS 'estado', c.orden FROM " . DB_PREFIJO . "_clase c

															 inner join " . DB_PREFIJO . "_menu m

															 on m.idmenu=c.idmenu

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarClaseTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_clase c");

                    //".$queryBuscar."  ".$queryOedenar." ;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'listarCategoria':

                    /* --------  instrucciones de busqueda ----------------------- */

                    $queryBuscar = "";

                    if (!empty($campoaBuscar) && !empty($valoraBuscar)) {

                        if ($campoaBuscar == "codigo") {

                            $queryBuscar = " and c.idcategoria ='" . $valoraBuscar . "' ";
                        } else {

                            $queryBuscar = " and c.nomcategoria like '" . $valoraBuscar . "%' ";
                        }
                    }

                    /* -------------------------------------- */

                    $datos = $objMysql->ejecutar("SELECT c.idcategoria as 'codigo',c.nomcategoria,cl.nomclase, IF(c.activo=0,'ELIMINADO','ACTIVO') AS 'estado', c.orden FROM " . DB_PREFIJO . "_categoria c

															 inner join " . DB_PREFIJO . "_clase cl

															 on cl.idclase=c.idclase

                                                            " . $queryBuscar . "  " . $queryOedenar . ";");





                    //MIRO CUANTOS DATOS FUERON DEVUELTOS

                    $num_rows = $datos->rowCount();



                    //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

                    $rows_per_page = $mostrarRegistros;

                    $num_page_view = 2;

                    $num_page_next = 1;

                    //CALCULO LA ULTIMA P?GINA

                    $lastpage = ceil($num_rows / $rows_per_page);



                    //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA

                    $page = (int) $page;

                    if ($page > $lastpage) {

                        $page = $lastpage;
                    }

                    if ($page < 1) {

                        $page = 1;
                    }



                    //CREO LA SENTENCIA LIMIT PARA A?ADIR A LA CONSULTA QUE DEFINITIVA

                    $limit = " LIMIT " . ($page - 1) * $rows_per_page . ',' . $rows_per_page;



                    $salida = $objMysql->ejecutar("SELECT c.idcategoria as 'codigo',c.nomcategoria,cl.nomclase, IF(c.activo=0,'ELIMINADO','ACTIVO') AS 'estado', c.orden FROM " . DB_PREFIJO . "_categoria c

															 inner join " . DB_PREFIJO . "_clase cl

															 on cl.idclase=c.idclase

                                                            " . $queryBuscar . "  " . $queryOedenar . " " . $limit . " ;");



                    break;

                case 'listarCategoriaTot':

                    $rs = $objMysql->ejecutar("SELECT count(*) as 'cant' FROM " . DB_PREFIJO . "_categoria c");

                    //".$queryBuscar."  ".$queryOedenar." ;");

                    $fila = $rs->fetch(PDO::FETCH_ASSOC);

                    $salida = $fila["cant"];



                    break;

                case 'f_clase':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_clase c where c.idclase='" . $val1 . "' and c.activo=1");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;


                case 'f_pagina':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_pagina c where c.idpaginaweb='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_producto':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_producto c where c.idproducto='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_menu':

                    $rs = $objMysql->ejecutar("SELECT * FROM menu m where m.idmenu='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_archivos':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_archivos a where a.idarchivo='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_banner':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_banner b where b.idbanner='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_popup':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_popup p where p.idpopup='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_datos':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_datos d where d.idconfig='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_carrusel':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_carrusel car where car.idcarrusel='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_cambio':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_cambiomonetario c where c.idcambio='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_galeria':

                    $rs = $objMysql->ejecutar("SELECT * FROM " . DB_PREFIJO . "_galeria g where g.idfoto='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_perfil':

                    $rs = $objMysql->ejecutar("SELECT * FROM perfil where idperfil='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                /*                 * **********************UPDFamilias************************* */
                case 'f_familia':

                    $rs = $objMysql->ejecutar("SELECT * FROM familia where idfamilia='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * ******************************************************************** */

                /*                 * *********************** UPDCategorias **************************** */
                case 'f_categoria':

                    $rs = $objMysql->ejecutar("SELECT * FROM categoria c where c.idcategoria='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * ************************************************************************** */

                /*                 * *********************** UPDMarcas **************************** */
                case 'f_marcas':
                    $rs = $objMysql->ejecutar("SELECT idmarca,nombre,descripcion,imagen FROM marca where idmarca='" . $val1 . "'");
                    $salida = $rs->fetch(PDO::FETCH_ASSOC);
                    break;
                /*                 * ************************************************************************** */

                /*                 * *********************** UPDPerfiles **************************** */
                case 'f_perfiles':

                    $rs = $objMysql->ejecutar("SELECT idperfil,nombre,estadoreg FROM perfil where idperfil='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                /*                 * ************************************************************************** */

                /*                 * *********************** UPDProveedores **************************** */
                case 'f_proveedor':

                    $rs = $objMysql->ejecutar("SELECT * FROM proveedores where idproveedores='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                //------UBIGEO------//
                case 'f_dpto_pro':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.coddpto,s.coddpto FROM ubigeo s,proveedores p where p.coddpto=s.coddpto and s.codprov='00' and s.coddist='00' and idproveedores='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_prov_pro':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.codprov,s.codprov FROM ubigeo s,proveedores p where p.coddpto=s.coddpto and s.codprov=p.codprov and s.coddist='00' and idproveedores='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_dist_pro':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.coddist,s.coddist FROM ubigeo s,proveedores p where p.coddpto=s.coddpto and s.codprov=p.codprov and s.coddist=p.coddist and idproveedores='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;


                /*                 * ************************************************************************** */
                case 'f_ckeckbox':

                    $rs = $objMysql->ejecutar("SELECT pm.iddetallemenu FROM " . DB_PREFIJO . "_perfilmenu pm where pm.idperfil='" . $val1 . "';");

                    //echo "SELECT pm.iddetallemenu FROM ".DB_PREFIJO."_perfilmenu pm where pm.idperfil='".$val1."';";

                    $salida = $rs;

                    //$salida=$rs->rowCount();
                    // $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;


                case 'f_clientes':

                    $rs = $objMysql->ejecutar("SELECT coddpto,codprov,coddist,idcliente,nombre,direccion,num_documento,telefono_fijo,telefono_movil,correo_electronico,idtipo_cliente,persona,estadoreg,lineaCredito,monedaCredito,credito FROM cliente c where c.idcliente='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                //------UBIGEO------//
                case 'f_dpto_cl':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.coddpto,s.coddpto FROM ubigeo s,cliente p where p.coddpto=s.coddpto and s.codprov='00' and s.coddist='00' and idcliente='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_prov_cl':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.codprov,s.codprov FROM ubigeo s,cliente p where p.coddpto=s.coddpto and s.codprov=p.codprov and s.coddist='00' and idcliente='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_dist_cl':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,p.coddist,s.coddist FROM ubigeo s,cliente p where p.coddpto=s.coddpto and s.codprov=p.codprov and s.coddist=p.coddist and idcliente='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_usuario':

                    $rs = $objMysql->ejecutar("SELECT idusuario,nombre,aes_decrypt(clave,'llave1') as clave,estadoreg,estadolog,idperfil,idempleado FROM usuario u where u.idusuario='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                case 'cambio_clave':

                    $rs = $objMysql->ejecutar("SELECT idusuario,nombre,aes_decrypt(clave,'llave1') as clave,estadoreg,estadolog,idperfil,idempleado FROM usuario u where u.nombre='" . $_SESSION["username"] . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * ********************EMPLEADOS******************* */
                case 'f_empleado':

                    $rs = $objMysql->ejecutar("SELECT p.nombre,p.idperfil,e.idcargo,e.idempleados,e.apellidop,e.apellidom,e.nombres,e.dni,e.correo,e.telfono,e.celular,e.direccion,e.imagen,e.cv,e.estadoreg,u.nombre,aes_decrypt(u.clave,'llave1') as clave FROM empleados e, usuario u, perfil p where u.idempleado=e.idempleados and p.idperfil=u.idperfil and idempleados='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                //------UBIGEO------//
                case 'f_dpto':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,e.coddpto,s.coddpto FROM ubigeo s,empleados e where e.coddpto=s.coddpto and s.codprov='00' and s.coddist='00' and idempleados='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_prov':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,e.codprov,s.codprov FROM ubigeo s,empleados e where e.coddpto=s.coddpto and s.codprov=e.codprov and s.coddist='00' and idempleados='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_dist':

                    $rs = $objMysql->ejecutar("select s.nombre as nom,e.coddist,s.coddist FROM ubigeo s,empleados e where e.coddpto=s.coddpto and s.codprov=e.codprov and s.coddist=e.coddist and idempleados='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                /*                 * ***************FIN EMPLEADOS**************** */

                /*                 * *******************************ARTICULOS***************************** */
                case 'f_articulo':

                    $rs = $objMysql->ejecutar("SELECT * FROM articulo where idarticulo='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_motivonota':

                    $rs = $objMysql->ejecutar("SELECT * FROM nota_credito where idnotacredito='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;

                case 'f_serie_articulo':

                    $rs = $objMysql->ejecutar("SELECT nro_serie FROM serie where idarticulo='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);


                    break;

                /*                 * ****************FIN ARTICULOS***************************** */

                /*                 * **************************** MONEDA ************************ */
                case 'f_moneda':

                    $rs = $objMysql->ejecutar("SELECT * FROM tipo_moneda where idtipo_moneda='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * **************************** FIN MONEDA ****************************** */

                /*                 * **************************** TIPOCAMBIO ************************ */
                case 'f_tipocambio':

                    $rs = $objMysql->ejecutar("SELECT t.idtipo_cambio as id,m.nombre,t.fecha,t.compra,t.venta,t.promedio,t.idtipo_moneda 
                                               FROM tipo_cambio as t
                                               LEFT JOIN(tipo_moneda as m)
                                               ON t.idtipo_moneda=m.idtipo_moneda
                                               WHERE idtipo_cambio='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * **************************** FIN TIPOCAMBIO ****************************** */


                /*                 * ********************************* SERIE ********************************* */
                case 'f_serie':

                    $rs = $objMysql->ejecutar("SELECT * FROM serie where idserie='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * ********************************** FIN SERIE ********************************* */
                /*                 * ******************** TARJETAS ******************* */
                case 'f_tarjeta':

                    $rs = $objMysql->ejecutar("SELECT * FROM tarjetas_credito where idtarjetas_credito='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * *********************FIN TARJETAS********************* */
                /*                 * ******************** BANCOS ******************* */
                case 'f_banco':

                    $rs = $objMysql->ejecutar("SELECT idbanco,nombres FROM banco where idbanco='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * *********************FIN BANCOS********************* */
                /*                 * ****************FORMAS DE PAGO****************************** */
                case 'f_pago':

                    $rs = $objMysql->ejecutar("SELECT idcondicionPago,condicion FROM condicionpago where idcondicionPago='" . $val1 . "'");

                    $salida = $rs->fetch(PDO::FETCH_ASSOC);

                    break;
                /*                 * ****************FIN FORMAS DE PAGO***************************** */
            }
        } catch (Exception $exc) {

            $salida = $exc->getTraceAsString();
        }

        return $salida;
    }

    public static function getGrillaHorario(array $vParam) {

        $objMysql = new Mysql();

        $tablaHTML = NULL;

        $dias = NULL;

        if (!empty($vParam)) {

            $nIdHorario = $vParam[0];







            $swflexible = $objMysql->getFila("SELECT swflexible FROM " . DB_PREFIJO . "_horario WHERE idhorario='" . $nIdHorario . "' AND swactivo=1;");



            $dias = $objMysql->consulta("SELECT hd.idhorariodia,hd.dia AS 'iddia',d.dia FROM " . DB_PREFIJO . "_horariodia hd

                                            LEFT JOIN " . DB_PREFIJO . "_dia d ON hd.dia=d.iddia

                                            WHERE hd.idhorario='" . $nIdHorario . "';");



            $horas = $objMysql->consulta("SELECT hh.idhorariohora,hh.hora_ini,DATE_FORMAT(h.hora,'%h:%i'),hh.hora_fin,DATE_FORMAT(h2.hora,'%h:%i'),hh.frecu_fin,UPPER(f.nombre) AS 'nombre' FROM " . DB_PREFIJO . "_horariohora hh

                                            LEFT JOIN " . DB_PREFIJO . "_hora h ON hh.hora_ini=h.idhora

                                            LEFT JOIN " . DB_PREFIJO . "_hora h2 ON hh.hora_fin=h2.idhora

                                            LEFT JOIN " . DB_PREFIJO . "_frecuencia f ON hh.frecu_fin=f.idfrecuencia

                                            WHERE hh.idhorario='" . $nIdHorario . "' AND hh.swactivo=1;");



            if ($nIdHorario == "vacio") {



                $swflexible = 0;

                $dias = array("", "", "", "", "", "", "");

                $horas = array("", "", "", "");
            }



            $tablaHTML .= "<input type=\"hidden\" name=\"swFlex\" id=\"swFlex\" value=\"" . $swflexible[0] . "\" />";

            $tablaHTML .= "<table border=\"1\" id=\"tblHorario\">";

            $tablaHTML .= "<tr>"; /* 1ER FILA */

            $tablaHTML .= "<th class=\"label\">N°</th>";

            $tablaHTML .= "<th class=\"label\" width=\"40%\">Hora / Dia</th>";

            for ($i = 1; $i < count($dias); $i++) {

                $tablaHTML .= "<th>" . utf8_encode($dias[$i][2]) . "</th>";
            }

            $tablaHTML .= "</tr>"; /* FIN 1ER FILA */

            for ($j = 1; $j < count($horas); $j++) {// numero de horas programadas
                $tablaHTML .= "<tr>"; /* 2DA N FILA */

                $tablaHTML .= "<th width=\"5%\">" . $j . "</th>"; /* 1ER COLUMNA */

                $tablaHTML .= "<td width=\"65%\">"; /* 2DA COLUMNA */

                $tablaHTML .= "<div style=\"text-align:center;\">";

                if ($swflexible[0]) {

                    $tablaHTML .= "<select name=\"cmbHoraIni[]\" id=\"cmbHoraIni\" class=\"cmbHora\">";

                    $tablaHTML .= "<option value=\"0\" selected>---</option>";

                    $tablaHTML .= self::getCombo("horas", $vValores, $horas[$j][1]);

                    $tablaHTML .= "</select>";

                    $tablaHTML .= "a";

                    $tablaHTML .= "<select name=\"cmbHoraFin[]\" id=\"cmbHoraFin\" class=\"cmbHora\">";

                    $tablaHTML .= "<option value=\"0\" selected>---</option>";

                    $tablaHTML .= self::getCombo("horas", $vValores, $horas[$j][3]);

                    $tablaHTML .= "</select>";

                    $tablaHTML .= ":";

                    $tablaHTML .= "<select name=\"cmbHoraFrec[]\" id=\"cmbHoraFrec\" class=\"cmbHora\">";

                    $tablaHTML .= "<option value=\"0\" selected>---</option>";

                    $tablaHTML .= self::getCombo("frecuencia", $vValores, $horas[$j][5]);

                    $tablaHTML .= "</select>";
                } else {

                    if ($nIdHorario != "vacio") {

                        $tablaHTML .= "<div style=\"font-family:sans-serif; font-size: 14pt;font-weight: bold;\">";

                        $tablaHTML .= $horas[$j][2] . " a " . $horas[$j][4] . " : " . $horas[$j][6];

                        $tablaHTML .= "<input type=\"hidden\" name=\"oIdHoraIni[]\" id=\"oIdHoraIni\" value=\"" . $horas[$j][1] . "\" />";

                        $tablaHTML .= "<input type=\"hidden\" name=\"oIdHoraFin[]\" id=\"oIdHoraFin\" value=\"" . $horas[$j][3] . "\" />";

                        $tablaHTML .= "<input type=\"hidden\" name=\"oIdFrecuencia[]\" id=\"oIdFrecuencia\" value=\"" . $horas[$j][5] . "\" />";

                        $tablaHTML .= "</div>";
                    }
                }

                $tablaHTML .= "</div>";

                $tablaHTML .= "</td>"; /* FIN 2DA COLUMNA */



                for ($g = 1; $g < count($dias); $g++) {



                    $tablaHTML .= "<td align=\"center\">"; /* 3RA N COLUMNA */

                    if ($nIdHorario != "vacio") {

                        $tablaHTML .= "<div id=\"btnCheck_" . $j . "_" . $dias[$g][1] . "\" onclick=\"seleccionar(" . $j . "," . $dias[$g][1] . ")\" style=\"background-image:url(../_img/Unchecked.png); width:80px; height:40px;cursor:pointer;\">";

                        $tablaHTML .= "<input type=\"checkbox\" name=\"chkDia[]\" id=\"chkDia_" . $j . "_" . $dias[$g][1] . "\" value=\"" . $j . "_" . $dias[$g][1] . "\" style=\"display: none;\" />";

                        $tablaHTML .= "</div>";
                    } else {

                        $tablaHTML .= "<div style=\"width:80px; height:40px;\">";

                        $tablaHTML .= "</div>";
                    }

                    $tablaHTML .= "</td>";
                }



                $tablaHTML .= "</tr>"; /* FIN 2DA N FILA */
            }

            $tablaHTML .= "</table>";
        }

        return $tablaHTML;
    }
    
    
    
//    $cantidad_ventas = "SELECT sum(cantidad) as cantidad_ventas from ventaslinea WHERE vendido > 0 and idarticulo=" . $res['idarticulo'] . " and impreso_con_guia=0;";
//    $cantidad_ventas = $objMysql->ejecutar($cantidad_ventas);
//    $cantidad_ventas = $cantidad_ventas->fetch(PDO::FETCH_ASSOC);
//    $cantidad_ventas = $cantidad_ventas['cantidad_ventas'];

    function UPDStock() {
        $objMysql = new Mysql();
        $cantidad = 'SELECT COUNT(idarticulo) as cont FROM articulo WHERE idarticulo<>5';
        $resp = $objMysql->ejecutar($cantidad);
        $cant = $resp->fetch(PDO::FETCH_ASSOC);
        $cant = $cant['cont'];
        if ($cant > 0) {
            $consulta = 'SELECT idarticulo FROM articulo WHERE idarticulo<>5';
            $ret = $objMysql->ejecutar($consulta);
            while ($res = $ret->fetch(PDO::FETCH_ASSOC)) {
                $cantidad_compras = 'SELECT sum(cantidad) as cantidad_compras from compraslinea WHERE comprado > 0 and idarticulo=' . $res['idarticulo'] . "";
                $cantidad_compras = $objMysql->ejecutar($cantidad_compras);
                $cantidad_compras = $cantidad_compras->fetch(PDO::FETCH_ASSOC);
                $cantidad_compras = $cantidad_compras['cantidad_compras'];                
                
                $cantidad_ventas="select sum(vl.cantidad) as cantidad_ventas
                from ventaslinea vl
                left join ventas v on v.id_ventas = vl.id_ventas
                where vl.idarticulo = " . $res['idarticulo'] . " and v.id_ventas > 0 and impreso_con_guia=0 ;";
                $cantidad_ventas = $objMysql->ejecutar($cantidad_ventas);
                $cantidad_ventas = $cantidad_ventas->fetch(PDO::FETCH_ASSOC);
                $cantidad_ventas = $cantidad_ventas['cantidad_ventas'];
                

                $cantidad_guia = "SELECT sum(cantidad) as cantidad_guia from guialinea gl,guia g WHERE g.idguia=gl.idguia and g.estado='activo' and gl.guiado > 0 and gl.idarticulo=" . $res['idarticulo'] . ";";
                $cantidad_guia = $objMysql->ejecutar($cantidad_guia);
                $cantidad_guia = $cantidad_guia->fetch(PDO::FETCH_ASSOC);
                $cantidad_guia = $cantidad_guia['cantidad_guia'];

                $cantidad_devuelto = 'SELECT count(1) as cantidad_nota FROM nota_creditolinea WHERE mostrar_stock=1 AND id_articulo=' . $res['idarticulo'] . ";";
                $cantidad_devuelto = $objMysql->ejecutar($cantidad_devuelto);
                $cantidad_devuelto = $cantidad_devuelto->fetch(PDO::FETCH_ASSOC);
                $cantidad_devuelto = $cantidad_devuelto['cantidad_nota'];

                $cantidad_salidas = 'SELECT count(1) as cantidad_salidas FROM salidas WHERE idarticulo=' . $res['idarticulo'] . ";";
                $cantidad_salidas = $objMysql->ejecutar($cantidad_salidas);
                $cantidad_salidas = $cantidad_salidas->fetch(PDO::FETCH_ASSOC);
                $cantidad_salidas = $cantidad_salidas['cantidad_salidas'];

                $consulta = "UPDATE articulo SET cantidad = ('$cantidad_compras' + '$cantidad_devuelto') - ('$cantidad_ventas' + '$cantidad_guia' + '$cantidad_salidas') WHERE idarticulo=" . $res['idarticulo'];
                $consulta = $objMysql->ejecutar($consulta);
            }
        }
    }

}

?>