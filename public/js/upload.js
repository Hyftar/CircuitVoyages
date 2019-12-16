$(() => {
  $('#upload-submit').on('click',() => {
    $.ajax({
      url: 'upload',
      type: 'POST',
      data: {
        file: $('#file-upload').val()
      },
      success: (data) => {
        console.log("good upload");
      },
      error: (data) => {
        console.log("error upload");
      }
    })
  })
})

document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("customFile").files[0].name;
  var nextSibling = e.target.nextElementSibling
  nextSibling.innerText = fileName
})
