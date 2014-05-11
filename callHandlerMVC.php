<?php
header('Content-Type: application/json');
if (isset($_FILES["Imagen"])){
    if ($_FILES["Imagen"]["error"] > 0) {
        echo json_encode("Error: " . $_FILES["Imagen"]["error"] . "<br>");
    } else {
        
        //echo "Uploaded File :" . $_FILES["myfile"]["name"];
        $aname="guardaImagen";
        $cname="ImagenController";
        require_once 'Controlador/'.$cname.'.php';
        $data=array();
        $data["IdPersona"]=$_POST["IdPersona"];
        $data["Principal"]=$_POST["Principal"];
        $name = $_FILES["Imagen"]["name"];
        $ext = end(explode(".", $name));
        $date = new DateTime();
        $data["URL"]="Imagenes/Imagen_".$date->format('Y-m-d H_i_s').".".$ext;
        move_uploaded_file($_FILES["Imagen"]["tmp_name"],  $data["URL"]);
        if (class_exists($cname)){
            $obj=new $cname();
            if(method_exists($obj, $aname)){
                echo json_encode($obj->$aname($data));
            }
        }
        

            

        
        echo json_encode("Archivo subido con exito ".$_POST['IdPersona']);
    }
}else{
    $aname=$_POST["Accion"];
    $cname=$_POST["Controlador"]."Controller";
    require_once 'Controlador/'.$cname.'.php';
    
    $data=$_POST["data"];
    if (class_exists($cname)){
        $obj=new $cname();
        if(method_exists($obj, $aname)){
            //json_encode($obj->$aname($data));
            $cad="";
            $arr=array();
            $arr=$obj->$aname($data);
            echo json_encode($arr);
        }else{
            echo json_encode('Error 404 - La acción solicitada no existe');
        }
    }else{
        echo json_encode('Error 404 - La acción solicitada no existe');
    }
} 
?>