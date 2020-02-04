(() => {
  let loginModal = document.getElementById('login-modal')
  let loginModalContainer = document.getElementById('login-modal-container')
  let resetForm = document.getElementById('reset-modal-container')
  let resetLoginLink = document.getElementById('reset-login-link')
  let password_reset_form = document.getElementById('password-reset-form')
  let sent = false

  $('#password-reset-form').ajaxForm({
    beforeSend: (data) => {
      if (sent)
        return false
      sent = true
    },
    success: () => {
      password_reset_form.reset()
      resetForm.classList.add('hidden')
      loginModalContainer.classList.remove('hidden')
      loginModal.classList.add('hidden')
      showToast('Succès', '', 'Un email a été envoyé à l\'adresse spécifiée')
    },
    error: () => {
      resetForm.classList.add('hidden')
      loginModalContainer.classList.remove('hidden')
      loginModal.classList.add('hidden')
      showToast('Erreur', '', 'Une erreur est survenue')
    }
  })

  resetLoginLink.onclick = () => {
    resetForm.classList.add('hidden')
    loginModalContainer.classList.remove('hidden')
  }
})()
