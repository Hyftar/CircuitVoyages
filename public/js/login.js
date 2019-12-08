(() => {
  let loginContainer = document.getElementById('login-modal')
  loginContainer.onclick = (e) => {
    for (let element of document.querySelectorAll('#login-modal .card, #login-modal .panel')) {
      if (element.contains(e.target)) {
        return
      }
    }

    loginContainer.classList.add('hidden')
  }


  link = document.getElementById('nav-login-link')
  link.onclick = () => loginContainer.classList.remove('hidden')


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
})()
