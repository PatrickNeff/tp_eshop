$(document).ready(function() // une fois le document chargé
{
	// $("#valider").click(function(){
	// 	$(location).attr('href',"index.php?page=validate")
	// });
	$("#retour").click(function(){
		$(location).attr('href',"index.php?page=catalogue")
	});

	$("#annuler").click(function(){
	    $.ajax({
	       url : 'panier/annuler.php',
	       type : 'POST',
	       dataType : 'php'
	    });
	});
});