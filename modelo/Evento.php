<?php
	require_once 'Conexion.php';
	require_once 'Modelo.php';
	class Evento extends Modelo
	{
		protected $IdEvento=0;
		protected $IdEventoP=0;
		protected $Nombre='';
		protected $Detalle='';
		protected $DiaI=0;
		protected $MesI=0;
		protected $AnioI=0;
		protected $DiaF=0;
		protected $MesF=0;
		protected $AnioF=0;
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
              Values(%s,'%s','%s',%s,%s,%s,%s,%s,%s)",
              $this->IdEventoP,$this->Nombre,$this->Detalle,$this->DiaI,$this->MesI,$this->AnioI,$this->DiaF,$this->MesF,$this->AnioF);
			}
			$dbContext=new Conn('localhost','root','');
	        $dbConn=$dbContext->getConn();
	        $res=mysql_query($query,$dbConn);
	        if(!$res){
	            return "Ha ocurrido un error: ".mysql_error()."<br/> en ".$query;
	        }
	     	return "Los datos se han guardado correctamente";
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
	        	///$fila= array_map('utf8_encode',$fila);
	        	$fila["DiaI"]=$fila["DiaI"]+0;
	        	$fila["DiaF"]=$fila["DiaF"]+0;
	        	$fila["MesI"]=$fila["MesI"]+0;
	        	$fila["MesF"]=$fila["MesF"]+0;
	        	$fila["AnioI"]=$fila["AnioI"]+0;
	        	$fila["AnioF"]=$fila["AnioF"]+0;
	        	$fila["Tags"]=$this->getTags($fila["IdEvento"],$dbConn);
	            $arr[]=$fila;

	        }
	        mysql_free_result($res);
	        return $arr;
	     }
	     function getTags($_IdEvento,$dbConn){
	     	//$dbContext=new Conn('localhost','root','');
	        //$dbConn=$dbContext->getConn();
	        $query=" select idtag,Nombre
	                FROM vEventosTag
	                where idevento={$_IdEvento}
	            order by idtag asc";
	        $res=mysql_query($query,$dbConn);
	        
	        $arr=array();
	        while($fila =mysql_fetch_assoc($res)){
	        	//$fila= array_map('utf8_encode',$fila);
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