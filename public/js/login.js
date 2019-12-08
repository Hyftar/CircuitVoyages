let loginContainer = document.getElementById('login-modal')
loginContainer.onclick = (e) => {
  for (let element of document.querySelectorAll('#login-modal .card')) {
    if (element.contains(e.target)) {
      return
    }
  }

  loginContainer.classList.add('hidden')
}


let loginLinks = ['nav-login-link', 'drawer-login-link']
for (let link of loginLinks) {
  link = document.getElementById(link)
  link.onclick = () => loginContainer.classList.remove('hidden')
}


let loginModalContainer = document.getElementById('login-modal-container')
let loginRegisterLink = document.getElementById('login-register-link')
let registerForm = document.getElementById('register-user-form')

loginRegisterLink.onclick = () => {
  loginModalContainer.classList.add('hidden')
  registerForm.classList.remove('hidden')
}
