<?php
/**
 * Conexión a servidor de bases de datos
 * @method MySQLLink getConn() Obtiene la conexión generada
 * @method void closeConn() Cierra la conexión generada
 */
class Conn {
    /**
     * @var MySQLLink $mySQLConn Conexión a mysql
     */
    private $mySQLConn;
    private $db;
    /**
     * Crea una conexión nueva a mySQL
     * @param string $servidor Nombre o IP del servidor
     * @param string $usuario Usuario de conexión a la base de datos
     * @param string $pwd Contraseña de usuario de base de datos
     */
    function __construct($servidor, $usuario, $pwd) {
        $this -> mySQLConn = mysql_connect($servidor, $usuario, $pwd);
        if (!$this -> mySQLConn) {
            die('No pudo conectarse: ' . mysql_error());
        }else{
            $this->db=mysql_select_db('historia',$this->mySQLConn);
            if(!$this->db){
                die('No se pudo seleccionar la base de datos');
            }
        }
    }

    function __destruct() {
        mysql_close($this -> mySQLConn);
    }

    /**
     * Serializa el objeto
     * @return array $var Arreglo que contiene al objeto
     */
    function getJsonData() {
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getJsonData')) {
                $value = $value -> getJsonData();
            }
        }
        return $var;
    }

    /**
     * Devuelve el objeto de la conexión
     * @return MySQLLink Objeto de conexión
     */
    function getConn() {
        return $this -> mySQLConn;
    }

    /**
     * Cierra la conexión
     */
    function closeConn() {
        mysql_close($this -> mySQLConn);
    }

}
?>