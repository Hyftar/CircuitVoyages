function getPaymentPlan(circuit_trip_id){
  $.ajax({
    url:'admin/payment_plan_index',
    type:'POST',
    data: {circuit_trip_id},
    success: (data) => {
      let container = document.getElementById('contenu');
      container.innerHTML = data;
    }
  })
}
