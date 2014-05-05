<?php
	require_once 'Conexion.php';
	require_once 'Modelo.php';
	public class Persona extends Modelo{
		private $IdPersona=0;
		private $ApellidoP='';
		private $ApellidoM='';
		private $Nombre='';
		private $IdGenero=0;
		private $DiaN=0;
		private $MesN=0;
		private $AnioN=0;
		private $DiaD=0;
		private $MesD=0;
		private $AnioD=0;
		private $Biografia='';
		public function __construct($_IdPersona=0){
			$this->IdPersona=$_IdPersona;
	        if ($_IdPersona>0){
	            $dbContext=new Conn('localhost','root','');
	            $dbConn=$dbContext->getConn();
	            $query=sprintf("SELECT IdPersona,ApellidoP,ApellidoM,Nombre,IdGenero,DiaN,MesN,AnioN,DiaD,MesD,AnioD,Biografia 
	                FROM Persona WHERE IdPersona=%s",mysql_real_escape_string($_IdPersona));
	            $res=mysql_query($query,$dbConn);
	            if (!$res) {
	                $mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
	                $mensaje .= 'Consulta completa: ' . $consulta;
	                die($mensaje);
	            }
	            $fila = mysql_fetch_assoc($res);
	            $this->set($fila);
	            mysql_free_result($res);
	        }
		}
		public function Guardar(){
			$query="";
			if ($this->IdPersona>0){
				$query=sprintf("Update Persona set ApellidoP='%s',ApellidoM='%s',Nombre='%s',Biografia='%s',
					IdGenero=%s,DiaN=%s,MesN=%s,AnioN=%s,DiaD=%s,MesD=%s,AnioD=%s where IdPersona=%s",
              $this->ApellidoP,$this->ApellidoM,$this->Nombre,$this->Biografia,$this->IdGenero,
              $this->DiaN,$this->MesN,$this->AnioN,$this->DiaD,$this->MesD,$this->AnioD,$this->IdPersona);
			}else{
				$query=sprintf("insert into Persona(ApellidoP,ApellidoM,Nombre,Biografia,
					IdGenero,DiaN,MesN,AnioN,DiaD,MesD,AnioD)
              Values('%s','%s','%s','%s',%s,%s,%s,%s,%s,%s,%s)",
              $this->ApellidoP,$this->ApellidoM,$this->Nombre,$this->Biografia,$this->IdGenero,
              $this->DiaN,$this->MesN,$this->AnioN,$this->DiaD,$this->MesD,$this->AnioD);
			}
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
	        $res=mysql_query($query,$dbConn);
	        if(!$res){
	            return "Ha ocurrido un error: ".mysql_error()."<br/> en ".$query;
	        }
	        return "Insercion exitosa";
		}
		public function getListCB($_IdGenero=0){
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
			$query=sprintf("SELECT IdPersona,ApellidoP,ApellidoM,Nombre,IdGenero,DiaN,MesN,AnioN,DiaD,MesD,AnioD,Biografia 
	            FROM Persona");
			$where="";
	        if($_IdGenero>0){
	            $where=" Where IdGenero=".$_IdGenero;
	        }
	        $query=$query." ".$where;
	        $res=mysql_query($query,$dbConn);
	        if (!$res) {
	            $mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
	            $mensaje .= 'Consulta completa: ' . $consulta;
	            die($mensaje);
	        }
	        $arr=array();
	        while($fila = mysql_fetch_assoc($res)){
	            $arr[]=array(
	                'Id'=>$fila['IdPersona'],
	                'Descripcion'=>$fila['ApellidoP'].' '.$fila['ApellidoM'].' '.$fila['Nombre']
	            );
	        }
	        
	        mysql_free_result($res);
	        return $arr;
		}
	}
?>