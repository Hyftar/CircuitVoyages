(() => {
  const button = document.getElementById('link-support-chat')
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
  const join_action = document.getElementById('support-chat__join-btn')
  const leave_action = document.getElementById('support-chat__leave-btn')

  let selected_room_id = null
  let messages_count = 0
  let rooms_content_length = 0
  let rooms_checker = null // Event fired to check chat rooms statuses
  let chat_checker = null // Event fired to check message status

  // Changes the current selected chat room
  const select_room = (id, active, employee_id, can_leave) => {
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

    leave_action.classList.add('hidden')
    join_action.classList.add('hidden')

    if (employee_id == "") {
      join_action.classList.remove('hidden')
    }
    else if (can_leave) {
      leave_action.classList.remove('hidden')
    }

    selected_room_id = id
    $.ajax(
      {
        url: `admin/chat/messages/${id}/all`,
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
      const employee_id = session.attributes['data-admin-id'].value
      const can_leave = session.attributes['data-can-leave'].value == "true"
      if (id == selected_room_id && active == 0) {
        leave_action.classList.add('hidden')
      }
      session.onclick = () => {
        select_room(id, active, employee_id, can_leave)
      }
    }
  }

  // Update the rooms
  const check_rooms = () => {
    $.ajax({
      url: 'admin/chat/rooms',
      type: 'HEAD',
      success: (data, status, xhr) => {
        let new_length = xhr.getResponseHeader('Content-Length')
        if (rooms_content_length == new_length) {
          return
        }

        rooms_content_length = new_length

        $.ajax({
          url: 'admin/chat/rooms',
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
        url: `admin/chat/messages/${selected_room_id}/check`,
        type: 'GET',
        success: (data) => {
          if (data.messages_count == messages_count) {
            return
          }

          for (let i = messages_count; i < data.messages_count; i++) {
            $.ajax(
              {
                url: `admin/chat/messages/${selected_room_id}/${i}`,
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
    success: () => {
      form.reset()
    }
  }) // Make the form use Ajax

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

  join_action.onclick = (e) => {
    if (selected_room_id == null)
      return

    $.ajax(
      {
        url: `admin/chat/join/`,
        data: { room_id: selected_room_id },
        type: 'POST',
        success: () => {
          text_area.removeAttribute('disabled')
          send_btn.removeAttribute('disabled')
          join_action.classList.add('hidden')
          leave_action.classList.remove('hidden')
        }
      }
    )
  }

  leave_action.onclick = () => {
    if (selected_room_id == null)
      return

    $.ajax(
      {
        url: `admin/chat/leave/${selected_room_id}`,
        type: 'DELETE',
        success: () => {
          text_area.setAttribute('disabled', '')
          send_btn.setAttribute('disabled', '')
          join_action.classList.remove('hidden')
          leave_action.classList.add('hidden')
        }
      }
    )
  }
})()
