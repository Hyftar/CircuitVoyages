function getPayments(payment_plan_id, circuit_trip_id){
  $.ajax({
    url:'admin/payments',
    type:'POST',
    data: {payment_plan_id, circuit_trip_id},
    success: (data) => {
      let container = document.getElementById('contenu');
      container.innerHTML = data;
      $('#payment_form_add').modal('hide');
    }
  })
}

function getPaymentPlans(circuit_trip_id){
  $.ajax({
    url:'admin/payment_plans',
    type:'POST',
    data: {circuit_trip_id},
    success: (data) => {
      let container = document.getElementById('contenu');
      container.innerHTML = data;
      $('#payment_plan_form_add').modal('hide');

    }
  })
};

function getPaymentPlansAdd(){
  $('#payment_plan_form_add').modal('show');
}


function getPaymentAdd(){
  $('#payment_form_add').modal('show');
}


function ajouterPayment(payment_plan_id, circuit_trip_id){
  let amount_due = document.getElementById('payment_amount').value;
  let date_due = document.getElementById('payment_date').value;
  $.ajax({
    url:'admin/payment_ajout',
    type:'POST',
    data: {
      payment_plan_id,
      amount_due,
      date_due
    },
    success: (data) => {
      $('#payment_form_add').modal('hide');
      getPayments(payment_plan_id, circuit_trip_id);
    }
  })
}

function ajouterPlan(circuit_trip_id){
  let name = document.getElementById('payment_plan_name').value;
  $.ajax({
    url:'admin/payment_plan_ajout',
    type:'POST',
    data: {
      circuit_trip_id,
      name
    },
    success: (data) => {
      $('#payment_plan_form_add').modal('hide');
      getPaymentPlans(circuit_trip_id)
    }
  })
}



function supprimerPayment(payment_id, payment_plan_id, circuit_trip_id){
  $.ajax({
    url:'admin/payment_suppression',
    type:'POST',
    data: {payment_id},
    success: (data) => {
      getPayments(payment_plan_id, circuit_trip_id)
    }
  })
}

function supprimerPlan(payment_plan_id, circuit_trip_id){
  $.ajax({
    url:'admin/payment_plan_suppression',
    type:'POST',
    data: {payment_plan_id},
    success: (data) => {
      getPaymentPlans(circuit_trip_id)
    }
  })
}
