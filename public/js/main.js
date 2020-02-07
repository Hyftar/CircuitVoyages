(() => {
  $('.toast').toast({
    animation: true,
    autohide: true,
    delay: 3000
  })
  $('.logo, .circuits').on('click', () => {
    $.ajax({
      url: '/',
      dataType: 'html',
      success: (data) => {
        $('main').html($.parseHTML(data).find((e) => e.nodeName == 'MAIN').children)
        addBtnEvents()
        setBackground('images/beach.jpg')
      }
    })
  })

  addBtnEvents()
})()

function addBtnEvents() {
  $('.card-body .btn').on('click', (e) => {
    $.ajax({
      url: `circuit/${e.currentTarget.attributes['data-id'].value}`,
      success: (data) => {
        $('main').html(data);
        setOnclick();
      }
    })
  })
}

function showToast(title, supportingText, body) {
  setTimeout(
    () => { $('#toast-container').addClass('hidden') },
    3000
  )
  $('#toast-container').removeClass('hidden')
  $('#toast-title').text(title)
  $('#toast-supporting-text').text(supportingText)
  $('#toast-body').text(body)
  $('.toast').toast('show')
}

function setBackground(url) {
  $('body').css('background-image', `url(${url})`)
}

function changeLang() {
  const languages = document.getElementById("languages");
  const selectedValue = languages.options[languages.selectedIndex].value;

  $.ajax({
    url: 'changelocale',
    type: 'POST',
    data: { selectedValue },
    success: () => {
      window.location.reload();
    }
  })
}

function alertContact() {
  alert('Pour nous joindre, vous pouvez vous connecter et ensuite utiliser le service de chat intégré au site.\n' +
    'Un employé se fera un plaisir de vous aider.\n' +
    'Vous pouvez également nous joindre au (514)555-1243')
}
