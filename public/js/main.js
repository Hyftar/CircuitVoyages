(() => {
  $('.toast').toast({
    animation: true,
    autohide: true,
    delay: 3000
  })

  $('.logo, .nav-link').on('click', () => {
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
        $('main').html(data)
      }
    })
  })
}

function showToast(title, supportingText, body) {
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
