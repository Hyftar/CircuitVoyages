(() => {
  let loginContainer = document.getElementById('login-modal')
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1239189849802190',
      cookie     : true,
      xfbml      : true,
      version    : 'v5.0'
    });
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  };

  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      console.log('Welcome!  Fetching your information.... ');
      FB.api('/me', function (response) {
        console.log('Successful login for: ' + response.name);
        alert('Thanks for logging in, ' + response.name + '!');
      });
    }
  }

  // Send the POST request when facebook button is clicked
  let registerFacebook = document.getElementById('btn-facebook')
  registerFacebook.onclick = (e) => {
    FB.login(function(response) {
      if (response.authResponse) {
        FB.api('/me', function(response) {
          // reponse: name and id of user
          console.log(response);
          loginContainer.classList.add('hidden');
        });
      } else {
        console.log('User cancelled login or did not fully authorize.');
      }
    });
  }
})()
