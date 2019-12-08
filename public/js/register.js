let registerLoginLink = document.getElementById('register-login-link')
registerLoginLink.onclick = () => {
  registerForm.classList.add('hidden')
  loginModalContainer.classList.remove('hidden')
}
