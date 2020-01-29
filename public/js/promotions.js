function listerDetailsPromotion(id) {
  $.ajax({
    url: '/admin/promotions/id',
    type: 'POST',
    data: {
      id: id
    },
    dataType: 'html',
    success: (data) => {
      document.getElementById("modalCreationPromo").innerHTML = data
      $("#modalDetailsPromotion").modal()
    }
  })
}

function modifierPromotion(id) {
  $.ajax({
    url: '/admin/promotions/idModal',
    type: 'POST',
    data: {
      id: id
    },
    dataType: 'text',
    success: (data) => {
      document.getElementById("modalCreationPromo").innerHTML = data
      $("#modalModifPromotion").modal()
    }
  })
}

function modifierPromotionEnreg() {
  let form = new FormData(document.getElementById('formUpdate'))
  $.ajax({
    url: '/admin/promotions/updatePromo',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalModifPromotion').modal('toggle')
      indexPromotions()
    }
  })
  return false
}

function ajouterPromotion() {
  $.ajax({
    url: '/admin/promotions/emptyModal',
    success: (data) => {
      document.getElementById("modalCreationPromo").innerHTML = data
      $("#modalCreerPromotion").modal()
    }
  })
}

function ajouterPromotionEnreg() {
  let form = new FormData(document.getElementById('formCreate'))
  $.ajax({
    url: '/admin/promotions/createPromo',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreerPromotion').modal('toggle')
      indexPromotions()
    }
  })
  return false
}

function ajouterApplication(id) {
  $.ajax({
    url: '/admin/promotions/application',
    type: 'POST',
    data: {
      id: id
    },
    dataType: 'html',
    success: (data) => {
      document.getElementById("modalCreationPromo").innerHTML = data
      $("#modalApplicationPromotion").modal()
    }
  })
}

function ajouterApplicationEnreg() {
  let form = new FormData(document.getElementById('formApplication'))
  $.ajax({
    url: '/admin/promotions/createApplication',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalApplicationPromotion').modal('toggle')
      indexPromotions()
    }
  })
  return false
}

function supprimerPromotion(id) {
  let test = confirm("Êtes-vous certain de retirer cette promotion ? Elle existera encore, mais elle aura pris fin hier.")
  if (test == true) {
    $.ajax({
      url: '/admin/promotions/deactivate',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'html',
      success: (data) => {
        indexPromotions()
      }
    })
  }
}

function availabilityChange() {
  let value = document.getElementById("promo-availability")
  let checkbox = document.getElementById('promo-unlimited')
  if (checkbox.checked) {
    value.disabled = trues
    value.value = "0"
  } else {
    value.disabled = false
    value.value = "0"
  }
}

function allCircuitChange() {
  const value = document.getElementById("circuit-trip-id")
  const checkbox = document.getElementById('circuit-unlimited')
  if (checkbox.checked) {
    value.disabled = true
    value.value = "0"
  } else {
    value.disabled = false
    value.value = "0"
  }
}
