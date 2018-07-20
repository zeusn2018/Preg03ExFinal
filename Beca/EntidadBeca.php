<?php

class EntidadAlumnos {
    
private $idBeca;    
private $nombreBeca; 
private $tipo_beca; 
private $monto_beca; 

    function __construct() {
        
    }
    function getIdBeca() {
        return $this->idBeca;
    }

    function getNombreBeca() {
        return $this->nombreBeca;
    }

    function getTipo_beca() {
        return $this->tipo_beca;
    }
    function setIdBeca($idBeca) {
        $this->idBeca = $idBeca;
    }

    function setNombreBeca($nombreBeca) {
        $this->nombreBeca = $nombreBeca;
    }

    function setTipo_beca($tipo_beca) {
        $this->tipo_beca = $tipo_beca;
    }
    
    function getMonto_beca() {
        return $this->monto_beca;
    }
    
    function setMonto_beca($monto_beca) {
        $this->monto_beca = $monto_beca;
    }






}
