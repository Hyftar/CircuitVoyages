function membersOptions() {
  $.ajax({
    url: '/member',
    type: 'GET',
    success: (data) => {
      document.getElementsByClassName('home-content')[0].innerHTML = data
      getInformations()
      document.getElementsByTagName('body')[0].classList.add('body-user_account')
      let scrollTo = $("#account-header").offset().top
      $(window).scrollTop(scrollTo)
    }
  })
}

function getCoordinates(){
  $.ajax({
    url: '/member/coordinates',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkCoordinates').classList.add('active')
    }
  })
}

function sendCoordinates(){
  let form = new FormData(document.getElementById('formCoordinates'))
  $.ajax({
    url: '/member/sendCoordinates',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getCoordinates()
      showToast('Adresse', null,'L\'adresse a été mise à jour avec succès.')
    },
    error: (xhr, status, error) =>{
      let errors = xhr.responseJSON['errors']
      setValidity('inputCountry',errors,'inputCountry','feedbackCountry')
      setValidity('inputCity',errors,'inputCity','feedbackCity')
      setValidity('inputRegion',errors,'inputRegion','feedbackRegion')
      setValidity('inputPostalCode',errors,'inputPostalCode','feedbackPostalCode')
      setValidity('inputAddressLine1',errors,'inputAddressLine1','feedbackAddressLine1')
      setValidity('inputAddressLine2',errors,'inputAddressLine2','feedbackAddressLine2')
    }
  })
  return false
}

function getInformations(){
  $.ajax({
    url: '/member/informations',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkInformations').classList.add('active')
    }
  })
}

function sendInformations(){
  let form = new FormData(document.getElementById('formInfos'))
  $.ajax({
    url: '/member/sendInformations',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getInformations()
      showToast('Informations', null,'Les informations du compte ont bien été mises à jour.')
    },
    error: (xhr, status, error) =>{
      let errors = xhr.responseJSON['errors']
      setValidity('inputFirstName',errors,'inputFirstName','feedbackFirstName')
      setValidity('inputLastName',errors,'inputLastName','feedbackLastName')
      setValidity('inputBirthDate',errors,'inputBirthDate','feedbackBirthDate')
      setValidity('inputPhoneNumber',errors,'inputPhoneNumber','feedbackPhoneNumber')
      setValidity('inputLanguage',errors,'inputLanguage','feedbackLanguage')
      setValidity('phone',errors,'inputPhoneNumber','feedbackPhoneNumber')
    }
  })
  return false
}

function setValidity(propertyName, errors, elementId, feedbackId){
  let element = document.getElementById(elementId)
  let feedback = document.getElementById(feedbackId)
  if (errors.hasOwnProperty(propertyName)){
    let content = errors[propertyName]
    if (Array.isArray(content)){
      let newContent = "";
      content.forEach(element => newContent += element + "\n")
      feedback.innerText = newContent.substr(0,newContent.length-1)
    }
    else {
      feedback.innerText = content
    }
    element.classList.add('is-invalid');
    element.classList.remove('is-valid');
  }
  else {
    feedback.innerText = ""
    element.classList.remove('is-invalid');
    element.classList.add('is-valid');
  }}

function getSecurity(){
  $.ajax({
    url: '/member/security',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkSecurity').classList.add('active')
    }
  })
}

function sendSecurity(){
  let form = new FormData(document.getElementById('formSecurity'))
  $.ajax({
    url: '/member/sendSecurity',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getSecurity()
      showToast('Sécurité', null,'Le mot de passe à bien été modifié.')
    },
    error: (xhr, status, error) =>{
      let errors = xhr.responseJSON['errors']
      setValidity('oldPassword',errors,'inputOldPassword','feedbackOldPassword')
      setValidity('newPassword',errors,'inputNewPassword','feedbackNewPassword')
      setValidity('password',errors,'inputNewPasswordBis','feedbackNewPasswordBis')}
  }
  )
  return false
}

function getCommunications(){
  $.ajax({
    url: '/member/communications',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkCommunications').classList.add('active')
    }
  })
}

function sendCommunications(){
  let form = new FormData(document.getElementById('formCommunications'))
  $.ajax({
    url: '/member/sendCommunications',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getCommunications()
      showToast('Communications', null,'L\'adresse email a bien été modifiée.')
    },
    error: (xhr, status, error) =>{
      let errors = xhr.responseJSON['errors']
      setValidity('email',errors,'inputEmail','feedbackEmail')
    }
  })
  return false
}

function getPayments(){
  $.ajax({
    url: '/member/payments',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkTrips').classList.add('active')
    }
  })
}

function getPaymentsUpcoming(){
  $.ajax({
    url: '/member/paymentsUpcoming',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      for (let element of $('.paypal-button')) {
        let container_id = '#' +  element.attributes['id'].value
        let tp_id = element.attributes['data-id'].value
        addPaypalButton(container_id, tp_id)
      }
      setMemberMenuInactive()
      document.getElementById('linkTrips').classList.add('active')
    }
  })
}

function getTrips(){
  $.ajax({
    url: '/member/trips',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkTrips').classList.add('active')
    }
  })
}

function getTripsUpcoming(){
  $.ajax({
    url: '/member/tripsUpcoming',
    type: 'GET',
    success: (data) => {
      document.getElementById('contentForm').innerHTML = data
      setMemberMenuInactive()
      document.getElementById('linkTrips').classList.add('active')
    }
  })
}

function suscribe(id) {
  let form = new FormData(document.getElementById('formNewsletter' + id))
  form.append('id',id)
  $.ajax({
    url: '/member/suscribe',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getCommunications()
    }
  })
  return false
}

function unsuscribe(id){
  let form = new FormData(document.getElementById('formNewsletter' + id))
  form.append('id',id)
  $.ajax({
    url: '/member/unsuscribe',
    type: 'POST',
    data: form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      getCommunications()
    }
  })
  return false
}

function envoyerEmail(){
  $.ajax({
    url: '/admin/sendNewsletterEmail',
    type: 'POST',
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      showToast('Email', null,'Email envoyé.')
    },
    error: (xhr, status, error) =>{
      //alert(xhr.responseText)
    }
  })
  return false
}

function setMemberMenuInactive(){
  document.getElementById('linkInformations').classList.remove('active')
  document.getElementById('linkCoordinates').classList.remove('active')
  document.getElementById('linkSecurity').classList.remove('active')
  document.getElementById('linkCommunications').classList.remove('active')
  document.getElementById('linkTrips').classList.remove('active')
}
