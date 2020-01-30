function supprimerCircuitTrip(id) {
  let test = confirm("Êtes-vous certain de retirer ce départ ? Ce changement sera définitif.")
  if (test == true) {
    $.ajax({
      url: 'admin/delete_circuit_trip',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'html',
      success: (data) => {
        getCircuits()
      }
    })
  }
}

function getCircuitTrips(id) {
  $.ajax({
    url: 'admin/circuit_trips',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('contenu')
      container.innerHTML = data
    }
  })
}

function getCircuitsTrip_create(id) {
  $.ajax({
    url: 'admin/circuit_trip_create_modal',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit')
      container.innerHTML = data
      $('#modalCreateCircuitTrip').modal('toggle')
    }
  })
}

function getCircuitTrip_update(circuit_id, id) {
  $.ajax({
    url: 'admin/circuit_trip_update_modal',
    type: 'POST',
    data: {
      circuit_id: circuit_id,
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit')
      container.innerHTML = data
      $('#modalModifyCircuitTrip').modal('toggle')
    }
  })
}

function creerCircuitTrip() {
  let form = new FormData(document.getElementById('formCreateCircuitTrip'))
  $.ajax({
    url: 'admin/circuit_trip_create',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreateCircuitTrip').modal('toggle')
      getCircuitTrips(form.get('circuit_id'))
    }
  })
  return false
}

function modifierCircuitTrip() {
  let form = new FormData(document.getElementById('formModifyCircuitTrip'))
  $.ajax({
    url: 'admin/circuit_trip',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalModifyCircuitTrip').modal('toggle')
      getCircuitTrips(form.get('circuit_id'))
    }
  })
  return false
}
