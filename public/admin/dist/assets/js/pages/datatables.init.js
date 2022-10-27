$(document).ready(function() {

 

    $("#usertable").DataTable({
        "sDom": 'f<"top">tip',
        "language": {

            "processing": "Traitement en cours...",

            "search": "Rechercher",

            "width": "10%",

            "lengthMenu": "Afficher _MENU_ ",

            "info": "Affichage de _START_ &agrave; _END_ sur _TOTAL_ ",

            "infoEmpty": "Affichage de 0 &agrave; 0 sur 0 ",

            "infoFiltered": "(filtr&eacute; de _MAX_  au total)",

            "infoPostFix": "",

            "loadingRecords": "Chargement en cours...",

            "zeroRecords": "Rien &agrave; afficher",

            "emptyTable": "Aucune donnée disponible dans le tableau",

            "paginate": {

                first: "Premier",

                previous: "Pr&eacute;c&eacute;dent",

                next: "Suivant",

                last: "Dernier"

            },

        }
    });


   


    $("#demande").DataTable({

        "order": [0, "desc" ],
       

        "sDom": 'f<"top">tip',
        "language": {

            "processing": "Traitement en cours...",

            "search": "Rechercher",

            "width": "10%",

            "lengthMenu": "Afficher _MENU_ ",

            "info": "Affichage de _START_ &agrave; _END_ sur _TOTAL_ ",

            "infoEmpty": "Affichage de 0 &agrave; 0 sur 0 ",

            "infoFiltered": "(filtr&eacute; de _MAX_  au total)",

            "infoPostFix": "",

            "loadingRecords": "Chargement en cours...",

            "zeroRecords": "Rien &agrave; afficher",

            "emptyTable": "Aucune donnée disponible dans le tableau",

            "paginate": {

                first: "Premier",

                previous: "Pr&eacute;c&eacute;dent",

                next: "Suivant",

                last: "Dernier"

            },

        }
    });

 


  
});