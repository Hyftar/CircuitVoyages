function membersOptions() {
  $.ajax({
    url: '/member',
    type: 'GET',
    success: (data) => {
      document.getElementsByClassName('home-content')[0].innerHTML = data
      getInformations()
    }
  })
}

function listMessages(id){
  $.ajax({
    url: '/admin/getMessages',
    type: 'POST',
    data: {id},
    success: (data) => {
      document.getElementById("contenu").innerHTML = data
    }
  })
}

function createMessage(id){
  $.ajax({
    url: '/admin/getMessageCreator',
    type: 'POST',
    data: {id},
    success: (data) => {
      document.getElementById("modalNewsletter").innerHTML = data
      $("#modalCreateMessage").modal()
    }
  })
}

function sendMessage(){
  let form = new FormData(document.getElementById('formNewMessage'))
  $.ajax({
    url: '/admin/sendMessage',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $("#modalCreateMessage").modal('toggle')
      indexNewsletters()
      showToast('Bulletin d\'informations', null,'Nouveau message envoyé.')
    }
  })
  return false
}

function createNewsletter(){
  $.ajax({
    url: '/admin/getNewsletterCreator',
    type: 'GET',
    success: (data) => {
      document.getElementById("modalNewsletter").innerHTML = data
      $("#modalCreateNewsletter").modal()
    }
  })
}

function saveNewsletter(){
  let form = new FormData(document.getElementById('formNewsletterAdd'))
  $.ajax({
    url: '/admin/createNewsletter',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $("#modalCreateNewsletter").modal('toggle')
      indexNewsletters()
      showToast('Bulletin d\'informations', null,'Nouveau bulletin créé.')
    }
  })
  return false
}

function deleteNewsletter(id, name){
  if (confirm("Êtes-vous certain de bien vouloir supprimer le bulletin d'informations - " + name +" ?")) {
    $.ajax({
      url: '/admin/deleteNewsletter',
      type: 'POST',
      data: {id},
      success: (data) => {
        indexNewsletters()
        showToast('Bulletin d\'informations', null,'Bulletin d\'informations supprimé.')
      }
    })
  }
  return false;
}

function updateNewsletter(id){
  $.ajax({
    url: '/admin/getNewsletterUpdater',
    type: 'POST',
    data: {id},
    success: (data) => {
      document.getElementById("modalNewsletter").innerHTML = data
      $("#modalUpdateNewsletter").modal()
    }
  })
}

function updateNewsletterSave(){
  let form = new FormData(document.getElementById('formNewsletterUpdate'))
  $.ajax({
    url: '/admin/sendUpdate',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $("#modalUpdateNewsletter").modal('toggle')
      indexNewsletters()
      showToast('Bulletin d\'informations', null,'Bulletin modifié.')
    }
  })
  return false
}
