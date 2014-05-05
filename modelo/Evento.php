<?php
	require_once 'Conexion.php';
	require_once 'Modelo.php';
	class Evento extends Modelo
	{
		private $IdEvento=0;
		private $IdEventoP=0;
		private $Nombre='';
		private $Detalle='';
		private $DiaI=0;
		private $MesI=0;
		private $AnioI=0;
		private $DiaF=0;
		private $MesF=0;
		private $AnioF=0;
		function __construct($_IdEvento=0)
		{
			$this->IdEvento=$_IdEvento;
	        if ($_IdEvento>0){
	            $dbContext=new Conn('localhost','root','');
	            $dbConn=$dbContext->getConn();
	            $query=sprintf("SELECT IdEvento,IdEventoP,Nombre,Detalle ,DiaI,MesI,AIioI,DiaF,MesF,AnioF
	                FROM Evento WHERE IdEvento=%s",mysql_real_escape_string($_IdEvento));
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
		function Guardar(){
			$query="";
			if ($this->IdEvento>0){
				$query=sprintf("Update Evento set IdEventoP=%s,Nombre='%s',Detalle='%s',
					Diai=%s,MesI=%s,AnioI=%s,DiaF=%s,MesF=%s,AnioF=%s where IdEvento=%s",
              $this->IdEventoP,$this->Nombre,$this->Detalle,
              $this->DiaI,$this->MesI,$this->AnioI,$this->DiaF,$this->MesF,$this->AnioF,$this->IdEvento);
			}else{
				$query=sprintf("insert into Evento(IdEventoP,Nombre,Detalle,
					DiaI,MesI,AnioI,DiaF,MesF,AnioF)
              Values('%s','%s','%s','%s',%s,%s,%s,%s,%s,%s,%s)",
              $this->IdEventoP,$this->Nombre,$this->Detalle,$this->DiaI,$this->MesI,$this->AnioI,$this->DiaF,$this->MesF,$this->AnioF);
			}
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
	        $res=mysql_query($query,$dbConn);
	        if(!$res){
	            return "Ha ocurrido un error: ".mysql_error()."<br/> en ".$query;
	        }
	     	return "Insercion exitosa";
		}
		function getList(){
	        $dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
	        $query=" select *
	                FROM vEventos
	            order by AnioI,MesI,DiaI";
	        $res=mysql_query($query,$dbConn);
	        if (!$res) {
	            $mensaje  = 'Consulta no válida: ' . mysql_error() . "\n";
	            $mensaje .= 'Consulta completa: ' . $query;
	            die($mensaje);
	        }
	        $arr=array();
	        while($fila = mysql_fetch_assoc($res)){
	        	$fila["Tags"]=$this->getTags($fila["IdEvento"],$dbConn);
	            $arr[]=$fila;

	        }
	        
	        mysql_free_result($res);
	        return $arr;
	     }
	     function getTags($_IdEvento,$dbConn){
	     	//$dbContext=new Conn('localhost','root','');
	        //$dbConn=$dbContext->getConn();
	        $query=" select Nombre
	                FROM vEventosTag
	            order by idtag asc";
	        $res=mysql_query($query,$dbConn);
	        $arr=array();
	        while($fila = mysql_fetch_assoc($res)){
	            $arr[]=$fila['Nombre'];
	        }
	        //mysql_free_result($res);
	        return $arr;
	     }
		function getListCB(){
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
			$query=sprintf("SELECT IdEvento,IdEventoP,Nombre,Detalle,DiaI,MesI,AnioI,DiaF,MesF,AnioF
	            FROM Evento");
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
	                'Id'=>$fila['IdEvento'],
	                'Descripcion'=>$fila['Nombre']
	            );
	        }
	        
	        mysql_free_result($res);
	        return $arr;
		}
	}
?>