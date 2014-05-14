<?php

class Modelo{
	function __construct(){

	}
	/**
     * Convierte un arreglo asociativo al objeto
     * @param array $arrayAssoc Arreglo
     * @return void
     */
     function set($data){
         $cad="";    
         foreach ($data as $key => $value) {
            if ($value=='')
                $this->{$key}='NULL';  
            else
                $this->{$key}=$value;  
             
         }
     }
    /**
     * Serializa el objeto 
     * @return array $var Arreglo que contiene al objeto
     */
    function get(){
        $var = get_object_vars($this);
        foreach($var as &$value){
           if(is_object($value) && method_exists($value,'getJsonData')){
              $value = $value->getJsonData();
           }
        }
        return $var;
     }
}
?>