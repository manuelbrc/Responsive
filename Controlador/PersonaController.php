<?php
require_once dirname(__FILE__).'/../modelo/Persona.php';
/**
* 
*/
public class PersonaController
{
	
	public function Guardar($data)
	{
		$op=new Persona(0);
        if (!isset($data["IdPersona"]))
            $data['IdPersona']=0;
        $op->set($data);
        return $op->Guardar();
	}
}
?>