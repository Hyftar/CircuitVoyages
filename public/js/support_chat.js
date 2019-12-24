(() => {
  const button = document.getElementById('support-chat__button')
  const chat_box = document.getElementById('support-chat__chat-box')
  const exit = document.getElementById('support-chat__exit')
  const content = document.getElementById('support-chat__content')
  const sidebar = document.getElementById('support-chat__sidebar')

  button.onclick = () => {
    button.classList.add('hidden')
    chat_box.classList.remove('hidden')
  }

  exit.onclick = () => {
    button.classList.remove('hidden')
    chat_box.classList.add('hidden')
  }
})()
