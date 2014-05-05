var requestHandler=function(attrs){
    var config={
        Params:{},
        Container:'.container',
        Controller:'',
        Action:'',
        Method:'POST',
        success:function(){
        	console.log("etsito");
        },
        error:function(){
        	console.log("trono");
        },
        complete:function(){
        	console.log("finito");
        }
    };
    $.extend(config,attrs);
    return {doRequest:function(){
        $.ajax({
            type: config.Method,
            url: 'callHandlerMVC.php',
            dataType: 'json',
            data: {
                data:config.Params,
                Controlador:config.Controller,
                Accion:config.Action
            },
            statusCode:{
                404:function(){
                    console.log('No se encontro la madre esa'+config.Action);
                }
            },
            success: config.success,
            error:   config.error,
            complete:config.complete
        });
    }};
};
var Persona=function(conf){
	var config={
		IdPersona:0,
		ApellidoP:'',
		ApellidoM:'',
		Nombre:'',
		IdGenero:0,
		DiaN:0,
		MesN:0,
		AnioN:0,
		DiaD:0,
		MesD:0,
		AnioD:0,
		Biografia:''
	};
	$.extend(config,conf);
	var guardarSucces=function(result){
		console.log(result);
	};
	return {
		Guardar:function(){
		}
	};
};

var Logia=function(conf){
	var config={
		IdLogia:0,
		Nombre:'',
		Descripcion:'',
		IdFundador:0,
		DiaN:0,
		MesN:0,
		AnioN:0
	};
	$.extend(config,conf);
	return {
		Guardar:function(){

		}
	};
};
var Evento=function(conf){
	var config={
		IdEvento:0,
		IdEventoP:0,
		Nombre:'',
		Detalle:'',
		DiaI:0,
		MesI:0,
		AnioI:0,
		DiaF:0,
		MesF:0,
		AnioF:0
	};
	$.extend(config,conf);
	return {
		Guardar:function(){

		}
	};
};


