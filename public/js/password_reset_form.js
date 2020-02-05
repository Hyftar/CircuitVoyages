(() => {
  $('#reset_form_password_confirmation').on('change', (e) => {
    e.currentTarget.setCustomValidity('')
  })

  $('#reset_form').on('submit', () => {
    if ($('#reset_form_password').val() != $('#reset_form_password_confirmation').val()) {
      document
        .getElementById('reset_form_password_confirmation')
        .setCustomValidity('Les mots de passes ne sont pas identiques')
      return false
    }
  })
})()
