paypal.Buttons({
  createOrder: () => {
    return fetch('/payments/getorder/', {
      method: 'GET'
    }).then((res) => {
      return res.json()
    }).then((data) => {
      return data.result.id
    })
  },
  onApprove: (data, actions) => {
    return actions.order.capture().then((details) => {
      return fetch('/payments/onapprove', {
        method: 'POST',
        headers: {
          'content-type': 'application/json'
        },
        body: JSON.stringify({
          data,
          details
        })
      });
    });
  }
}).render('#paypal-button-container');
