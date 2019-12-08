(() => {
  let loginModalContainer = document.getElementById('login-modal-container')
  let registerForm = document.getElementById('register-user-form')
  let registerLoginLink = document.getElementById('register-login-link')
  registerLoginLink.onclick = () => {
    registerForm.classList.add('hidden')
    loginModalContainer.classList.remove('hidden')
  }
})()
