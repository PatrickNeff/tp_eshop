$(document).ready(function() // une fois le document chargé
{
	$('.search').keyup(function() // on selection le champ 'search' qui, dès qu'on relache une touche, va lire la fonction. 
	{
		input_results = $(this).val(); // on assigne a input_results le résultat de l'input
		//alert(input_results);
		if( input_results.length > 2) // on utilise ajax partir du moment ou on a entré minimum 1 caratère
		{
			$.post('index.php?ajax=search', // On fait le lien vers l'index.php (qui utilise la méthode POST)
			{
				"search" : input_results // on envoie le résultat de (input_results) de notre input (qui a la classe search)
				//data : $(this).val(),
			}, function(data)
			{
				$('.container.body.section').html(data);
			});
		}
	});

	$('#search-form').submit(function(info) 
	{
		info.preventDefault(); // permet de bloquer le comportement normal de notre formulaire (#search-form)
		input_results = $(this).find('.search').val(); // on assigne a input_results le résultat de l'input

			$.post('index.php?ajax=search',
			{
				"search" : input_results

			}, function(data)
			{
				$('.container.body.section').html(data);
			});
		return false; // obligatoir avec la fonction info.preventDefault();
	});
});