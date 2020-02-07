const button = document.getElementById('link-members-list')

button.onclick = () => {

    $.ajax({
      url: 'admin/getAllMembers',
      type: 'GET',
      success: (data) => {
      document.getElementById('contenu').innerHTML = data
        console.log(data);
        //let scrollTo = $("#account-header").offset().top
        $(window).scrollTop(scrollTo)
      }
    })

}

