var init=function(){
	$("a").on("click",loadLink);
};
$(document).on("ready",init);
var loadLink=function(event){
	event.preventDefault();
	var url=$(this).attr("href");
	$(".container").load(url);
	return false;
}