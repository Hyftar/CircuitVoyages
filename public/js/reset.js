(() => {
  let resetForm = document.getElementById('reset-modal-container')
  let loginModalContainer = document.getElementById('login-modal-container')
  let resetLoginLink = document.getElementById('reset-login-link')
  resetLoginLink.onclick = () => {
    resetForm.classList.add('hidden')
    loginModalContainer.classList.remove('hidden')
  }
})()
