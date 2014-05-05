<?php
	require_once 'Conexion.php';
	require_once 'Modelo.php';
	public class Logia extends Modelo{
		private $IdLogia=0;
		private $Nombre='';
		private $Descripcion='';
		private $IdFundador=0;
		private $DiaN=0;
		private $MesN=0;
		private $AnioN=0;
		public function __construct($_IdLogia=0){
			$this->IdLogia=$_IdLogia
			if ($_IdLogia>0){
				$dbContext=new Conn('localhost','root','');
	            $dbConn=$dbContext->getConn();
	            $query=sprintf("SELECT IdLogia,Nombre,Descripcion,IdFundador,DiaN,MesN,AnioN FROM Logia WHERE IdLogia=%s",mysql_real_escape_string($_IdLogia));
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
			if ($this->IdLogia>0){
				$query=sprintf("Update Logia set Nombre='%s',Descripcion='%s',IdFundador=%s,DiaN=%s,MesN=%s,AnioN=%s where IdLogia=%s",
              		$this->Nombre,$this->Descripcion,$this->IdFundador,$this->DiaN,$this->MesN,$this->AnioN,$this->IdLogia);
			}else{
				$query=sprintf("insert into Logia(Nombre,Descripcion,IdFundador,DiaN,MesN,AnioN) Values('%s','%s',%s,%s,%s,%s)",
					$this->Nombre,$this->Descripcion,$this->IdFundador,$this->DiaN,$this->MesN,$this->AnioN);
			}
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
	        $res=mysql_query($query,$dbConn);
	        if(!$res){
	            return "Ha ocurrido un error: ".mysql_error()."<br/> en ".$query;
	        }
	        return "Insercion exitosa";
		}
		public function getListCB(){
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
			$query=sprintf("SELECT IdLogia,Nombre,Descripcion,IdFundador,DiaN,MesN,AnioN FROM Logia");
			$where="";
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
	                'Descripcion'=>$fila['Nombre']
	            );
	        }
	        
	        mysql_free_result($res);
	        return $arr;
		}
	}
?>