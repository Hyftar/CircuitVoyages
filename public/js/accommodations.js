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

function supprimerHebergements(period_id, step_id){
  let test = confirm("Êtes-vous certain de vouloir retirer cette période ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_period',
      type: 'POST',
      data: {
        period_id
      },
      success: (data) => {
        getStepActivities(step_id);
      }
    })
  }
}

function getHebergement_add(){
  $('#hebergement_form_add').modal('show');
}

function addHebergements(step_id){
  let select = document.getElementById('accommodation_id');
  let accommodations = $('#accommodation_id').val();

  let period_start = document.getElementById('period_start').value;

  $.ajax({
    url: 'admin_accommodation_step_add',
    type: 'POST',
    data : {
      accommodations,
      period_start,
      step_id
    },
    success: (data) => {
      $('#hebergement_form_add').modal('hide');
      getStepActivities(step_id);
    }
  })
}
