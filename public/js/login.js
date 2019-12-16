(() => {
  // Close the login modal when grey area is clicked
  let loginContainer = document.getElementById('login-modal')
  loginContainer.onclick = (e) => {
    for (let element of document.querySelectorAll('#login-modal .card, #login-modal .panel')) {
      if (element.contains(e.target)) {
        return
      }
    }

    loginContainer.classList.add('hidden')
  }


  // Open the login modal when login link is clicked
  link = document.getElementById('nav-login-link')
  link.onclick = () => loginContainer.classList.remove('hidden')

  // Open reset and register modals
  let loginModalContainer = document.getElementById('login-modal-container')
  let loginRegisterLink = document.getElementById('login-register-link')
  let loginResetLink = document.getElementById('forgot-password')
  let registerForm = document.getElementById('register-user-form')
  let resetForm = document.getElementById('reset-modal-container')

  loginRegisterLink.onclick = () => {
    loginModalContainer.classList.add('hidden')
    registerForm.classList.remove('hidden')
  }

  loginResetLink.onclick = () => {
    loginModalContainer.classList.add('hidden')
    resetForm.classList.remove('hidden')
  }


  // Send the POST request when login button is clicked
  // and form is filled correctly
  let loginButton = document.getElementById('login-submit-button')
  loginButton.onclick = (e) => {
    let email = $('#input-email').val()
    let password = $('#input-password').val()
    let errors = $('#login-errors')

    errors.addClass('hidden')

    $.ajax({
      url: 'login',
      type: 'post',
      data: { email, password },
      success: () => {
        $('#input-email').val('')
        $('#input-password').val('')
        loginContainer.classList.add('hidden')
      },
      error: (data) => {
        errors.removeClass('hidden')
        $('#input-password').val('')
        $('#login-errors').html(data.responseText)
      }
    })
  }
})()
