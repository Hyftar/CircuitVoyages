function myFunction(x) {
  x.classList.toggle("change");
  let sidebar = document.getElementById("myGroup");
  if (!x.classList.contains("change")) {
    $('#myGroup .collapse').collapse('hide');
  }
  sidebar.classList.toggle('sidebar-show');
}

$(function () {
  $('#myGroup li a').hover(function () {
    $(this).next().collapse('show');
  });

  $('#myGroup').mouseleave(function () {
    $('#myGroup .collapse').collapse('hide');
  });
});

$(() => {
  getCircuits()
  $('#admin-logout-link').on('click', () => {
    $.ajax({
      url: 'logout',
      type: 'DELETE',
      success: (data) => {
        window.location.href = '/admin/login'
      }
    })
  })
})

function getCircuits() {
  $.ajax({
    url: 'admin_circuits',
    type: 'GET',
    success: (data) => {
      let containter = document.getElementById('contenu')
      containter.innerHTML = data
    }
  })
}

function getCircuits_create() {
  $.ajax({
    url: 'admin_circuits_create',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('contenu');
      container.innerHTML = data;
      $(".selectpicker").selectpicker();
      $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
      });

    }

  })
}

function showActivity() {
  $('#exampleModalScrollable').modal('show');
}

function getCircuits_organize() {
  $.ajax({
    url: 'admin_circuits_organize',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('contenu');
      container.innerHTML = data;
      $(".selectpicker").selectpicker();
      $('.datepicker').each(function () {
        $(this).datepicker()
      });


    }
  })
}
