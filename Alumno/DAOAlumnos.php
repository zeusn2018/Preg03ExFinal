<?php


include("EntidadAlumnos.php");
//include("../util/Mysql.php");

class DAOAlumnos {
    
    
    public static function Total_Beca(EntidadAlumnos $objAlumnosEntidad, array $param) {
        if ($param[0] == "INS") {
            $consulta = NULL;
            $salida = NULL;
            $objMysql = new Mysql();

            try {
                $codigo = $objAlumnosEntidad->getCodigo();
                $consulta = "SELECT max(a.idarticulo) as 'idarticulo',cm.ventaigv_soles "
                        . "FROM articulo a,conversion_moneda cm "
                        . "WHERE a.estadoreg=1 and cm.idarticulo=a.idarticulo "
                        . "group by a.idarticulo order by a.idarticulo desc limit 0,1;";
                $res = $objMysql->ejecutar($consulta);
                $reg = $res->fetch(PDO::FETCH_ASSOC);
                $salida = $reg['idarticulo'] . "," . $reg['ventaigv_soles'];
            } catch (PDOException $exc) {
                $salida = 0;
            }
            return $salida;
        }
    }
    


    public static function mantenimientoAlumnos(EntidadArticulos $objArticuloEntidad, array $param) {
        $query = NULL;
        $error = NULL;
        $objMysql = new Mysql();
        $objMysql2 = new Mysql();
        try {
            if ($param[0] != 'DEL_LOG') {
                /*                 * **************Remmplazo las comillas dobles por espacio***************** */
                $nom = str_replace('"', "", eregi_replace("[\n|\r|\n\r]", " ", $objArticuloEntidad->getNombre()));
                $descrip = str_replace('"', "", eregi_replace("[\n|\r|\n\r]", " ", $objArticuloEntidad->getDescripcion()));
                /*                 * *******************Elimino los espacios en blanco de más************************** */
                $cadena = ereg_replace("([ ]+)", "-", $nom);
                $nomb = explode("-", $cadena);
                for ($i = 0; $i <= count($nomb); $i++) {
                    $nombr .= $nomb[$i] . " ";
                }
                /*                 * ********************************************* */
                $cadena2 = ereg_replace("([ ]+)", "-", $descrip);
                $desc = explode("-", $cadena2);
                for ($i = 0; $i <= count($desc); $i++) {
                    $descripcio .= $desc[$i] . " ";
                }
                $nombre = str_replace("'", "", $nombr);
                $descripcion = str_replace("'", "", $descripcio);
                /*                 * *******************Fin************************** */
                if ($param[0] == 'UPD') {


                    $query_verificar = "select count(*) as cantidad "
                            . "from articulo "
                            . "where estadoreg=1 and idarticulo<>" . $objArticuloEntidad->getIdarticulo() . " "
                            . "and (REPLACE(nombre,' ','')='" . str_replace(' ', '', $nombre) . "' or (codigo='".$objArticuloEntidad->getCodigo()."' AND codigo!=''))";
                    $res_verificar = $objMysql->ejecutar($query_verificar);
                    $reg = $res_verificar->fetch(PDO::FETCH_ASSOC);

                    if ($reg['cantidad'] == 0) {
                        $query = "CALL sp_mnt_alumnos('" . $param[0] . "',    
                                           '" . $objArticuloEntidad->getIdarticulo() . "',
                                           '" . trim($nombre) . "',
                                           '" . trim($descripcion) . "',
                                           '" . $objArticuloEntidad->getCodigo() . "',
                                           '" . $objArticuloEntidad->getStock() . "',
                                           '" . $objArticuloEntidad->getPrecio() . "',
                                           '" . $objArticuloEntidad->getImagen() . "',
                                           '" . $objArticuloEntidad->getStockmin() . "',
                                           '" . $objArticuloEntidad->getGarantia() . "',
                                           '" . $objArticuloEntidad->getTiempo() . "',
                                           '" . $objArticuloEntidad->getSwitch() . "',
                                           '" . $objArticuloEntidad->getPrecioigv() . "',
                                           '" . $objArticuloEntidad->getMarca() . "',
                                           '" . $objArticuloEntidad->getCantidad() . "',
                                           '" . $objArticuloEntidad->getEstado() . "',
                                           '" . $objArticuloEntidad->getPrecio_venta() . "',
                                           '" . $objArticuloEntidad->getTipomoneda() . "',
                                           '" . $objArticuloEntidad->getCategoria() . "',
                                           '" . $objArticuloEntidad->getPrec_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_medida() . "')";
                        $objMysql->ejecutar($query);
                        $error = 1;
                    }
                } else {
                    $query_verificar = "select count(*) as cantidad "
                            . "from articulo "
                            . "where estadoreg=1 and (REPLACE(nombre,' ','')='" . str_replace(' ', '', $nombre) . "' or (codigo='".$objArticuloEntidad->getCodigo()."' AND codigo!=''))";
                    $res_verificar = $objMysql->ejecutar($query_verificar);
                    $reg = $res_verificar->fetch(PDO::FETCH_ASSOC);
                    if ($reg['cantidad'] == 0) {
                        $query7 = "CALL sp_mnt_alumnos('" . $param[0] . "',    
                                           '" . $objArticuloEntidad->getIdarticulo() . "',
                                           '" . trim($nombre) . "',
                                           '" . trim($descripcion) . "',
                                           '" . $objArticuloEntidad->getCodigo() . "',
                                           '" . $objArticuloEntidad->getStock() . "',
                                           '" . $objArticuloEntidad->getPrecio() . "',
                                           '" . $objArticuloEntidad->getImagen() . "',
                                           '" . $objArticuloEntidad->getStockmin() . "',
                                           '" . $objArticuloEntidad->getGarantia() . "',
                                           '" . $objArticuloEntidad->getTiempo() . "',
                                           '" . $objArticuloEntidad->getSwitch() . "',
                                           '" . $objArticuloEntidad->getPrecioigv() . "',
                                           '" . $objArticuloEntidad->getMarca() . "',
                                           '" . $objArticuloEntidad->getCantidad() . "',
                                           '" . $objArticuloEntidad->getEstado() . "',
                                           '" . $objArticuloEntidad->getPrecio_venta() . "',
                                           '" . $objArticuloEntidad->getTipomoneda() . "',
                                           '" . $objArticuloEntidad->getCategoria() . "',
                                           '" . $objArticuloEntidad->getPrec_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_medida() . "')";
                        $objMysql->ejecutar($query7);
                        $error = 1;
                    }
                }
            } else {

                $parche=0;
                if ($parche == 0) {
                    $query = "CALL sp_mnt_alumnos('" . $param[0] . "',    
                                           '" . $objArticuloEntidad->getIdarticulo() . "',
                                           '" . $nombre . "',
                                           '" . $descripcion . "',
                                           '" . $objArticuloEntidad->getCodigo() . "',
                                           '" . $objArticuloEntidad->getStock() . "',
                                           '" . $objArticuloEntidad->getPrecio() . "',
                                           '" . $objArticuloEntidad->getImagen() . "',
                                           '" . $objArticuloEntidad->getStockmin() . "',
                                           '" . $objArticuloEntidad->getGarantia() . "',
                                           '" . $objArticuloEntidad->getTiempo() . "',
                                           '" . $objArticuloEntidad->getSwitch() . "',
                                           '" . $objArticuloEntidad->getPrecioigv() . "',
                                           '" . $objArticuloEntidad->getMarca() . "',
                                           '" . $objArticuloEntidad->getCantidad() . "',
                                           '" . $objArticuloEntidad->getEstado() . "',
                                           '" . $objArticuloEntidad->getPrecio_venta() . "',
                                           '" . $objArticuloEntidad->getTipomoneda() . "',
                                           '" . $objArticuloEntidad->getCategoria() . "',
                                           '" . $objArticuloEntidad->getPrec_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_caja() . "',
                                           '" . $objArticuloEntidad->getUnd_medida() . "')";
                    $objMysql->ejecutar($query);
                    $error = 1;
                } else {
                    $error = 2;
                }
            }
        } catch (PDOException $exc) {
            $error = 0;
        }
        return $error;
    }

}


