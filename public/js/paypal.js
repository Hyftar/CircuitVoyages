let totalcart = document.getElementById('total-cart');
console.log(totalcart.innerHTML);

paypal.Buttons({
  createOrder: function(data, actions) {
    // This function sets up the details of the transaction, including the amount and line item details.
    return actions.order.create({
      purchase_units: [{
        amount: {
          value: totalcart.innerHTML,
          currency_code: "USD"
        }
      }]
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      alert('Transaction completed by ' + details.payer.name.given_name);
      // Call your server to save the transaction
      return fetch('/paypal-transaction-complete', {
        method: 'post',
        headers: {
          'content-type': 'application/json'
        },
        body: JSON.stringify({
          orderID: data.orderID
        })
      });
    });
  }
}).render('#paypal-button-container');
