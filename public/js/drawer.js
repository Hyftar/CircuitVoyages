(() => {
  let hamburger = document.getElementById('menu-hamburger')
  hamburger.onclick = () => {
    hamburger.classList.toggle('is-active')
  }
})()
