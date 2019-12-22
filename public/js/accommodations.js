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
