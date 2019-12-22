(() => {
  const loginContainer = document.getElementById('login-modal')
  window.fbAsyncInit = () => {
    FB.init({
      appId      : '769979593517613',
      cookie     : true,
      xfbml      : true,
      version    : 'v5.0'
    })
  }

  // Send the POST request when facebook button is clicked
  const registerFacebook = document.getElementById('btn-facebook')
  registerFacebook.onclick = (e) => {
    FB.login((response) => {
      if (response.authResponse) {
        FB.api(
          '/me',
          (response) => {
            loginContainer.classList.add('hidden');
            $.ajax(
              {
                url: 'login/facebook',
                data: { name: response.name, id: response.id },
                type: 'POST',
                success: () => {
                  loginContainer.classList.add('hidden')
                  loginLink.classList.add('hidden')
                  accountLink.classList.remove('hidden')
                  logoutLink.classList.remove('hidden')
                  // TODO: i18n
                  showToast('Connecté', '', 'Bienvenue! Vous êtes maintenant connecté.')
                }
              }
            )
          }
        )
      }
    })
  }
})()
