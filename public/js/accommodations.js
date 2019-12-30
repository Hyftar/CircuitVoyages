function indexAccomodations() {
  $.ajax({
    url: '/admin/accommodation',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
      $('#accommodation-add-form__submit').on('click', sendAccommodation)
    }
  })
}

function sendAccommodation() {
  $.ajax({
    data: $('#accommodation-add-form').serialize(),
    url: '/admin/accommodation',
    type: 'POST',
    success: () => {
      $('#accommodation-add-modal').modal('hide')
      indexAccomodations()
    },
    error: (data) => {
      document
        .getElementById('accommodation-errors')
        .innerHTML
    }
  })
}

function supprimerHebergement(accommodation_id, period_id){
  let test = confirm("Êtes-vous certain de retirer cette étape ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_accommodation_step',
      type: 'POST',
      data: {
        accommodation_id,
        period_id
      },
      success: (data) => {
        getStepActivities(period_id);
      }
    })
  }
}

function getHebergement_add(){
  $('#hebergement_form_add').modal('show');
}

function addHebergement(period_id){
  let select = document.getElementById('accommodation_id');
  let accommodation_id = select.options[select.selectedIndex].value;

  $.ajax({
    url: 'admin_accommodation_step_add',
    type: 'POST',
    data : {
      accommodation_id,
      period_id
    },
    success: (data) => {
      $('#hebergement_form_add').modal('hide');
      getStepActivities(period_id);
    }
  })
}
