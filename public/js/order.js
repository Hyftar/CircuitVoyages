function commander(id) {
  $.ajax({
    url: '/order/index',
    type: 'POST',
    data: {
      'id': id
    },
    success: (data) => {
      let content = document.getElementById('order-content');
      content.innerHTML = data;
      $('#order_modal').modal('show');
    },
  });
}
