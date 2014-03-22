$.ajaxSetup ({
    cache: false
});

var requestHandler={
    params:{},
    container:'.container',
    Controller:'',
    Action:'',
    init:function(form,Controller,Action,dpost,successCallback,errorCallback,finalCallback){
        this.form=form;
        if(successCallback!='')this.successCallback=successCallback;
        if(errorCallback!='')this.errorCallback=errorCallback;
        if(finalCallback!='')this.finalCallback=finalCallback;
        this.params=(form=='')?dpost:jQuery.parseJSON(JSON.stringify($('#'+form).serializeObject()));
        this.Controller=Controller;
        this.Action=Action;
    },
    doRequest:function(){
        $.ajax({
            type: "POST",
            url: 'callHandlerMVC.php',
            dataType: 'json',
            data: {
                data:this.params,
                Controlador:this.Controller,
                Accion:this.Action
            },
            statusCode:{
                404:function(){
                    console.log('No se encontro la madre esa');
                }
            },
            success: this.successCallback,
            error:this.errerrorCallback,
            complete:this.finalCallback
        });
    },
    successCallback:function(){
        
    },
    errorCallback:function(){
        console.log('algo trono');
    },
    finalCallback:function(){
        console.log('y termino esta madre');
    }
};

var loadLink=function(event){
    event.preventDefault();
    var url=$(this).attr("href");
    $(".container").load(url);
    return false;
};
var init=function(){
	$("a").on("click",loadLink);
    /*
    var peticion=Object.create(requestHandler);
    peticion.type='al 100';
    peticion.doRequest();
    */
};
$(document).on("ready",init);

posicionarMenu();

$(window).scroll(function() {    
    posicionarMenu();
});

function posicionarMenu() {

    var altura_del_header = $('header').outerHeight(true);
    var altura_del_menu = $('nav').outerHeight(true);

    if ($(window).scrollTop() >= altura_del_header){
        $('nav').addClass('fixed');
        $('.container').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('nav').removeClass('fixed');
        $('.container').css('margin-top', '0');
    }
}