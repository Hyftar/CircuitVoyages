function commander(id, name) {
  $.ajax({
    url: '/order/index',
    type: 'POST',
    data: {
      'id': id
    },
    success: (data) => {
      $("#order_modal").modal('hide')
      shoppingCart.removeItemFromCart(name)
      displayCart()
      getTravelersList()
      //let content = document.getElementById('order-content');
      //content.innerHTML = data;
      //$('#order_modal').modal('show');
    },
  });
}
