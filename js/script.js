$(document).ready(function() {
    
        $("#envoiRecherche").click(function(event) {
            if ($("#recherche").val() == '') {
                event.preventDefault();
                $('#recherche').attr('placeholder','Que rechercher-vous?');
            } 
        })
});
