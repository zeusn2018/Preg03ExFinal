<?php

class EntidadAlumnos {
    
private $idAlumno;    
private $nombre; 
private $tipo_alumno; 



    function __construct() {
        
    }
    function getIdAlumno() {
        return $this->idAlumno;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTipo_alumno() {
        return $this->tipo_alumno;
    }
    function setIdAlumno($idAlumno) {
        $this->idAlumno = $idAlumno;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setTipo_alumno($tipo_alumno) {
        $this->tipo_alumno = $tipo_alumno;
    }



}
?>


