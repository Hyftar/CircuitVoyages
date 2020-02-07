function sameAddress(){
  enableDisable("#inputCountry")
  enableDisable("#inputCity")
  enableDisable("#inputRegion")
  enableDisable("#inputPostalCode")
  enableDisable("#inputAddressLine1")
  enableDisable("#inputAddressLine2")
}

function enableDisable(id){
  if ($(id)[0].hasAttribute('disabled')){
    $(id).removeAttr('disabled');
  }
  else {
    $(id).attr('disabled',true);
  }
}

function returnTravelersList(){
  $("#modalTraveler").modal('hide')
  getTravelersList()
}

function getTravelersList(){
  $.ajax({
    url: '/admin/getTravelers',
    type: 'GET',
    success: (data) => {
      document.getElementById("order_modal_content").innerHTML = data
      $("#order_modal").modal('hide')
      $("#modalTravelerList").modal()
    }
  })
}

function deleteTraveler(id){
  if (confirm("Êtes-vous certain de bien vouloir supprimer ce voyageur?")) {
    $.ajax({
      url: '/admin/deleteTraveler',
      type: 'POST',
      data: {id},
      success: (data) => {
        $("#modalTravelerList").modal('hide')
        getTravelersList()
      }
    })
  }
}

function getTravelerCreator(){
  $.ajax({
    url: '/admin/getTravelerCreator',
    type: 'GET',
    success: (data) => {
      $("#modalTravelerList").modal('hide')
      document.getElementById("order_modal_content").innerHTML = data
      $("#modalTraveler").modal()
    }
  })
}

function addTraveler(){
  let form = new FormData(document.getElementById('formTraveler'))
  $.ajax({
    url: '/admin/addTraveler',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalTraveler').modal('hide')
      returnTravelersList()
      showToast('Voyageur', null,'Le voyageur a été ajouté.')
    },
    error: (xhr, status, error) =>{
      let errors = xhr.responseJSON['errors']
      setValidity('inputCountry',errors,'inputCountry','feedbackCountry')
      setValidity('inputCity',errors,'inputCity','feedbackCity')
      setValidity('inputRegion',errors,'inputRegion','feedbackRegion')
      setValidity('inputPostalCode',errors,'inputPostalCode','feedbackPostalCode')
      setValidity('inputAddressLine1',errors,'inputAddressLine1','feedbackAddressLine1')
      setValidity('inputAddressLine2',errors,'inputAddressLine2','feedbackAddressLine2')
      setValidity('inputFirstName',errors,'inputFirstName','feedbackFirstName')
      setValidity('inputLastName',errors,'inputLastName','feedbackLastName')
      setValidity('inputBirthDate',errors,'inputBirthDate','feedbackBirthDate')
      setValidity('inputPhoneNumber',errors,'inputPhoneNumber','feedbackPhoneNumber')
      setValidity('inputGenre',errors,'inputGenre','feedbackLanguage')
      setValidity('phone',errors,'inputPhoneNumber','feedbackPhoneNumber')
    }
  })
  return false
}

function passToAccommodations(){
  let table = document.getElementById('tableTravelers');
  let rowCount = table.tBodies[0].rows.length;
  if (rowCount == 0){
    showToast('Voyageur', null,'Vous devez ajouter un voyageur avant de continuer.')
    return
  }
  $("#modalTravelerList").modal('hide')
  choosePayments()

}
