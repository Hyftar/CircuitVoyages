/* HAMBURGER MENU */

function openBurger(x) {
  x.classList.toggle("change")
  let sidebar = document.getElementById("sidebar_container")
  if (!x.classList.contains("change")) {
    $('#sidebar_container .collapse').collapse('hide');
  }
  sidebar.classList.toggle('sidebar-show');
}

/* SIDEBAR MENU */

$(() => {
  $('#sidebar_container li a').hover(() => {
    $(this).next().collapse('show')
  });

  $('#sidebar_container').mouseleave(() => {
    $('#sidebar_container .collapse').collapse('hide')
  })
});

/* MAIN ADMIN PAGE */

function getIndexAdmin() {
  disablePops()
  $.ajax({
    url: 'admin/index',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('contenu')
      container.innerHTML = data
    }
  })
}

/* ASSIGNS SIDEBAR LINKS */

$(() => {
  getIndexAdmin();
  $('#admin-logout-link').on('click', () => {
    $.ajax({
      url: '/admin/login',
      type: 'DELETE',
      success: (data) => {
        window.location.href = '/admin/login'
      }
    })
  });

  $('#link-promotions').on('click', indexPromotions);
  $('#link-circuits').on('click', getCircuits);
  $('#link-accommodation').on('click', indexAccommodations);
  $('#link-media').on('click', indexMedia);
  $('#link-activity').on('click', indexActivity)
  $('#link-newsletters').on('click', indexNewsletters)

})

function indexNewsletters(){
  disablePops()
  $.ajax({
    url: '/admin/getNewsletters',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
    }
  })
}

/* SIDEBAR ROUTES */

function indexPromotions() {
  disablePops()
  $.ajax({
    url: '/admin/promotions',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
    }
  })
}

function indexMedia() {
  disablePops()
  $.ajax({
    url: '/admin/media',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
      $('#media-add-form').ajaxForm({
        success: () => {
          $('#media-add-modal').modal('hide')
          indexMedia()
        }
      })
    }
  })
}

function indexActivity() {
  disablePops()
  $.ajax({
    url: '/admin/activity',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
      $('#activity-add-form__submit').on('click', sendActivity)
    }
  })
}

/* BACK BUTTON */

function retourAccueil() {
  disablePops()
  getCircuits();
}

/* ENABLE POPOVERS */
function enablePops()  {
  $(function () {
    $('[data-toggle="popover"]').popover()
  });
}

function disablePops(){
  $('[data-toggle="popover"]').popover('hide')
}
