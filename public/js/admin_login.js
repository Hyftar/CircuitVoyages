$(() => {
  $('#admin-login-submit').on('click',() => {
    $.ajax({
      url: '/admin/login',
      type: 'POST',
      data: {
        email: $('#admin-login-email').val(),
        password: $('#admin-login-password').val()
      },
      success: (data) => {
        window.location.href = '/admin'
      },
      error: (data) => {
        let element = $('#admin-login-errors')
        element.removeClass('hidden')
        element.html(data.responseText)
      }
    })
  })
})
