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
      $('#register_rooms_button').click(() => {
        let uls = document.getElementsByClassName('period_acc');
        let period_accs = {}
        Array.from(uls).forEach((e) => {
          let period_id = e.firstElementChild.value;
          let select = e.children[3].firstElementChild;
          let acc_id = select.children[select.selectedIndex].value;
          period_accs[period_id] = acc_id;
        });
        $.ajax({
          url: '/order/create_rooms',
          type: 'POST',
          data: {
            'period_accs': period_accs,
            'circuit_trip_id': id
          },
          success: (data) => {
            alert('hébergements enregistrés')
          },
        });
      });
      $('.accommodation-select').on("change", function(e){
        e.currentTarget.parentNode.parentNode.
          lastElementChild.firstElementChild.setAttribute("href",
          e.currentTarget
            .children[e.currentTarget.selectedIndex]
            .attributes['data-href']
            .value)
      })


    },
  });
}

