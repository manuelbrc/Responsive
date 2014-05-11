$.ajaxSetup ({
    cache: false
});



var loadLink=function(event){
    event.preventDefault();
    var url=$(this).attr("href");
    $(".container").load(url);
    return false;
};
var responsiveMenu=function(event){
    event.preventDefault();
    $("nav ul").slideToggle();
};
$(window).resize(function(){
    var menu=$("nav ul");
    var w = $(window).width();
    if(w > 480 && menu.is(':hidden')) {
        menu.removeAttr('style');
    }
});
var init=function(){
    //$("a").on("click",loadLink);
    $("#pullMenu").on("click",responsiveMenu);
    
};
$(document).on("ready",init);

var posicionarMenu=function() {

    var altura_del_header = $('header').outerHeight(true);
    var altura_del_menu = $('nav').outerHeight(true);
    if ($(window).scrollTop() >= altura_del_header){
        $('nav').addClass('fixed');
        $('.container').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('nav').removeClass('fixed');
        $('.container').css('margin-top', '0');
    }
};

$(window).scroll(posicionarMenu);



