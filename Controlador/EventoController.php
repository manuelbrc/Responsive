<?php
require_once dirname(__FILE__).'/../modelo/Evento.php';
class EventoController{
	function getEventos(){
		$oe=new Evento();
		return $oe->getList();
	}
	function getEvento($data){
		if (isset($data["IdEvento"])){
            $oe=new Evento($data["IdEvento"]);
            return $op->get();
        }
        return 'Ha ocurrido un error';
	}
	function guardaEvento($data){
		$oe = new Evento();
		$oe->set($data);
		return $oe->Guardar();
	}
}
?>