<?php

include("../_coneccion/Conexion.php");
include("../_config/Configuracion.php");

class Mysql {

    private $cn;
    private $rs;
    private $nRows;
    private $nFileds;
    private $ddlHTML;
    private $tablaHTML;
    private $sql;
    private $from;
    private $lista;
    private $nMax;

    function __construct() {

        $objCn = new Conexion(SERVIDOR, USUARIO_BD, CLAVE_BD, BASE_DATOS); //local

        $this->cn = $objCn->getConexion();
    }

    public function getcn() {

        return $this->cn;
    }

    public function ejecutar($sql) {

        $this->sql = NULL;

        $this->rs = NULL;

        try {

            $this->sql = $sql;

            if (empty($this->sql)) {

                $this->rs = "<div class=\"error\"><b>Error : </b> Consulta vac&iacute;a...!!!</div>";
            } else {

                //$this->rs = mysql_query($this->sql);

                $this->rs = $this->cn->prepare($this->sql);

                $this->rs->execute();
            }
        } catch (PDOException $e) {

            print($e->__toString());

            echo "ERROR: " . $e->getMessage();
        }



        return $this->rs;
    }

    public function ejecutarQuery($sql) {

        $this->sql = NULL;

        $this->rs = NULL;

        try {

            $this->sql = $sql;

            if (empty($this->sql)) {

                $this->rs = "<div class=\"error\"><b>Error : </b> Consulta vac&iacute;a...!!!</div>";
            } else {

                $this->rs = mysql_query($this->sql, $this->cn);

                if (!$this->rs) {

                    $this->rs = 0;
                }
            }
        } catch (Exception $e) {

            $this->rs = $e->__toString();
        }



        return $this->rs;
    }

    public function getFila($sql) {

        $vect = $this->consulta($sql);

        $fila = NULL;

        if ($vect != NULL) {

            if (count($vect) > 0) {

                $fila = $vect[1];
            }
        }

        return $fila;
    }

    public function getIdTabla($rs) {

        return $this->cn->lastInsertId($rs);
    }

//   public function getLastId($from){
//       $this->from = trim($from);
//       $this->nMax = NULL;
//       $this->sql = "SELECT MAX(idcompras) as max FROM ".$this->from;
//       $this->rs = $this->ejecutar($this->sql);
//       $this->nMax = @mysql_result($this->rs,0,'max');
//       return $this->nMax;
//   }

    public function getNumRows($from) {

        $this->from = trim($from);

        if (!empty($this->from)) {

            $this->nRows = NULL;

            try {

                echo $this->sql = "SELECT count(*) FROM " . $this->from;

                $this->rs = $this->ejecutar($this->sql);

                if (!$this->rs) {

                    $this->nRows = "<div class=\"error\"><b>Error en SQL :</b> " . mysql_error() . ".</div>";
                } else {

                    $this->nRows = @mysql_result($this->rs, 0, 0);

                    if (!$this->nRows) {

                        $this->nRows = "<div class=\"error\"><b>Error en SQL :</b> " . mysql_error() . ".</div>";
                    }
                }
            } catch (Exception $e) {

                $this->nRows = $e->__toString();
            }
        } else {

            $this->nRows = "<div class=\"error\"><b>Error :</b> Debe pasar el nombre de la tabla.</div>";
        }

        return $this->nRows;
    }

    public function getPassword($longitud) {

        $password = "";

        if (!empty($longitud)) {

            if (!is_numeric($longitud) || $longitud <= 0) {
                $longitud = 6;
            }

            if ($longitud > 6) {
                $longitud = 6;
            }

            $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

            for ($i = 0; $i < $longitud; $i++) {

                $key = mt_rand(0, strlen($caracteres) - 1);

                $password = $password . $caracteres{$key};
            }
        }

        return $password;
    }

    public function getUsuario($cadena) {

        $usuario = "";

        if (!empty($cadena)) {

            $vCadena = explode("-", $cadena);

            $nCadenas = count($vCadena);

            $clave = substr(strtolower($vCadena[0]), 0, 1) . strtolower($vCadena[1]);
        }

        return $clave;
    }

    public function getNumRowsAux($sql) {

        $this->from = trim($sql);

        if (!empty($this->from)) {

            $this->nRows = NULL;

            try {

                $this->sql = $sql;

                $this->rs = $this->ejecutar($this->sql);

                if (!$this->rs) {

                    $this->nRows = "<div class=\"error\"><b>Error en SQL :</b> " . mysql_error() . ".</div>";
                } else {

                    $this->nRows = @mysql_num_rows($this->rs);

                    if (!$this->nRows) {

                        $this->nRows = "<div class=\"error\"><b>Error en SQL :</b> " . mysql_error() . ".</div>";
                    }
                }
            } catch (Exception $e) {

                $this->nRows = $e->__toString();
            }
        } else {

            $this->nRows = "<div class=\"error\"><b>Error :</b> Debe pasar el nombre de la tabla.</div>";
        }

        return $this->nRows;
    }

    public function getNumticket($tipo) {

        $vfila = $this->getFila("select serie,numero + 1 as 'numero' from grifopacifico_codigo where tipo='" . $tipo . "' and swactivo=1;");

        $nNumticket = sprintf("%06d", $vfila[1]);

        $this->iniciarTransaccion();

        $rs = $this->ejecutar("UPDATE grifopacifico_codigo SET numero='" . $nNumticket . "' WHERE tipo='" . $tipo . "' and swactivo=1;");

        $salida = $vfila[0] . "-" . $nNumticket;

        if ($rs) {

            $this->grabarTransaccion();
        } else {

            $salida = "";

            $this->cancelarTransaccion();
        }

        return $salida;
    }

    public function getNumFields($rs) {

        $this->rs = $rs;

        if (is_resource($this->rs)) {

            $this->nFileds = NULL;

            try {

                $this->nFileds = @mysql_num_fields($this->rs);

                if (!$this->nFileds) {

                    $this->nFileds = "<div class=\"error\"><b>Error en SQL :</b> " . mysql_error() . ".</div>";
                }
            } catch (Exception $e) {

                $this->nFileds = $e->__toString();
            }
        } else {

            $this->nFileds = "<div class=\"error\"><b>Error  :</b> Debe pasar el recurso.</div>";
        }

        return $this->nFileds;
    }

    public function consulta($sql) {

        $this->sql = trim($sql);

        if (!empty($this->sql)) {

            $this->lista = NULL;

            try {

                $this->rs = $this->ejecutar($this->sql);

                $this->nFileds = $this->getNumFields($this->rs);

                $tit[] = "";

                for ($c = 0; $c < $this->nFileds; $c++) {

                    $tit[$c] = mysql_field_name($this->rs, $c);
                }

                $this->lista[0] = $tit;

                $fila[] = "";

                $f = 1;

                while ($rg = mysql_fetch_array($this->rs)) {

                    for ($i = 0; $i < $this->nFileds; $i++) {

                        $fila[$i] = $rg[mysql_field_name($this->rs, $i)];
                    }



                    $this->lista[$f++] = $fila;
                }
            } catch (Exception $e) {

                $this->lista = NULL;
            }
        } else {
            
        }

        return $this->lista;
    }
    
    public function getDropDownListTarjeta($sql, $default) {

        $this->sql = $sql;

        $this->rs = $this->ejecutar($this->sql);

        $this->ddlHTML = "";

        try {

            //if(is_array($this->rs)){
            //while($rg = mysql_fetch_array($this->rs)){
            
            
            foreach ($this->rs as $value) {



                $this->ddlHTML .= "<option value=\"" . $value["codigo"] . "\"";

                if ($value["codigo"] == $default)
                    $this->ddlHTML .= " selected ";

                $this->ddlHTML .= ">";

                $this->ddlHTML .= $value["descripcion"];

                $this->ddlHTML .= "</option>\n";
            }
        } catch (PDOException $e) {

            print ($e->__toString());
        }

        return $this->ddlHTML;
    }
    
    

    public function getDropDownList($sql, $default) {

        $this->sql = $sql;

        $this->rs = $this->ejecutar($this->sql);

        $this->ddlHTML = "";

        try {

            //if(is_array($this->rs)){
            //while($rg = mysql_fetch_array($this->rs)){

            foreach ($this->rs as $value) {



                $this->ddlHTML .= "<option value=\"" . $value["codigo"] . "\"";

                if ($value["codigo"] == $default)
                    $this->ddlHTML .= " selected ";

                $this->ddlHTML .= ">";

                $this->ddlHTML .= $value["descripcion"];

                $this->ddlHTML .= "</option>\n";
            }
        } catch (PDOException $e) {

            print ($e->__toString());
        }

        return $this->ddlHTML;
    }

    public function iniciarTransaccion() {

        $this->ejecutar("BEGIN");
    }

    public function grabarTransaccion() {

        $this->ejecutar("COMMIT");
    }

    public function cancelarTransaccion() {

        $this->ejecutar("ROLLBACK");
    }

    public function getGrillaHTML($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $ordenarPorCampo = $vParam[0];

        $ordenarEnForma = $vParam[1];

        $nPagados = $vParam[2];

        $nNopagados = $vParam[3];

        $nInscritos = $vParam[4];



        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {

            if ($ordenarEnForma == "ASC") {

                $ordenarEnForma = "DESC";

                $indicadorOrden = "<img src=\"../img/arrow_down.png\" align=\"top\"/>";
            } else {

                $ordenarEnForma = "ASC";

                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
            }
        } else {

            $indicadorOrden = "";

            $ordenarEnForma = "ASC";
        }

        //$url=$_SERVER['REQUEST_URI']."?temp_popup=1";

        $url = $_SERVER['PHP_SELF'] . "?temp_popup=1";

        $ssTablaHTML = "";

        $nCont = 2;

        $nContAux = 2;

        $rsDatos = $rs;

        if ($rsDatos == TRUE) {

            //$nNumCampos=mysql_num_fields($rsDatos); #número de campos

            $nNumCampos = $rs->columnCount(); #número de campos
            //$nNumFilas=mysql_num_rows($rsDatos);	#número de filas

            $nNumFilas = $rs->rowCount(); #número de filas

            /* adicionales *************** */





            /*             * ************************** */

            $nFil = 0;

            $sEstiloFila = "";

            $sColorFila = "";

            /*             * *************************************************************** */

            /* 1er tabla para mostrar las cabeceras */

            /*             * *************************************************************** */

            if ($nNumCampos > 0) {

                $sTablaHTML .= "<div class=\"textoContenido\">Cantidad de Registros encontrados: " . $nNumFilas . " </div><br>";

                $sTablaHTML .= " <table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";

                $sTablaHTML .= "<tr height=\"40\">\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";

                for ($c = 0; $c < $nNumCampos; $c++) {

                    $meta = $rs->getColumnMeta($c);

                    //$sNombreCampo = trim(mysql_field_name($rsDatos,$c)); #nombre de todos los campos

                    $sNombreCampo = $meta['name']; #nombre de todos los campos

                    $aplicar = "";

                    if ($ordenarPorCampo == $sNombreCampo) {

                        $aplicar = $indicadorOrden;
                    }

                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";

                    ++$nCont;
                }#cierra FOR



                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                /* aclara mis dudas */
            } else { #cierra 2do IF
                $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
            }

            //

            /*             * *************************************************************** */

            /* 2da tabla para mostrar los registros */

            /*             * *************************************************************** */

            if ($nNumFilas > 0) {

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";



                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $colorPintar = "#f1ff11";

                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[0] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            //$sNombreCampo = trim(mysql_field_name($rsDatos,$fc));

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = utf8_encode((!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-"));

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } elseif ($fc == 13) {

                                    if ($sContenido != "-") {

                                        $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\"><a href=\"javascript:void(0)\" onclick=\"openPopUp('" . utf8_encode($sContenido) . "?temp_popup=1',1,0,0,0,0,1,1,800,620,0,0,'Voucher');\" style=\"color: #006699;text-decoration:underline;\">Ver comprobante de pago</a></div></td>\n";
                                    } else {

                                        $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                    }
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[0] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            //$sNombreCampo = trim(mysql_field_name($rsDatos,$fc));

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = utf8_encode((!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-"));

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td>&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } elseif ($fc == 13) {

                                    if ($sContenido != "-") {

                                        $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\"><a href=\"javascript:void(0)\" onclick=\"openPopUp('" . utf8_encode($sContenido) . "?temp_popup=1',1,0,0,0,0,1,1,800,620,0,0,'Voucher');\" style=\"color: #006699;text-decoration:underline;\">Ver comprobante de pago</a></div></td>\n";
                                    } else {

                                        $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                    }
                                } else {

                                    $sTablaHTML .= "<td width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE



                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
            } else {

                //** 3

                /*                 * *********************************************************************************************

                  Si la tabla se encuentra vac�a, mostrar filas vac�as para decorar la GRILLA

                 * ********************************************************************************************* */

                $sTablaHTML .= "<div id=\"traerDatos\" >\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";



                $nFilasVacias = 10;

                for ($f = 0; $f <= $nFilasVacias; $f++) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";

                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td>&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td>&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
                //**3
            }
        } else { # cierra 1er IF
            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
        }

        return $sTablaHTML;
    }

    /*     * **************** Grilla de Articulos ***************** */

    public function getGrillaArticulo($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $ordenarPorCampo = $vParam[0];

        $ordenarEnForma = $vParam[1];

        $page = $vParam[2];

        $rsDatosAux = $vParam[3];

        $txtValorabuscar = $vParam[4];

        $rdbBuscar = $vParam[5];

        $n_reg_show = $vParam[6];

        $idmenu = $vParam[7];



        $objSesion = new Sesion();

        $valperf = $objSesion->getVariableSession("idperfil");

        //$valsesmen= $objSesion->getVariableSession("sm");



        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {

            if ($ordenarEnForma == "ASC") {

                $ordenarEnForma = "DESC";

                $indicadorOrden = "<img src=\"../img/arrow_down.png\"

                 align=\"top\"/>";
            } else {

                $ordenarEnForma = "ASC";

                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
            }
        } else {

            $indicadorOrden = "";

            $ordenarEnForma = "ASC";
        }



        $url = $_SERVER['REQUEST_URI'] . "?id=" . rand(1, 1000) . "&temp_popup=1";

        $sTablaHTML = "";

        $nCont = 2;

        $nContAux = 2;

        $rsDatos = $rs; // esto ya no es necesario 

        if ($rsDatos == TRUE) {

            $nNumCampos = $rs->columnCount(); #número de campos

            $nNumFilas = $rsDatosAux; #número de filas    
            //******** para el navegador de resgistros - MIRO CUANTOS DATOS FUERON DEVUELTOS 

            $num_rows = $nNumFilas;

            //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

            $rows_per_page = $n_reg_show;

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

            // ********************************************* fin para el navegador de 

            $nFil = 0;

            $sEstiloFila = "";

            $sColorFila = "";

            /*             * *************************************************************** */

            /* 1er tabla para mostrar las cabeceras */

            /*             * *************************************************************** */

            if ($nNumCampos > 0) {

                $sTablaHTML .= "<div class=\"textoContenido\">Numero de filas encontradas : " . $nNumFilas . " </div>";

                $sTablaHTML .= "<table border=\"0\">";

                echo "<tr><div style='margin-left:10px;'>";

                echo "
                    
                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>
                <td>&nbsp;&nbsp;</td>
                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>                
                <td>&nbsp;&nbsp;</td>                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>                
                <td>&nbsp;&nbsp;</td> 
                <td><button class=\"btn btn\" type=\"button\" onclick=\"stock()\">STOCK</button></td>                
                <td>&nbsp;&nbsp;</td>";

                echo "</div></tr></table>";

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\"  width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";

                $sTablaHTML .= "<tr height=\"40\">\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";

                for ($c = 0; $c < $nNumCampos; $c++) {

                    $meta = $rs->getColumnMeta($c);

                    $sNombreCampo = $meta['name']; #nombre de todos los campos

                    $aplicar = "";

                    if ($ordenarPorCampo == $sNombreCampo) {

                        $aplicar = $indicadorOrden;
                    }

                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "&page=" . $page . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";

                    ++$nCont;
                }#cierra FOR



                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                /* aclara mis dudas */
            } else { #cierra 2do IF
                $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
            }

            //

            /*             * *************************************************************** */

            /* 2da tabla para mostrar los registros */

            /*             * *************************************************************** */

            if ($nNumFilas > 0) {

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";


                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $colorPintar = "#f1ff11";

                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td>&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE



                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tr>\n";

                $sTablaHTML .= "<td>\n";

                //************************ aqui NAVEGADOR DE REGISTROS    





                if ($num_rows != 0) {

                    $nextpage = $page + 1;

                    $prevpage = $page - 1; // puesto por MI

                    $pageActual = $page;

                    $sTablaHTML .= "<ul id=\"pagination-digg\">";

                    //SI ES LA PRIMERA P?GINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE P?GINAS

                    if ($page == 1) {

                        $sTablaHTML .= "<li class=\"previous-off\">&laquo; Anterior</li>";

                        $sTablaHTML .= "<li class=\"active\">1</li>"; // si la pagina no esta definida vale 1 y se muestra activo 1

                        for ($i = $page + 1; $i <= $lastpage; $i++) { // comienza a leer desde la pagina 2
                            if ($i <= $num_page_view) {

                                $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                            }
                        }

                        //Y SI LA ULTIMA P?GINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    } else { // si pagina es mayor a 1
                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=1&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">&laquo; Inicio</a></li>";

                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=" . $prevpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\"> &laquo; Anterior</a></li>";



                        $dif = $num_page_view + $page; // calculo para mostrar siempre 5 paginas;



                        for ($i = $page; $i <= $lastpage; $i++) {

                            //COMPRUEBO SI ES LA PAGINA ACTIVA O NO

                            if ($page == $i) {

                                $sTablaHTML .= "<li class=\"active\">" . $i . "</li>"; // si la pagina enviada es = ala mostrada entonces se selecciona 
                            } else {

                                if ($i < $dif) {

                                    $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                                }
                            }
                        }



                        //SI NO ES LA ?LTIMA P?GINA ACTIVO EL BOTON NEXT    

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    }

                    $sTablaHTML .= "</ul>";
                }





                //************************ FIN DE NAVEGADOR DE REGISTROS    

                $sTablaHTML .= "</td>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
            } else {

                //** 3

                /*                 * *********************************************************************************************

                  Si la tabla se encuentra vac?a, mostrar filas vac?as para decorar la GRILLA

                 * ********************************************************************************************* */

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";



                $nFilasVacias = 10;

                for ($f = 0; $f <= $nFilasVacias; $f++) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";

                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td>&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td>&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
                //**3
            }
        } else { # cierra 1er IF
            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
        }
        return $sTablaHTML;
    }

    /*     * ****************Fin de Grilla Articulo**************** */


    /* grilla 2 */

    /*     * *********************** GRILLA CLIENTES************************ */

    public function getGrillaHTMLClientes($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

//        $ordenarPorCampo = $vParam[0];
//
//        $ordenarEnForma = $vParam[1];
//
//        $page = $vParam[2];
//
//        $rsDatosAux = $vParam[3];
//
//        $txtValorabuscar = $vParam[4];
//
//        $rdbBuscar = $vParam[5];
//
//        $n_reg_show = $vParam[6];
//
//        $idmenu = $vParam[7];
//
//
//
//        $objSesion = new Sesion();
//
//        $valperf = $objSesion->getVariableSession("idperfil");
//
//        //$valsesmen= $objSesion->getVariableSession("sm");
//
//
//
//        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {
//
//            if ($ordenarEnForma == "ASC") {
//
//                $ordenarEnForma = "DESC";
//
//                $indicadorOrden = "<img src=\"../img/arrow_down.png\"
//
//                 align=\"top\"/>";
//            } else {
//
//                $ordenarEnForma = "ASC";
//
//                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
//            }
//        } else {
//
//            $indicadorOrden = "";
//
//            $ordenarEnForma = "ASC";
//        }
//
//
//
//        $url = $_SERVER['REQUEST_URI'] . "?id=" . rand(1, 1000) . "&temp_popup=1";
//
//        $sTablaHTML = "";
//
//        $nCont = 2;
//
//        $nContAux = 2;
//
//        $rsDatos = $rs; // esto ya no es necesario 
//
//        if ($rsDatos == TRUE) {
//
//            $nNumCampos = $rs->columnCount(); #número de campos
//
//            $nNumFilas = $rsDatosAux; #número de filas    
//            //******** para el navegador de resgistros - MIRO CUANTOS DATOS FUERON DEVUELTOS 
//
//            $num_rows = $nNumFilas;
//
//            //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
//
//            $rows_per_page = $n_reg_show;
//
//            $num_page_view = 2;
//
//            $num_page_next = 1;
//
//            //CALCULO LA ULTIMA P?GINA
//
//            $lastpage = ceil($num_rows / $rows_per_page);
//
//            //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA
//
//            $page = (int) $page;
//
//            if ($page > $lastpage) {
//
//                $page = $lastpage;
//            }
//
//            if ($page < 1) {
//
//                $page = 1;
//            }
//
//            // ********************************************* fin para el navegador de 
//
//            $nFil = 0;
//
//            $sEstiloFila = "";
//
//            $sColorFila = "";
//
//            /*             * *************************************************************** */
//
//            /* 1er tabla para mostrar las cabeceras */
//
//            /*             * *************************************************************** */
        $nNumCampos = 1;
        if ($nNumCampos > 0) {

            //$sTablaHTML .= "<br><div class=\"textoContenido\" style=\"background:#CCCCCC;color:black;font-size:9pt\">Número de Registros Encontrados : " . $nNumFilas . " </div>";

            $sTablaHTML .= "<table border=\"0\">";

            echo "<tr><div style='margin-left:10px;'>";

            echo "<td><button id=\"nuevo\" class=\"btn btn\" type=\"button\" onclick=\"irA('INS')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"ReporteCredito()\">ESTADO - CREDITO</button></td>
                
                <td>&nbsp;&nbsp;</td>
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"MailReporteCredito()\">ENVIAR ESTADO - CRÉDITO</button></td>
                
                <td>&nbsp;&nbsp;</td>
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>";

            echo "</div></tr></table>";

//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\"  width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//                $sTablaHTML .= "<tr height=\"40\">\n";
//
//                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";
//
//                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";
//
//                for ($c = 0; $c < $nNumCampos; $c++) {
//
//                    $meta = $rs->getColumnMeta($c);
//
//                    $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                    $aplicar = "";
//
//                    if ($ordenarPorCampo == $sNombreCampo) {
//
//                        $aplicar = $indicadorOrden;
//                    }
//
//                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "&page=" . $page . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";
//
//                    ++$nCont;
//                }#cierra FOR
//
//
//
//                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";
//
//                $sTablaHTML .= "</tr>\n";
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";

            /* aclara mis dudas */
        } else { #cierra 2do IF
            $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
        }

        //

        /*         * *************************************************************** */

        /* 2da tabla para mostrar los registros */

        /*         * *************************************************************** */

//            if ($nNumFilas > 0) {
//
//                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX
//
//                $sTablaHTML .= "<div id=\"scrollGrilla\" style=\"width:100% !important;height:200px !important\">\n"; # Div para el SCROLL
//
//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//
//                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
//
//                    ++$nfil;
//
//                    if (($nfil % 2 == 1)) {
//
//                        $sEstiloFila = "f1";
//
//                        $sColorFila = "#e5f1f4";
//                    } else {
//
//                        $sEstiloFila = "f2";
//
//                        $sColorFila = "#f8fbfc";
//                    }
//
//                    $colorPintar = "#f1ff11";
//
//                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"
//
//                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";
//
//                    if ($nfil == 1) {
//
//                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";
//
//                        $metaId = $rs->getColumnMeta(0);
//
//                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $meta = $rs->getColumnMeta($fc);
//
//                            $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");
//
//                            if (empty($sContenido)) {
//
//                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
//                            } else {
//
//                                if ($fc == 0) {
//
//                                    $sTablaHTML .= "<td  id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
//                                } else {
//
//                                    $sTablaHTML .= "<td  id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
//                                }
//                            }
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
//                    } else {
//
//                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td align=\"center\">\n";
//
//                        $metaId = $rs->getColumnMeta(0);
//
//                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $meta = $rs->getColumnMeta($fc);
//
//                            $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");
//
//                            if (empty($sContenido)) {
//
//                                $sTablaHTML .= "<td>&nbsp;</td>\n";
//                            } else {
//
//                                if ($fc == 0) {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
//                                } else {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
//                                }
//                            }
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
//                    }
//
//                    $sTablaHTML .= "</tr>\n";
//                }#fin del WHILE
//
//
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL
//
//                $sTablaHTML .= "<table style=\"margin-top:-11px\" class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tr>\n";
//
//                $sTablaHTML .= "<td>\n";
//
//                //************************ aqui NAVEGADOR DE REGISTROS    
//
//                if ($num_rows != 0) {
//
//                    $nextpage = $page + 1;
//
//                    $prevpage = $page - 1; // puesto por MI
//
//                    $pageActual = $page;
//
//                    $sTablaHTML .= "<ul id=\"pagination-digg\">";
//
//                    //SI ES LA PRIMERA P?GINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE P?GINAS
//
//                    if ($page == 1) {
//
//                        $sTablaHTML .= "<li class=\"previous-off\">&laquo; Anterior</li>";
//
//                        $sTablaHTML .= "<li class=\"active\">1</li>"; // si la pagina no esta definida vale 1 y se muestra activo 1
//
//                        for ($i = $page + 1; $i <= $lastpage; $i++) { // comienza a leer desde la pagina 2
//                            if ($i <= $num_page_view) {
//
//                                $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
//                            }
//                        }
//
//                        //Y SI LA ULTIMA P?GINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO
//
//                        if ($lastpage > $page) {
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
//                        } else {
//
//                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
//                        }
//                    } else { // si pagina es mayor a 1
//                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=1&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">&laquo; Inicio</a></li>";
//
//                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=" . $prevpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\"> &laquo; Anterior</a></li>";
//
//
//
//                        $dif = $num_page_view + $page; // calculo para mostrar siempre 5 paginas;
//
//
//
//                        for ($i = $page; $i <= $lastpage; $i++) {
//
//                            //COMPRUEBO SI ES LA PAGINA ACTIVA O NO
//
//                            if ($page == $i) {
//
//                                $sTablaHTML .= "<li class=\"active\">" . $i . "</li>"; // si la pagina enviada es = ala mostrada entonces se selecciona 
//                            } else {
//
//                                if ($i < $dif) {
//
//                                    $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
//                                }
//                            }
//                        }
//
//
//
//                        //SI NO ES LA ?LTIMA P?GINA ACTIVO EL BOTON NEXT    
//
//                        if ($lastpage > $page) {
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
//                        } else {
//
//                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
//                        }
//                    }
//
//                    $sTablaHTML .= "</ul>";
//                }
//
//
//
//
//
//                //************************ FIN DE NAVEGADOR DE REGISTROS    
//
//                $sTablaHTML .= "</td>\n";
//
//                $sTablaHTML .= "</tr>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
//            } else {
//
//                //** 3
//
//                /*                 * *********************************************************************************************
//
//                  Si la tabla se encuentra vac?a, mostrar filas vac?as para decorar la GRILLA
//
//                 * ********************************************************************************************* */
//
//                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX
//
//                $sTablaHTML .= "<div id=\"scrollGrilla\" style=\"width:100% !important;height:200px !important\">\n"; # Div para el SCROLL
//
//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//
//
//                $nFilasVacias = 10;
//
//                for ($f = 0; $f <= $nFilasVacias; $f++) {
//
//                    ++$nfil;
//
//                    if (($nfil % 2 == 1)) {
//
//                        $sEstiloFila = "f1";
//
//                        $sColorFila = "#e5f1f4";
//                    } else {
//
//                        $sEstiloFila = "f2";
//
//                        $sColorFila = "#f8fbfc";
//                    }
//
//                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";
//
//                    if ($nfil == 1) {
//
//                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";
//
//                        $sTablaHTML .= "&nbsp;\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
//                    } else {
//
//                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td align=\"center\">\n";
//
//                        $sTablaHTML .= "&nbsp;\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $sTablaHTML .= "<td>&nbsp;</td>\n";
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td>&nbsp;</td>\n";
//                    }
//
//                    $sTablaHTML .= "</tr>\n";
//                }#fin del WHILE
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL
//
//                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
//                //**3
//            }
//        } else { # cierra 1er IF
//            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
//        }

        return $sTablaHTML;
    }

    /*     * *************************************************************** */

    /*     * ************************* GRILLA DE PROVEEDOR ************************* */

    public function getGrillaHTMLProveedor($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $nNumCampos = 1;
        if ($nNumCampos > 0) {

            $sTablaHTML .= "<table border=\"0\">";

            echo "<tr><div style='margin-left:10px;'>";

            echo "<td><button id=\"nuevo\" class=\"btn btn\" type=\"button\" onclick=\"irA('INS')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"ReporteAbono()\">REPORTE ABONOS</button></td>
                
                <td>&nbsp;&nbsp;</td>
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>";

            echo "</div></tr></table>";

            /* aclara mis dudas */
        } else { #cierra 2do IF
            $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
        }

        return $sTablaHTML;
    }

    /*     * *********************************************************************** */
public function getGrillaHTMLTabletArt($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $nNumCampos = 1;
        if ($nNumCampos > 0) {

            $sTablaHTML .= "<table border=\"0\">";

            echo "<tr><div style='margin-left:10px;'>";

            echo "<td><button id=\"nuevo\" class=\"btn\" type=\"button\" onclick=\"irA('INS')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>                
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimirStock()\">PDF STOCK</button></td>";
                      
                echo "<td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">PDF </button></td>";
                       
            echo "<td>&nbsp;&nbsp;</td>
            
            <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>";

            echo "</div></tr></table>";
        } else { #cierra 2do IF
            $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
        }

        return $sTablaHTML;
    }
    public function getGrillaHTMLTablet($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $nNumCampos = 1;
        if ($nNumCampos > 0) {

            $sTablaHTML .= "<table border=\"0\">";

            echo "<tr><div style='margin-left:10px;'>";

            echo "<td><button id=\"nuevo\" class=\"btn btn\" type=\"button\" onclick=\"irA('INS')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>                
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>";
           
            echo "<td>&nbsp;&nbsp;</td>
            
            <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>";

            echo "</div></tr></table>";
        } else { #cierra 2do IF
            $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
        }

        return $sTablaHTML;
    }
    
    public function getGrillaHTMLTablet2($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

        $ordenarPorCampo = $vParam[0];

        $ordenarEnForma = $vParam[1];

        $page = $vParam[2];

        $rsDatosAux = $vParam[3];

        $txtValorabuscar = $vParam[4];

        $rdbBuscar = $vParam[5];

        $n_reg_show = $vParam[6];

        $idmenu = $vParam[7];



        $objSesion = new Sesion();

        $valperf = $objSesion->getVariableSession("idperfil");

        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {

            if ($ordenarEnForma == "ASC") {

                $ordenarEnForma = "DESC";

                $indicadorOrden = "<img src=\"../img/arrow_down.png\"

                 align=\"top\"/>";
            } else {

                $ordenarEnForma = "ASC";

                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
            }
        } else {

            $indicadorOrden = "";

            $ordenarEnForma = "ASC";
        }



        $url = $_SERVER['REQUEST_URI'] . "?id=" . rand(1, 1000) . "&temp_popup=1";

        $sTablaHTML = "";

        $nCont = 2;

        $nContAux = 2;

        $rsDatos = $rs; // esto ya no es necesario 

        if ($rsDatos == TRUE) {

            $nNumCampos = $rs->columnCount(); #número de campos

            $nNumFilas = $rsDatosAux; #número de filas    
            //******** para el navegador de resgistros - MIRO CUANTOS DATOS FUERON DEVUELTOS 

            $num_rows = $nNumFilas;

            //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

            $rows_per_page = $n_reg_show;

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

            // ********************************************* fin para el navegador de 

            $nFil = 0;

            $sEstiloFila = "";

            $sColorFila = "";

            /*             * *************************************************************** */

            /* 1er tabla para mostrar las cabeceras */

            /*             * *************************************************************** */

            if ($nNumCampos > 0) {

                $sTablaHTML .= "<br><div class=\"textoContenido\" style=\"background:#CCCCCC;color:black;font-size:9pt\">Número de Registros Encontrados : " . $nNumFilas . " </div>";

                $sTablaHTML .= "<table border=\"0\">";

                echo "<tr><div style='margin-left:10px;'>";

                echo "<td><button id=\"nuevo\" class=\"btn btn\" type=\"button\" onclick=\"irA('INS')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>              
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>";

                echo "</div></tr></table>";

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\"  width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";

                $sTablaHTML .= "<tr height=\"40\">\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";

                for ($c = 0; $c < $nNumCampos; $c++) {

                    $meta = $rs->getColumnMeta($c);

                    $sNombreCampo = $meta['name']; #nombre de todos los campos

                    $aplicar = "";

                    if ($ordenarPorCampo == $sNombreCampo) {

                        $aplicar = $indicadorOrden;
                    }

                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "&page=" . $page . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";

                    ++$nCont;
                }#cierra FOR



                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                /* aclara mis dudas */
            } else { #cierra 2do IF
                $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
            }

            //

            /*             * *************************************************************** */

            /* 2da tabla para mostrar los registros */

            /*             * *************************************************************** */

            if ($nNumFilas > 0) {

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\" style=\"width:100% !important;height:200px !important\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";


                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $colorPintar = "#f1ff11";

                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td  id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td  id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td>&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE



                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tr>\n";

                $sTablaHTML .= "<td>\n";

                //************************ aqui NAVEGADOR DE REGISTROS    





                if ($num_rows != 0) {

                    $nextpage = $page + 1;

                    $prevpage = $page - 1; // puesto por MI

                    $pageActual = $page;

                    $sTablaHTML .= "<ul id=\"pagination-digg\">";

                    //SI ES LA PRIMERA P?GINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE P?GINAS

                    if ($page == 1) {

                        $sTablaHTML .= "<li class=\"previous-off\">&laquo; Anterior</li>";

                        $sTablaHTML .= "<li class=\"active\">1</li>"; // si la pagina no esta definida vale 1 y se muestra activo 1

                        for ($i = $page + 1; $i <= $lastpage; $i++) { // comienza a leer desde la pagina 2
                            if ($i <= $num_page_view) {

                                $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                            }
                        }

                        //Y SI LA ULTIMA P?GINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    } else { // si pagina es mayor a 1
                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=1&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">&laquo; Inicio</a></li>";

                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=" . $prevpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\"> &laquo; Anterior</a></li>";



                        $dif = $num_page_view + $page; // calculo para mostrar siempre 5 paginas;



                        for ($i = $page; $i <= $lastpage; $i++) {

                            //COMPRUEBO SI ES LA PAGINA ACTIVA O NO

                            if ($page == $i) {

                                $sTablaHTML .= "<li class=\"active\">" . $i . "</li>"; // si la pagina enviada es = ala mostrada entonces se selecciona 
                            } else {

                                if ($i < $dif) {

                                    $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                                }
                            }
                        }



                        //SI NO ES LA ?LTIMA P?GINA ACTIVO EL BOTON NEXT    

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    }

                    $sTablaHTML .= "</ul>";
                }





                //************************ FIN DE NAVEGADOR DE REGISTROS    

                $sTablaHTML .= "</td>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
            } else {

                //** 3

                /*                 * *********************************************************************************************

                  Si la tabla se encuentra vac?a, mostrar filas vac?as para decorar la GRILLA

                 * ********************************************************************************************* */

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";



                $nFilasVacias = 10;

                for ($f = 0; $f <= $nFilasVacias; $f++) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";

                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td>&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td>&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
                //**3
            }
        } else { # cierra 1er IF
            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
        }

        return $sTablaHTML;
    }

    /*     * ******************************************GRILLA USUSARIOS ****************************************** */

    public function getGrillaUsuarios($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {

//        $ordenarPorCampo = $vParam[0];
//
//        $ordenarEnForma = $vParam[1];
//
//        $page = $vParam[2];
//
//        $rsDatosAux = $vParam[3];
//
//        $txtValorabuscar = $vParam[4];
//
//        $rdbBuscar = $vParam[5];
//
//        $n_reg_show = $vParam[6];
//
//        $idmenu = $vParam[7];
//
//
//
//        $objSesion = new Sesion();
//
//        $valperf = $objSesion->getVariableSession("idperfil");
//
//        //$valsesmen= $objSesion->getVariableSession("sm");
//
//
//
//        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {
//
//            if ($ordenarEnForma == "ASC") {
//
//                $ordenarEnForma = "DESC";
//
//                $indicadorOrden = "<img src=\"../img/arrow_down.png\"
//
//                 align=\"top\"/>";
//            } else {
//
//                $ordenarEnForma = "ASC";
//
//                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
//            }
//        } else {
//
//            $indicadorOrden = "";
//
//            $ordenarEnForma = "ASC";
//        }
//
//
//
//        $url = $_SERVER['REQUEST_URI'] . "?id=" . rand(1, 1000) . "&temp_popup=1";
//
//        $sTablaHTML = "";
//
//        $nCont = 2;
//
//        $nContAux = 2;
//
//        $rsDatos = $rs; // esto ya no es necesario 
//
//        if ($rsDatos == TRUE) {
//
//            $nNumCampos = $rs->columnCount(); #número de campos
//
//            $nNumFilas = $rsDatosAux; #número de filas    
//            //******** para el navegador de resgistros - MIRO CUANTOS DATOS FUERON DEVUELTOS 
//
//            $num_rows = $nNumFilas;
//
//            //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15
//
//            $rows_per_page = $n_reg_show;
//
//            $num_page_view = 2;
//
//            $num_page_next = 1;
//
//            //CALCULO LA ULTIMA P?GINA
//
//            $lastpage = ceil($num_rows / $rows_per_page);
//
//            //COMPRUEBO QUE EL VALOR DE LA PÁGINA SEA CORRECTO Y SI ES LA ULTIMA P?GINA
//
//            $page = (int) $page;
//
//            if ($page > $lastpage) {
//
//                $page = $lastpage;
//            }
//
//            if ($page < 1) {
//
//                $page = 1;
//            }
//
//            // ********************************************* fin para el navegador de 
//
//            $nFil = 0;
//
//            $sEstiloFila = "";
//
//            $sColorFila = "";
//
//            /*             * *************************************************************** */
//
//            /* 1er tabla para mostrar las cabeceras */
//
//            /*             * *************************************************************** */

        $nNumCampos = 1;
        if ($nNumCampos > 0) {

            //$sTablaHTML .= "<div class=\"textoContenido\">Numero de filas encontradas : " . $nNumFilas . " </div>";

            $sTablaHTML .= "<table border=\"0\">";

            echo "<tr><div style='margin-left:10px;'>";

            echo "
                    
                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>
                
                <td>&nbsp;&nbsp;</td>
                
                <td><button class=\"btn btn\" type=\"button\" onclick=\"exportarExcel()\">EXCEL</button></td>
                
                <td>&nbsp;&nbsp;</td>";

            echo "</div></tr></table>";

//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\"  width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//                $sTablaHTML .= "<tr height=\"40\">\n";
//
//                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";
//
//                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";
//
//                for ($c = 0; $c < $nNumCampos; $c++) {
//
//                    $meta = $rs->getColumnMeta($c);
//
//                    $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                    $aplicar = "";
//
//                    if ($ordenarPorCampo == $sNombreCampo) {
//
//                        $aplicar = $indicadorOrden;
//                    }
//
//                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "&page=" . $page . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";
//
//                    ++$nCont;
//                }#cierra FOR
//
//
//
//                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";
//
//                $sTablaHTML .= "</tr>\n";
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                /* aclara mis dudas */
//            } else { #cierra 2do IF
//                $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
//            }
//
//            //
//
//            /*             * *************************************************************** */
//
//            /* 2da tabla para mostrar los registros */
//
//            /*             * *************************************************************** */
//
//            if ($nNumFilas > 0) {
//
//                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX
//
//                $sTablaHTML .= "<div id=\"scrollGrilla\" style=\"width:100% !important;height:200px !important\">\n"; # Div para el SCROLL
//
//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//
//                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
//
//                    ++$nfil;
//
//                    if (($nfil % 2 == 1)) {
//
//                        $sEstiloFila = "f1";
//
//                        $sColorFila = "#e5f1f4";
//                    } else {
//
//                        $sEstiloFila = "f2";
//
//                        $sColorFila = "#f8fbfc";
//                    }
//
//                    $colorPintar = "#f1ff11";
//
//                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"
//
//                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";
//
//                    if ($nfil == 1) {
//
//                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";
//
//                        $metaId = $rs->getColumnMeta(0);
//
//                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $meta = $rs->getColumnMeta($fc);
//
//                            $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");
//
//                            if (empty($sContenido)) {
//
//                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
//                            } else {
//
//                                if ($fc == 0) {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
//                                } else {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
//                                }
//                            }
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
//                    } else {
//
//                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td align=\"center\">\n";
//
//                        $metaId = $rs->getColumnMeta(0);
//
//                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $meta = $rs->getColumnMeta($fc);
//
//                            $sNombreCampo = $meta['name']; #nombre de todos los campos
//
//                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");
//
//                            if (empty($sContenido)) {
//
//                                $sTablaHTML .= "<td>&nbsp;</td>\n";
//                            } else {
//
//                                if ($fc == 0) {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
//                                } else {
//
//                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
//                                }
//                            }
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
//                    }
//
//                    $sTablaHTML .= "</tr>\n";
//                }#fin del WHILE
//
//
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL
//
//                $sTablaHTML .= "<table style=\"margin-top:20px\" class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tr>\n";
//
//                $sTablaHTML .= "<td>\n";
//
//                //************************ aqui NAVEGADOR DE REGISTROS    
//
//
//
//
//
//                if ($num_rows != 0) {
//
//                    $nextpage = $page + 1;
//
//                    $prevpage = $page - 1; // puesto por MI
//
//                    $pageActual = $page;
//
//                    $sTablaHTML .= "<ul id=\"pagination-digg\">";
//
//                    //SI ES LA PRIMERA P?GINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE P?GINAS
//
//                    if ($page == 1) {
//
//                        $sTablaHTML .= "<li class=\"previous-off\">&laquo; Anterior</li>";
//
//                        $sTablaHTML .= "<li class=\"active\">1</li>"; // si la pagina no esta definida vale 1 y se muestra activo 1
//
//                        for ($i = $page + 1; $i <= $lastpage; $i++) { // comienza a leer desde la pagina 2
//                            if ($i <= $num_page_view) {
//
//                                $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
//                            }
//                        }
//
//                        //Y SI LA ULTIMA P?GINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO
//
//                        if ($lastpage > $page) {
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
//                        } else {
//
//                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
//                        }
//                    } else { // si pagina es mayor a 1
//                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=1&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">&laquo; Inicio</a></li>";
//
//                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=" . $prevpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\"> &laquo; Anterior</a></li>";
//
//
//
//                        $dif = $num_page_view + $page; // calculo para mostrar siempre 5 paginas;
//
//
//
//                        for ($i = $page; $i <= $lastpage; $i++) {
//
//                            //COMPRUEBO SI ES LA PAGINA ACTIVA O NO
//
//                            if ($page == $i) {
//
//                                $sTablaHTML .= "<li class=\"active\">" . $i . "</li>"; // si la pagina enviada es = ala mostrada entonces se selecciona 
//                            } else {
//
//                                if ($i < $dif) {
//
//                                    $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
//                                }
//                            }
//                        }
//
//
//
//                        //SI NO ES LA ?LTIMA P?GINA ACTIVO EL BOTON NEXT    
//
//                        if ($lastpage > $page) {
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";
//
//                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
//                        } else {
//
//                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
//                        }
//                    }
//
//                    $sTablaHTML .= "</ul>";
//                }
//
//
//
//
//
//                //************************ FIN DE NAVEGADOR DE REGISTROS    
//
//                $sTablaHTML .= "</td>\n";
//
//                $sTablaHTML .= "</tr>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
//            } else {
//
//                //** 3
//
//                /*                 * *********************************************************************************************
//
//                  Si la tabla se encuentra vac?a, mostrar filas vac?as para decorar la GRILLA
//
//                 * ********************************************************************************************* */
//
//                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX
//
//                $sTablaHTML .= "<div id=\"scrollGrilla\" style=\"width:100% !important;height:200px !important\">\n"; # Div para el SCROLL
//
//                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";
//
//                $sTablaHTML .= "<tbody>\n";
//
//
//
//                $nFilasVacias = 10;
//
//                for ($f = 0; $f <= $nFilasVacias; $f++) {
//
//                    ++$nfil;
//
//                    if (($nfil % 2 == 1)) {
//
//                        $sEstiloFila = "f1";
//
//                        $sColorFila = "#e5f1f4";
//                    } else {
//
//                        $sEstiloFila = "f2";
//
//                        $sColorFila = "#f8fbfc";
//                    }
//
//                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";
//
//                    if ($nfil == 1) {
//
//                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";
//
//                        $sTablaHTML .= "&nbsp;\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
//                    } else {
//
//                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";
//
//                        $sTablaHTML .= "<td align=\"center\">\n";
//
//                        $sTablaHTML .= "&nbsp;\n";
//
//                        $sTablaHTML .= "</td>\n";
//
//                        for ($fc = 0; $fc < $nNumCampos; $fc++) {
//
//                            $sTablaHTML .= "<td>&nbsp;</td>\n";
//
//                            ++$nContAux;
//                        }
//
//                        $sTablaHTML .= "<td>&nbsp;</td>\n";
//                    }
//
//                    $sTablaHTML .= "</tr>\n";
//                }#fin del WHILE
//
//                $sTablaHTML .= "</tbody>\n";
//
//                $sTablaHTML .= "</table>\n";
//
//                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL
//
//                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
//                //**3
//            }
//        } else { # cierra 1er IF
//            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
        }
        return $sTablaHTML;
    }

    /*     * ***********************GRILLA SERIES***************************************** */

    public function getGrillaHTMLSeries($rs, $anchoTbl, array $sNombreCampo2, array $sAnchoCampo, array $vParam) {


        $ordenarPorCampo = $vParam[0];

        $ordenarEnForma = $vParam[1];

        $page = $vParam[2];

        $rsDatosAux = $vParam[3];

        $txtValorabuscar = $vParam[4];

        $rdbBuscar = $vParam[5];

        $n_reg_show = $vParam[6];

        $idmenu = $vParam[7];



        $objSesion = new Sesion();

        $valperf = $objSesion->getVariableSession("idperfil");

        //$valsesmen= $objSesion->getVariableSession("sm");



        if (!empty($ordenarPorCampo) && !empty($ordenarEnForma)) {

            if ($ordenarEnForma == "ASC") {

                $ordenarEnForma = "DESC";

                $indicadorOrden = "<img src=\"../img/arrow_down.png\"

                 align=\"top\"/>";
            } else {

                $ordenarEnForma = "ASC";

                $indicadorOrden = "<img src=\"../img/arrow_up.png\" align=\"top\"/>";
            }
        } else {

            $indicadorOrden = "";

            $ordenarEnForma = "ASC";
        }



        $url = $_SERVER['REQUEST_URI'] . "?id=" . rand(1, 1000) . "&temp_popup=1";

        $sTablaHTML = "";

        $nCont = 2;

        $nContAux = 2;

        $rsDatos = $rs; // esto ya no es necesario 

        if ($rsDatos == TRUE) {

            $nNumCampos = $rs->columnCount(); #número de campos

            $nNumFilas = $rsDatosAux; #número de filas    
            //******** para el navegador de resgistros - MIRO CUANTOS DATOS FUERON DEVUELTOS 

            $num_rows = $nNumFilas;

            //ACA SE DECIDE CUANTOS RESULTADOS MOSTRAR POR P?GINA , EN EL EJEMPLO PONGO 15

            $rows_per_page = $n_reg_show;

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

            // ********************************************* fin para el navegador de 

            $nFil = 0;

            $sEstiloFila = "";

            $sColorFila = "";

            /*             * *************************************************************** */

            /* 1er tabla para mostrar las cabeceras */

            /*             * *************************************************************** */

            if ($nNumCampos > 0) {

                $sTablaHTML .= "<div class=\"textoContenido\">Numero de filas encontradas : " . $nNumFilas . " </div>";

                $sTablaHTML .= "<table border=\"0\">";

                echo "<tr><div style='margin-left:10px;'>";

                echo "<td><button class=\"btn btn\" type=\"button\" onclick=\"irA('INS','$_GET[id]')\">NUEVO</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('UPD')\">ACTUALIZAR</button></td>

                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"irA('DEL','$_GET[id]')\">ELIMINAR</button></td>
                
                <td>&nbsp;&nbsp;</td>

                <td><button class=\"btn btn\" type=\"button\" onclick=\"imprimir()\">REPORTE</button></td>";

                echo "</div></tr></table>";

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\"  width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";

                $sTablaHTML .= "<tr height=\"40\">\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc0\" width=\"10\">&nbsp;</th>\n";

                $sTablaHTML .= "<th scope=\"col\" id=\"hc1\" width=\"25\">&nbsp;<input type=\"checkbox\" name=\"chkseleAll[]\" id=\"chkseleAll\" onclick=\"seleccionarCheck(this.form,this)\"/></th>\n";

                for ($c = 0; $c < $nNumCampos; $c++) {

                    $meta = $rs->getColumnMeta($c);

                    $sNombreCampo = $meta['name']; #nombre de todos los campos

                    $aplicar = "";

                    if ($ordenarPorCampo == $sNombreCampo) {

                        $aplicar = $indicadorOrden;
                    }

                    $sTablaHTML .= "<th scope=\"col\"  id=\"hc" . $nCont . "\" width=\"" . $sAnchoCampo[$c] . "\" ><a href=\"" . $url . "&campo=" . $sNombreCampo . "&ordenar=" . $ordenarEnForma . "&page=" . $page . "\">" . $sNombreCampo2[$c] . $aplicar . "</a></th>\n";

                    ++$nCont;
                }#cierra FOR



                $sTablaHTML .= "<th scope=\"col\" width=\"15\" id=\"hc" . $nCont . "\">&nbsp;</th>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                /* aclara mis dudas */
            } else { #cierra 2do IF
                $sTablaHTML .= "El n&uacute;mero de campos no es v&aacute;lido";
            }

            //

            /*             * *************************************************************** */

            /* 2da tabla para mostrar los registros */

            /*             * *************************************************************** */

            if ($nNumFilas > 0) {

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";


                while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $colorPintar = "#f1ff11";

                    //onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\"

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" id=\"tr" . $nfil . "\" onclick=\"seleccionPintaFilaAux(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\" width=\"25\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $metaId = $rs->getColumnMeta(0);

                        $sTablaHTML .= "<input type=\"checkbox\" name=\"chksele[]\" id=\"chk" . $nfil . "\" value=\"" . $fila[$metaId['name']] . "\" onclick=\"seleccionPintaFila(" . $nfil . ",this,'" . $sColorFila . "','" . $colorPintar . "')\">\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $meta = $rs->getColumnMeta($fc);

                            $sNombreCampo = $meta['name']; #nombre de todos los campos

                            $sContenido = (!empty($fila[$sNombreCampo]) ? $fila[$sNombreCampo] : "-");

                            if (empty($sContenido)) {

                                $sTablaHTML .= "<td>&nbsp;</td>\n";
                            } else {

                                if ($fc == 0) {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . sprintf("%07d", $sContenido) . "</div></td>\n";
                                } else {

                                    $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" width=\"" . $sAnchoCampo[$fc] . "\"><div class=\"textoContenido\">" . $sContenido . "</div></td>\n";
                                }
                            }

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td width=\"15\">&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE



                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tr>\n";

                $sTablaHTML .= "<td>\n";

                //************************ aqui NAVEGADOR DE REGISTROS    





                if ($num_rows != 0) {

                    $nextpage = $page + 1;

                    $prevpage = $page - 1; // puesto por MI

                    $pageActual = $page;

                    $sTablaHTML .= "<ul id=\"pagination-digg\">";

                    //SI ES LA PRIMERA P?GINA DESHABILITO EL BOTON DE PREVIOUS, MUESTRO EL 1 COMO ACTIVO Y MUESTRO EL RESTO DE P?GINAS

                    if ($page == 1) {

                        $sTablaHTML .= "<li class=\"previous-off\">&laquo; Anterior</li>";

                        $sTablaHTML .= "<li class=\"active\">1</li>"; // si la pagina no esta definida vale 1 y se muestra activo 1

                        for ($i = $page + 1; $i <= $lastpage; $i++) { // comienza a leer desde la pagina 2
                            if ($i <= $num_page_view) {

                                $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                            }
                        }

                        //Y SI LA ULTIMA P?GINA ES MAYOR QUE LA ACTUAL MUESTRO EL BOTON NEXT O LO DESHABILITO

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    } else { // si pagina es mayor a 1
                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=1&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">&laquo; Inicio</a></li>";

                        $sTablaHTML .= "<li class=\"previous\"><a href=\"" . $url . "&page=" . $prevpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\"> &laquo; Anterior</a></li>";



                        $dif = $num_page_view + $page; // calculo para mostrar siempre 5 paginas;



                        for ($i = $page; $i <= $lastpage; $i++) {

                            //COMPRUEBO SI ES LA PAGINA ACTIVA O NO

                            if ($page == $i) {

                                $sTablaHTML .= "<li class=\"active\">" . $i . "</li>"; // si la pagina enviada es = ala mostrada entonces se selecciona 
                            } else {

                                if ($i < $dif) {

                                    $sTablaHTML .= "<li><a href=\"" . $url . "&page=" . $i . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">" . $i . "</a></li>";
                                }
                            }
                        }



                        //SI NO ES LA ?LTIMA P?GINA ACTIVO EL BOTON NEXT    

                        if ($lastpage > $page) {

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $nextpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Siguiente &raquo;</a></li>";

                            $sTablaHTML .= "<li class=\"next\"><a href=\"" . $url . "&page=" . $lastpage . "&txtValorabuscar=" . $txtValorabuscar . "&rdbBuscar=" . $rdbBuscar . "\">Ultimo &raquo;</a></li>";
                        } else {

                            $sTablaHTML .= "<li class=\"next-off\">Next &raquo;</li>";
                        }
                    }

                    $sTablaHTML .= "</ul>";
                }





                //************************ FIN DE NAVEGADOR DE REGISTROS    

                $sTablaHTML .= "</td>\n";

                $sTablaHTML .= "</tr>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
            } else {

                //** 3

                /*                 * *********************************************************************************************

                  Si la tabla se encuentra vac?a, mostrar filas vac?as para decorar la GRILLA

                 * ********************************************************************************************* */

                $sTablaHTML .= "<div id=\"traerDatos\">\n"; # Div para la carga de datos con AJAX

                $sTablaHTML .= "<div id=\"scrollGrilla\">\n"; # Div para el SCROLL

                $sTablaHTML .= "<table class=\"tblMnt\" border=\"1\" width=\"" . $anchoTbl . "\">\n";

                $sTablaHTML .= "<tbody>\n";



                $nFilasVacias = 10;

                for ($f = 0; $f <= $nFilasVacias; $f++) {

                    ++$nfil;

                    if (($nfil % 2 == 1)) {

                        $sEstiloFila = "f1";

                        $sColorFila = "#e5f1f4";
                    } else {

                        $sEstiloFila = "f2";

                        $sColorFila = "#f8fbfc";
                    }

                    $sTablaHTML .= "<tr class=\"" . $sEstiloFila . "\" onmouseover=\"uno(this,'#ecfbd4');\" onmouseout=\"uno(this,'" . $sColorFila . "');\">\n";

                    if ($nfil == 1) {

                        $sTablaHTML .= "<th scope=\"row\" id=\"bc0\" width=\"10\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td id=\"bc1\" align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";



                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td id=\"bc" . $nContAux . "\" >&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td id=\"bc" . $nContAux . "\">&nbsp;</td>";
                    } else {

                        $sTablaHTML .= "<th scope=\"row\">&nbsp;</th>\n";

                        $sTablaHTML .= "<td align=\"center\">\n";

                        $sTablaHTML .= "&nbsp;\n";

                        $sTablaHTML .= "</td>\n";

                        for ($fc = 0; $fc < $nNumCampos; $fc++) {

                            $sTablaHTML .= "<td>&nbsp;</td>\n";

                            ++$nContAux;
                        }

                        $sTablaHTML .= "<td>&nbsp;</td>\n";
                    }

                    $sTablaHTML .= "</tr>\n";
                }#fin del WHILE

                $sTablaHTML .= "</tbody>\n";

                $sTablaHTML .= "</table>\n";

                $sTablaHTML .= "</div>\n"; # cierra Div para el SCROLL

                $sTablaHTML .= "</div>\n"; # cierra Div zona AJAX
                //**3
            }
        } else { # cierra 1er IF
            $sTablaHTML .= "La consulta enviada no es v&aacute;lida : <br>" . mysql_error();
        }

        return $sTablaHTML;
    }

}

?>