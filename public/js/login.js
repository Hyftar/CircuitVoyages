let loginContainer = document.getElementById('login-modal')
loginContainer.onclick = (e) => {
  if (document.getElementById('login-card').contains(e.target))
    return;

  loginContainer.classList.add('hidden')
}

let loginLinks = ['navLoginLink', 'navLoginLink']
for (let link of loginLinks) {
  link = document.getElementById(link)
  link.onclick = () => loginContainer.classList.remove('hidden')
}
