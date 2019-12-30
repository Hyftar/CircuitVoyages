(() => {
  // support chat button
  const supportButton = document.getElementById('support-chat__button')

  // Close the login modal when grey area is clicked
  const loginContainer = document.getElementById('login-modal')
  loginContainer.onclick = (e) => {
    for (let element of document.querySelectorAll('#login-modal .card, #login-modal .panel')) {
      if (element.contains(e.target)) {
        return
      }
    }

    loginContainer.classList.add('hidden')
  }

  // Account link
  accountLink = document.getElementById('nav-account-link')

  // Open the login modal when login link is clicked
  loginLink = document.getElementById('nav-login-link')
  loginLink.onclick = () => loginContainer.classList.remove('hidden')

  // Logout button
  logoutLink = document.getElementById('nav-logout-link')
  logoutLink.onclick = () => {
    $.ajax({
      url: '/login',
      type: 'DELETE',
      success: () => {
        // TODO: i18n
        showToast('Déconnecté', '', 'Aurevoir! Vous vous êtes déconnecté avec succès.')

        supportButton.classList.add('hidden')
        accountLink.classList.add('hidden')
        logoutLink.classList.add('hidden')
        loginLink.classList.remove('hidden')
      },
      error: () => {
        // TODO: i18n
        showToast('Erreur', '', 'Une erreur est survenue lors de la déconnexion, veuillez essayer à nouveau.')
      }
    })
  }

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
      url: '/login',
      type: 'post',
      data: { email, password },
      success: () => {
        $('#input-email').val('')
        $('#input-password').val('')
        loginContainer.classList.add('hidden')
        loginLink.classList.add('hidden')
        accountLink.classList.remove('hidden')
        logoutLink.classList.remove('hidden')
        supportButton.classList.remove('hidden')
        // TODO: i18n
        showToast('Connecté', '', 'Bienvenue! Vous êtes maintenant connecté.')
      },
      error: (data) => {
        errors.removeClass('hidden')
        $('#input-password').val('')
        $('#login-errors').html(data.responseText)
      }
    })
  }
})()
