(() => {
  const container = document.getElementById('login-modal')
  const loginModalContainer = document.getElementById('login-modal-container')
  const registerForm = document.getElementById('register-user-form')
  const registerLoginLink = document.getElementById('register-login-link')
  registerLoginLink.onclick = () => {
    registerForm.classList.add('hidden')
    loginModalContainer.classList.remove('hidden')
  }

  const registerSubmit = document.getElementById('register-submit')
  registerSubmit.onclick = (e) => {
    let form = document.getElementById('register-form')

    if ($('#register-form #password-confirmation').val() !=
        $('#register-form #password').val()) {
      document
        .querySelector('#register-form #password-confirmation')
        .setCustomValidity('Les mot de passe ne concordent pas')
        // TODO: i18n
      return
    }

    if (!form.checkValidity())
      return

    form = $('#register-form')
    const data =
      form
        .serializeArray()
        .reduce((a, x) => {
            a[x.name] = x.value
            return a
          },
          {}
        )

    $.ajax({
      data,
      url: '/register',
      type: 'POST',
      success: () => {
        document.getElementById('register-form').reset()
        container.classList.add('hidden')
        registerForm.classList.add('hidden')
        loginModalContainer.classList.remove('hidden')
      },
      error: (data) => {
        const response_data = JSON.parse(data.responseText).errors
        for (const error in response_data) {
          const elem = document.querySelector(`#register-user-form [name="${error}"]`)
          const text = response_data[error].join(', ')
          elem.setCustomValidity(text)
          elem.onchange = () => {
            elem.setCustomValidity('')
          }
        }
      }
    })
  }
})()
