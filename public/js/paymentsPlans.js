function choosePayments() {
  $.ajax({
    url: '/order/getPaymentsPlans',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenuTest').innerHTML = data;
      $("#modalPayment").modal()
    }
  })
}

function orderTrip(id){
  let response = confirm("Êtes-vous certain de bien vouloir choisir ce plan ?\n" +
    "En choisissant ce plan, vous confirmez l'achat d'un circuit.\n" +
    "Êtes-vous bien certain de vouloir commander le circuit avec ce plan ?")
  if (!response)
    return
  $.ajax({
    url: '/order/createOrder',
    type: 'POST',
    data: {id}, // id du plan de paiement
    success: (data) => {
      $("#modalPayment").modal('hide')
      showToast('Circuit commandé', null,'Merci d\'avoir fait affaire avec nos services.' +
        '\nNous avons déjà hâte de vous accompagner dans vos aventures.')
    }
  })
}
