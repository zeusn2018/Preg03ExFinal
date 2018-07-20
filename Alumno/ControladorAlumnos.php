<?php

header('Cache-Control: no-cache');
header('Pragma: no-cache');
include("../util/Sesion.php");
$objSesion = new Sesion();
$valses = $objSesion->getVariableSession("username");
if (!isset($valses)) {
    echo "<script>window.location='../login/logout.php';</script>";
}
/* * ******************************SUBIR IMAGEN******************************** */
if ($_REQUEST["param"] == "ejecutar") {
//comprobamos que sea una petición ajax
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //obtenemos el archivo a subir
        $file = $_FILES['archivo']['name'];
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if (!is_dir("archivos/"))
            mkdir("archivos/", 0777);
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'], "archivos/" . $file)) {
            sleep(1); //retrasamos la petición 3 segundos
            //echo $file;      
        }
    }
}

/* * *************************************************************************** */
if (!empty($_POST["accion"])) {
    if (isset($_POST["txhId"]))
        $nId = $_POST["txhId"];
    else
        $nId = "";
    if (isset($_POST["nombre"]))
        $S_nombre = $_POST["nombre"];
    else
        $S_nombre = "";
    if (isset($_POST["descripcion"]))
        $S_descripcion = $_POST["descripcion"];
    else
        $S_descripcion = "";
    if (isset($_POST["codigo"]))
        $S_codigo = $_POST["codigo"];
    else
        $S_codigo = "";
    if (isset($_POST["stock"]))
        $S_stock = $_POST["stock"];
    else
        $S_stock = "";
    if (isset($_POST["precio"]))
        $S_precio = $_POST["precio"];
    else
        $S_precio = "";
    if (isset($_POST["stock_min"]))
        $S_stock_min = $_POST["stock_min"];
    else
        $S_stock_min = "";
    if (isset($_POST["garantia"]))
        $S_garantia = $_POST["garantia"];
    else
        $S_garantia = "";
    if (isset($_POST["switch_alerta"]))
        $S_switch_alerta = $_POST["switch_alerta"];
    else
        $S_switch_alerta = "";
    if (isset($_POST["precio_igv"]))
        $S_precio_igv = $_POST["precio_igv"];
    else
        $S_precio_igv = "";
    if (isset($_POST["marca"]))
        $S_marca = $_POST["marca"];
    else
        $S_marca = "";
    if (isset($_POST["estado"]))
        $S_estado = $_POST["estado"];
    else
        $S_estado = "";
    if (isset($_POST["imagen"]))
        $S_imagen = $_POST["imagen"];
    else
        $S_imagen = "";
    if (isset($_POST["tiempo"]))
        $S_tiempo = $_POST["tiempo"];
    else
        $S_tiempo = "";
    if (isset($_POST["precio_venta"]))
        $S_precio_venta = $_POST["precio_venta"];
    else
        $S_precio_venta = "";
    if (isset($_POST["tipo_moneda"]))
        $S_tipomoneda = $_POST["tipo_moneda"];
    else
        $S_tipomoneda = "";
    if (isset($_POST["categoria"]))
        $categoria = $_POST["categoria"];
    else
        $categoria = "";
    if (isset($_POST["und_medida"]))
        $und_medida = $_POST["und_medida"];
    else
        $und_medida = "";
    if (isset($_POST["prec_caja"]))
        $prec_caja = $_POST["prec_caja"];
    else
        $prec_caja = "";
    if (isset($_POST["und_caja"]))
        $und_caja = $_POST["und_caja"];
    else
        $und_caja = "";
    include("DAOArticulos.php");
    $objArticuloEntidad = new EntidadArticulos();
    $objArticuloEntidad->setUnd_medida($und_medida);
    $objArticuloEntidad->setPrec_caja($prec_caja);
    $objArticuloEntidad->setUnd_caja($und_caja);
    $objArticuloEntidad->setParametro($_REQUEST['param']);
    $objArticuloEntidad->setIdarticulo($nId);
    $objArticuloEntidad->setNombre($S_nombre);
    $objArticuloEntidad->setDescripcion($S_descripcion);
    $objArticuloEntidad->setCodigo($S_codigo);
    $objArticuloEntidad->setStock($S_stock);
    $objArticuloEntidad->setPrecio($S_precio);
    $objArticuloEntidad->setImagen("archivos/" . substr($S_imagen, 13));
    $objArticuloEntidad->setStockmin($S_stock_min);
    $objArticuloEntidad->setGarantia($S_garantia);
    $objArticuloEntidad->setSwitch($S_switch_alerta);
    $objArticuloEntidad->setPrecioigv($S_precio_igv);
    $objArticuloEntidad->setMarca($S_marca);
    $objArticuloEntidad->setEstado($S_estado);
    $objArticuloEntidad->setCantidad($_POST['cantidad']);
    $objArticuloEntidad->setNroserie($_POST['campo2']);
    $objArticuloEntidad->setTiempo($S_tiempo);
    $objArticuloEntidad->setPrecio_venta($S_precio_venta);
    $objArticuloEntidad->setTipomoneda($S_tipomoneda);
    $objArticuloEntidad->setCategoria($categoria);

    if ($_POST["accion"] == 'DEL_LOG') {
        if (DAOArticulos::mantenimientoArticulos($objArticuloEntidad, array($_POST["accion"])) == 1) {
            echo "1";
        } elseif (DAOArticulos::mantenimientoArticulos($objArticuloEntidad, array($_POST["accion"])) == 2) {
            echo "2";
        } else {
            echo "0";
        }
    } else {
        if ($_REQUEST["param"] != "ejecutar") { //para que no entre cuando mando la imagen
            if (DAOArticulos::mantenimientoArticulos($objArticuloEntidad, array($_POST["accion"]))) {
                echo DAOArticulos::UltimoId($objArticuloEntidad, array($_POST["accion"]));
            } else {
                echo "error";
            }
        }
    }
}
?>