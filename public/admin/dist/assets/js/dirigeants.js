$("#idBtnAjoutDirigeants").click(function () {
    if ($('#idnationalite_dirigeant').val() != "SN") {
            document.getElementById("idcni_dirig").removeAttribute('pattern');
        }
    document.getElementById("idnationalite_dirigeant").removeAttribute('required');
    document.getElementById("idcni_dirig").removeAttribute('required');
    document.getElementById("idDatcni_dirig").removeAttribute('required');
    document.getElementById("idPassport").removeAttribute('required');
    document.getElementById("idDatepassport_dirig").removeAttribute('required');
    document.getElementById("idcivilite_dirig").removeAttribute('required');
    document.getElementById("prenom").removeAttribute('required');
    document.getElementById("idnom").removeAttribute('required');

    document.getElementById("idSexe_dirig").removeAttribute('required');
    document.getElementById("idDatenais_dirig").removeAttribute('required');
    //document.getElementById("idlieunais").removeAttribute('required');
    document.getElementById("idqualification").removeAttribute('required');
        
});

    
$("#idBtnAnnulerAjoutDirigeant").click(function () {
        document.getElementById("idPageAjoutDirigeants1").style.display = "none";
        document.getElementById("idPageAjoutDirigeants2").style.display = "none";
        document.getElementById("idGroupeBtnAjoutDirigeants").style.display = "none";

    });

function ajoutModifDirigeant() 
{

    if ($('#idnationalite_dirigeant').val() != "SN") {
        document.getElementById("idcni_dirig").removeAttribute('pattern');
    }
    var idDirigeantAM = document.getElementById("idDirigeantAM").value;

    if(idDirigeantAM !=""){
        document.forms['formDirigeant'].action="{{path('modifierDirigeants')}}"+ "/" + idDirigeantAM;
    //  alert(document.forms['formDirigeant'].action);
    }
}


function modifierDirigeants (id) 
{
    // alert(id);
    document.forms['formDirigeant'].action="{{path('modifierDirigeants')}}"+ "/" +id;
        //        alert(document.forms['formDirigeant'].action);
        if ($('#idnationalite_dirigeant').val() != "SN") {
            document.getElementById("idcni_dirig").removeAttribute('pattern');
        }
    document.getElementById("idnationalite_dirigeant").removeAttribute('required');
    document.getElementById("idcni_dirig").removeAttribute('required');
    document.getElementById("idDatcni_dirig").removeAttribute('required');
    document.getElementById("idPassport").removeAttribute('required');
    document.getElementById("idDatepassport_dirig").removeAttribute('required');
    document.getElementById("idcivilite_dirig").removeAttribute('required');
    document.getElementById("prenom").removeAttribute('required');
    document.getElementById("idnom").removeAttribute('required');

    document.getElementById("idSexe_dirig").removeAttribute('required');
    document.getElementById("idDatenais_dirig").removeAttribute('required');
    //document.getElementById("idlieunais").removeAttribute('required');
    document.getElementById("idqualification").removeAttribute('required');
    
    // alert(document.forms['formDirigeant'].action);
}


function traceDirigeants (id) {
    let route = "{{ path('tracerDirigeant') }}" + "/" +id;
    alert(route);
    $.ajax({
        type: 'GET',
        url: route,
        success: function (data) {
        document.getElementById('body').innerHTML = "";
        document.getElementById('body').innerHTML = data;
        
        $(".editPersonne").modal('show');		
        },
        error: function (error) {
            
        console.log(error);
        }
    });
}


function supprimerDirigeants (id) {
// alert(id);
document.forms['formDirigeant'].action="{{path('supprimerDirigeants')}}"+ "/" +id;

if ($('#idnationalite_dirigeant').val() != "SN") {
    document.getElementById("idcni_dirig").removeAttribute('pattern');
 }
document.getElementById("idnationalite_dirigeant").removeAttribute('required');
document.getElementById("idcni_dirig").removeAttribute('required');
document.getElementById("idDatcni_dirig").removeAttribute('required');
document.getElementById("idPassport").removeAttribute('required');
document.getElementById("idDatepassport_dirig").removeAttribute('required');
document.getElementById("idcivilite_dirig").removeAttribute('required');
document.getElementById("prenom").removeAttribute('required');
document.getElementById("idnom").removeAttribute('required');

document.getElementById("idSexe_dirig").removeAttribute('required');
document.getElementById("idDatenais_dirig").removeAttribute('required');
document.getElementById("idqualification").removeAttribute('required');

}

$('#idcivilite_dirig').change(function () {
    if (document.getElementById("idcivilite_dirig").value == "1") {
        
        let departement = document.getElementById("idSexe_dirig");
        departement.innerHTML = "";
                
        let opt = document.createElement('option');
        opt.innerHTML = "Masculin";
        opt.value = '1';
        departement.add(opt);
    
    } else {
        
        let departement = document.getElementById("idSexe_dirig");
        departement.innerHTML = "";
                
        let opt = document.createElement('option');
        opt.innerHTML = "Féminin";
        opt.value = '2';
        departement.add(opt);

    }

});

