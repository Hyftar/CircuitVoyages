function getCircuits() {
  disablePops()
  $.ajax({
    url: '/admin/circuits',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('contenu')
      container.innerHTML = data
      enablePops();
    }
  })
}

// Code de Keven

function getCircuits_create() {
  $.ajax({
    url: '/admin/circuits/create',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit')
      container.innerHTML = data
      $(".selectpicker").selectpicker()
      $('#modalCreationCircuit').modal('toggle')
      $("select").imagepicker({
        show_label: true
      })
    }
  })
}

function getCircuits_update(id) {
  $.ajax({
    url: 'admin/circuit_update',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit')
      container.innerHTML = data
      $(".selectpicker").selectpicker()
      $('#modalUpdateCircuit').modal('toggle')
      $("select").imagepicker({
        show_label: true
      })
    }
  })
}

function creerCircuit() {
  let form = new FormData(document.getElementById('formCreateCircuit'))
  $.ajax({
    url: 'admin/circuit_create_simple',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreationCircuit').modal('toggle')
      getCircuits()
    }
  })
  return false
}

function modifierCircuit(id) {
  let form = new FormData(document.getElementById('formUpdateCircuit'))
  form.append('id', id)
  $.ajax({
    url: 'admin/circuit_update_simple',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalUpdateCircuit').modal('toggle')
      getCircuits()
    }
  })
  return false
}

function supprimerCircuit(id) {
  let test = confirm("Êtes-vous certain de retirer ce circuit ? \nCe changement sera définitif.\nTous les départs de ce circuit seront supprimés.")
  if (test == true) {
    $.ajax({
      url: 'admin/delete_circuit',
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



/* DEPRECATED */

function getCircuits_organize() {
  $.ajax({
    url: '/admin/circuits/organize',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('contenu')
      container.innerHTML = data
      $(".selectpicker").selectpicker()
      $('.datepicker').each(() => {
        $(this).datepicker()
      })
    }
  })
}
