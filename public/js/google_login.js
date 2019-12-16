(() => {
  let loginContainer = document.getElementById('login-modal')
  //Wait for google api to load
  window.onLoadCallback = function(){
    gapi.auth2.init({
      client_id: '939832340047-eu00arp5mh0c7m8erakq54mmu0af89mk.apps.googleusercontent.com'
    });
  }

  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '939832340047-eu00arp5mh0c7m8erakq54mmu0af89mk.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('btn-google'));
    });
  };

  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
      function(googleUser) {
        alert("Signed in: " +
          googleUser.getBasicProfile().getName());
        onSignIn(googleUser);
        loginContainer.classList.add('hidden');
      }, function(error) {
        alert(JSON.stringify(error, undefined, 2));
      });
  }

  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }

  startApp();

})()
