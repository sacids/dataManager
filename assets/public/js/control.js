/*Without jQuery Cookie*/
$(document).ready(function(){
	$("#parent1").css("display","none");
            
    $(".options").click(function(){
    	if ($('input[name=loan_option]:checked').val() == "Group" ) {
        	$("#parent1").slideDown("fast"); //Slide Down Effect   
        } else {
            $("#parent1").slideUp("fast");	//Slide Up Effect
        }
     });            
});