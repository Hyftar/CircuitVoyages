(() => {
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
      url: 'register',
      type: 'POST',
      dataType: 'application/json',
      success: () => {
        form.reset()
        registerForm.classList.add('hidden')
        loginModalContainer.classList.remove('hidden')
      },
      error: () => {
        // Show errors via customValidity
      }
    })
  }
})()
