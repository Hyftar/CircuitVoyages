(() => {
  const button = document.getElementById('support-chat__button')
  const chat_box = document.getElementById('support-chat__chat-box')
  const exit = document.getElementById('support-chat__exit')
  const content = document.getElementById('support-chat__content')
  const sidebar = document.getElementById('support-chat__sidebar')
  const form = document.getElementById('support-chat__form')
  const send_btn = document.getElementById('support-chat__sendbtn')
  const text_area = document.getElementById('support-chat__textarea')
  const room_id_input = document.getElementById('support-chat__roomid')
  const messages_container = document.getElementById('support-chat__messages-container')
  const actions_bar = document.getElementById('support-chat__actions')
  const resolve_action = document.getElementById('support-chat__resolve-btn')

  let selected_room_id = null
  let messages_count = 0
  let rooms_content_length = 0
  let rooms_checker = null // Event fired to check chat rooms statuses
  let chat_checker = null // Event fired to check message status

  // Changes the current selected chat room
  const select_room = (id, active) => {
    if (id == selected_room_id) {
      return
    }

    room_id_input.setAttribute('value', id)

    if (active) {
      text_area.removeAttribute('disabled')
      send_btn.removeAttribute('disabled')
      actions_bar.classList.remove('hidden')
    }
    else {
      text_area.setAttribute('disabled', '')
      send_btn.setAttribute('disabled', '')
      actions_bar.classList.add('hidden')
    }

    selected_room_id = id
    $.ajax(
      {
        url: `chat/messages/${id}/all`,
        type: 'GET',
        success: (data) => {
          messages_container.innerHTML = ''
          messages_container.insertAdjacentHTML('beforeend', data)
          messages_count = messages_container.children.length
        }
      }
    )
  }


  // Sets event listeners on rooms buttons
  const set_listeners = () => {
    const sidebar_sessions = document.querySelectorAll('.sidebar__chat-session')
    for (const session of sidebar_sessions) {
      const id = session.attributes['data-id'].value
      const active = session.attributes['data-active'].value == 1
      session.onclick = () => {
        select_room(id, active)
      }
    }
    const new_session = document.getElementById('support-chat__new-session')
    new_session.onclick = () => {
      $.ajax(
        {
          url: 'chat/join',
          type: 'POST',
          success: (data) => {
            select_room(data.id, true)
          }
        }
      )
    }
  }

  // Update the rooms
  const check_rooms = () => {
    $.ajax({
      url: 'chat/rooms',
      type: 'HEAD',
      success: (data, status, xhr) => {
        let new_length = xhr.getResponseHeader('Content-Length')
        if (rooms_content_length == new_length) {
          return
        }

        rooms_content_length = new_length

        $.ajax({
          url: 'chat/rooms',
          type: 'GET',
          success: (data) => {
            let sidebar = document.getElementById('support-chat__sidebar')
            sidebar.innerHTML = data
            set_listeners()
          }
        })
      }
    })
  }


  // Checks if the chat has new messages
  const check_chat = () => {
    if (selected_room_id == null) {
      return
    }

    $.ajax(
      {
        url: `chat/messages/${selected_room_id}/check`,
        type: 'GET',
        success: (data) => {
          if (data.messages_count == messages_count) {
            return
          }

          for (let i = messages_count; i < data.messages_count; i++) {
            $.ajax(
              {
                url: `chat/messages/${selected_room_id}/${i}`,
                type: 'GET',
                success: (data) => {
                  messages_container.insertAdjacentHTML('beforeend', data)
                  // Scroll down when new messages are received
                  content.scrollTop = content.scrollHeight
                }
              }
            )
          }

          messages_count = data.messages_count
        }
      }
    )
  }

  $('#support-chat__form').ajaxForm({
    beforeSend: () => {
      form.reset()
    }
  }) // Make the form use Ajax

  $('#support-chat__textarea').keypress((e) => {
    if (e.which == 13) { // Enter key
      $('#support-chat__form').submit()
      $(this).val("")
      e.preventDefault()
    }
  })

  button.onclick = () => {
    button.classList.add('hidden')
    chat_box.classList.remove('hidden')
    check_rooms()
    rooms_checker = setInterval(check_rooms, 3000) // every 3s
    chat_checker = setInterval(check_chat, 1000) // every second
  }

  exit.onclick = () => {
    button.classList.remove('hidden')
    chat_box.classList.add('hidden')
    clearInterval(rooms_checker)
    clearInterval(chat_checker)
  }

  resolve_action.onclick = (e) => {
    if (selected_room_id == null)
      return

    $.ajax(
      {
        url: `chat/leave/${selected_room_id}`,
        type: 'DELETE',
        success: () => {
          text_area.setAttribute('disabled', '')
          send_btn.setAttribute('disabled', '')
          actions_bar.classList.add('hidden')
        }
      }
    )
  }
})()
