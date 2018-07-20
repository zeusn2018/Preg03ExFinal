<?php

class Conexion {

    private $cn;
    private $db;
    private $server;
    private $user;
    private $password;
    private $dataBase;

    function __construct($server, $user, $password, $dataBase) {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->dataBase = $dataBase;
    }

    public function 
            getConexion() {
                $this->cn = NULL;
                try {

                    $cn = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->dataBase . "", $this->user, $this->password);
                    $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $this->cn = $cn;
                    $this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                    
                                        
                } catch (PDOException $e) {
                    //$this->cn = $e->__toString();
                    echo "ERROR: " . $e->getMessage()."---";

                }
                return $this->cn;
    }

}

?>
