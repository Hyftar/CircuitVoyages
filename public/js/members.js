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
    }
  })
  return false
}

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
    }
  })
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

function setMemberMenuInactive(){
  document.getElementById('linkInformations').classList.remove('active')
  document.getElementById('linkCoordinates').classList.remove('active')
  document.getElementById('linkSecurity').classList.remove('active')
  document.getElementById('linkCommunications').classList.remove('active')
  document.getElementById('linkTrips').classList.remove('active')
}
