function sendActivity() {
  $.ajax({
    data: $('#activity-add-form').serialize(),
    url: '/admin/activity',
    type: 'POST',
    success: () => {
      $('#activity-add-modal').modal('hide')
      indexActivity()
    },
    error: (data) => {
      document
        .getElementById('activity-errors')
        .innerHTML
    }
  })
}

/* DEPRECATED */

function showActivity() {
  $('#exampleModalScrollable').modal('show')
}
