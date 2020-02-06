(() => {
  $('.toast').toast({
    animation: true,
    autohide: true,
    delay: 3000
  })
})()

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
