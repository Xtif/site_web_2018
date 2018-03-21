$(document).ready(function() {

  //Scrool smooth vers une ancre
  $('a[href^="#"]').click(function(evt) // au clic sur un lien avec une ancre, contenant donc un #
  {
  	// bloquer le comportement par défaut: on ne rechargera pas la page
    evt.preventDefault(); 
    // enregistre la valeur de l'attribut href dans la variable target
		var target = $(this).attr('href');

    //le sélecteur $(html, body) permet de corriger un bug sur chrome et safari (webkit)
		$('html, body').stop().animate({scrollTop: $(target).offset().top}, 1000);
    // on arrête toutes les animations en cours 
    // on fait maintenant l'animation vers le haut (scrollTop) vers notre ancre target
  });

});