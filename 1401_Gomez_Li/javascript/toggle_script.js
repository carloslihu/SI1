$(document).ready(function(){ 
   $('.toggler').on('click',function(e){
   	if($(this).text() == "expandir")
   		$(this).text("mostrar menos");
   	else
   		$(this).text("expandir");
   	$(this).text()
	$(this).parent().next().toggle();
	e.preventDefault();
   });
});