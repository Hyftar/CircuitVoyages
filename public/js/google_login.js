(() => {
  let loginContainer = document.getElementById('login-modal')
  const client_id = '939832340047-eu00arp5mh0c7m8erakq54mmu0af89mk.apps.googleusercontent.com'
  //Wait for google api to load
  window.onLoadCallback = function(){
    gapi.auth2.init({
      client_id
    });
  }

  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id,
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('btn-google'));
    });
  };

  function attachSignin(element) {
    auth2.attachClickHandler(element, {},
      function(googleUser) {
        onSignIn(googleUser);
        var profile = googleUser.getBasicProfile();
        var id = profile.getId();
        var name = profile.getName();
        var email = profile.getEmail();
        $.ajax(
          {
            url: 'login/google',
            data: { name, id, email },
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
      }, function(error) {
        alert(JSON.stringify(error, undefined, 2));
      });
  }

  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
  }

  startApp();
})()
