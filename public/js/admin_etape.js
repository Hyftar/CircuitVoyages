function getCircuitEtapes(circuit_id) {
  disablePops()
  $.ajax({
    url: '/admin_circuits_etapes',
    type: 'POST',
    data:{circuit_id},
    success: (data) => {
      let containter = document.getElementById('contenu');
      containter.innerHTML = data;
      enablePops();
    }
  })
}

function getSteps_create(circuit_id) {
  $.ajax({
    url: 'admin_creation_etape_simple',
    type: 'POST',
    data: {circuit_id},
    success: (data) => {
      let container = document.getElementById('modalContenuEtape');
      container.innerHTML = data;
      $('#modalCreationEtape').modal('toggle');
    }
  })
}

function creerEtape(){
  let form = new FormData(document.getElementById('formCreateEtape'));
  $.ajax({
    url: 'admin_etape_simple_create',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreationEtape').modal('toggle');
      getCircuitEtapes(form.get('circuit_id'));
    }
  })
  return false;
}

function getSteps_update(id) {
  $.ajax({
    url: 'admin_etape_getupdate',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuEtape');
      container.innerHTML = data;
      $('#modalUpdateEtape').modal('toggle')
    }
  })
}

function modifierEtape(){
  let form = new FormData(document.getElementById('formUpdateEtape'));
  $.ajax({
    url: 'admin_etape_update',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalUpdateEtape').modal('toggle');
      getCircuitEtapes(form.get('circuit_id'));
    }
  })
  return false;
}

function supprimerStep(id, circuit_id){
  let test = confirm("Êtes-vous certain de retirer cette étape ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_etape',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'html',
      success: (data) => {
        getCircuitEtapes(circuit_id);
      }
    })
  }
}
