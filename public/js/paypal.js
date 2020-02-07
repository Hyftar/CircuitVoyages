function addPaypalButton(container_id, tp_id) {
  paypal.Buttons({
    createOrder: () => {
      return fetch(`/payments/getorder/${tp_id}`, {
        method: 'GET'
      }).then((res) => {
        return res.json()
      }).then((data) => {
        return data.result.id
      })
    },
    style: {
      size: 'small',
      color: 'blue'
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
  }).render(container_id);
}
