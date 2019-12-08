(() => {
  $('.toast').toast({
    animation: true,
    autohide: true,
    delay: 3000
  })
})()

function showToast(title, supportingText, body) {
  $('#toast-title').text(title)
  $('#toast-supporting-text').text(supportingText)
  $('#toast-body').text(body)
  $('.toast').toast('show')
}
