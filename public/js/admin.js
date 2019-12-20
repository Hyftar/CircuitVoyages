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
        url: '/admin/logout',
        type: 'DELETE',
        success: (data) => {
          window.location.href = '/admin/login'
        }
      })
    })
    $('#link-circuits').on('click', getCircuits)
    $('#link-accommodation').on('click', indexAccomodations)
    $('#link-media').on('click', indexMedia)
})

function indexMedia() {
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

function indexAccomodations() {
  $.ajax({
    url: '/admin_accommodation',
    type: 'GET',
    success: (data) => {
      document.getElementById('contenu').innerHTML = data
      $('#accommodation-add-form__submit').on('click', sendAccommodation)
    }
  })
}

function sendAccommodation() {
  $.ajax({
    data: $('#accommodation-add-form').serialize(),
    url: '/admin_accommodation',
    type: 'POST',
    success: () => {
      $('#accommodation-add-modal').modal('hide')
      indexAccomodations()
    },
    error: (data) => {
      document
        .getElementById('accommodation-errors')
        .innerHTML
    }
  })
}

function getCircuits() {
  $.ajax({
    url: '/admin_circuits',
    type: 'GET',
    success: (data) => {
      let containter = document.getElementById('contenu')
      containter.innerHTML = data
    }
  })
}


function showActivity() {
  $('#exampleModalScrollable').modal('show');
}

function getCircuits_organize() {
  $.ajax({
    url: '/admin_circuits_organize',
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

function addStep() {
  let steplist = document.getElementById('steplist');
  let nbEtapes = steplist.childElementCount - 1;
  $.ajax({
    url: '/admin_circuits_addstep_link',
    type: 'POST',
    data: {nbEtapes},
    success: (data) => {
        let button = document.getElementById('addstep_button');
        steplist.removeChild(button);
        steplist.innerHTML += data;
    }
  })
  $.ajax({
    url: '/admin_circuits_addstep_tab',
    type: 'POST',
    data: {nbEtapes},
    success: (data) => {
        let tab_content = document.getElementById('pills-tabContent');
        tab_content.innerHTML += data;
    }
  })

}

function addDay(nbEtapes) {
    let days_container = document.getElementById('daysForStep' + nbEtapes);
    // let nbJours = days_container.childElementCount - 1;
    let selector = 'daysForStep' + nbEtapes;
    let nbJours = $(`#${selector} .header`).length - 1;

    let grille_hebergement = document.getElementById('grille_hebergement'+ nbEtapes);
    let grille_ajout = document.getElementById('grille_ajout'+nbEtapes)

    grille_ajout.classList.remove('step-duration-'+nbJours)
    grille_hebergement.classList.remove('step-duration-'+nbJours);
    days_container.classList.remove('step-duration-'+nbJours);
    nbJours += 1;
    grille_hebergement.classList.add('step-duration-'+nbJours);
    days_container.classList.add('step-duration-'+nbJours);
    grille_ajout.classList.add('step-duration-'+nbJours);

    let day = document.createElement('div');
    day.classList.add('header');
    day.innerHTML = 'Jour ' + nbJours;
    days_container.insertBefore(day, days_container.childNodes[nbJours]);

    let hebergement = document.createElement('div');
    hebergement.classList.add('hebergement');
    let i = document.createElement('i');
    i.classList.add('fas', 'fa-plus');
    hebergement.appendChild(i);
    grille_hebergement.appendChild(hebergement);

    let activity_ajout = document.createElement('div');
    activity_ajout.classList.add('activity_ajout');
    activity_ajout.onclick = showActivity;
    let i2 = document.createElement('i');
    i2.classList.add('fas', 'fa-plus');
    let p = document.createElement('p');
    p.style.display = 'none';
    p.innerHTML = '' + nbJours;
    activity_ajout.appendChild(i2);
    activity_ajout.appendChild(p);
    let p2 = document.createElement('p');
    p2.style.display = 'none';
    p2.innerHTML = '' + nbEtapes;
    activity_ajout.appendChild(p2);
    grille_ajout.appendChild(activity_ajout);

}

function showActivity() {
      $('#activity_form').modal('show');
      let div = event.target;
      let dayNb = div.childNodes[1].textContent;
      $('#day_nb').val(dayNb);
      let stepNb = div.childNodes[2].textContent;
      $('#step_nb').val(stepNb);
}

function createActivity() {
    let name = document.getElementById('activity_name').value;
    let typeSelect = document.getElementById('activity_type');
    let type = typeSelect.options[typeSelect.selectedIndex].value;
    let link = document.getElementById('activity_link').value;
    let desc = document.getElementById('activity_desc').value;
    let e1 = document.getElementById('activity_start');
    let start_time = e1.options[e1.selectedIndex].text;
    let e2 = document.getElementById('activity_duration');
    let end_time = e2.options[e2.selectedIndex].text;

    $.ajax({
      url: '/admin_circuits_activity_create',
      type: 'POST',
      data: {name, type, link, desc, start_time, end_time},
      success: (data) => {
        let activity = document.createElement('div');
        activity.classList.add('activity');
        activity.classList.add('activity--start-' + start_time, 'activity--end-' + end_time);
        let dayNb = document.getElementById('day_nb');
        activity.style.gridColumn = dayNb.value;
        let stepNb = document.getElementById('step_nb');
        let days_container = document.getElementById('daysForStep' + stepNb.value);

        let p = document.createElement('p');
        p.innerHTML = name;

        activity.appendChild(p);

        let p2 = document.createElement('input');
        p2.style.display = "none";
        p2.innerHTML = data.id;

        activity.appendChild(p2);


        days_container.appendChild(activity);
        $('#activity_form').modal('hide');
      }
    })
}

// Code de Keven

function getCircuits_create() {
  $.ajax({
    url: '/admin_circuits_create',
    type: 'GET',
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit');
      container.innerHTML = data;
      $(".selectpicker").selectpicker();
      $('#modalCreationCircuit').modal('toggle')
      $("select").imagepicker({show_label: true})
    }
  })
}

function getCircuits_update(id) {
  $.ajax({
    url: 'admin_circuit_update',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuCircuit');
      container.innerHTML = data;
      $(".selectpicker").selectpicker();
      $('#modalUpdateCircuit').modal('toggle')
      $("select").imagepicker({show_label: true})
    }
  })
}

function creerCircuit(){
  let form = new FormData(document.getElementById('formCreateCircuit'));
  $.ajax({
    url: 'admin/circuit_create_simple',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreationCircuit').modal('toggle');
    }
  })
  return false;
}

function modifierCircuit(){
  let form = new FormData(document.getElementById('formUpdateCircuit'));
  $.ajax({
    url: 'admin/circuit_update_simple',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalUpdateCircuit').modal('toggle');
    }
  })
  return false;
}

function supprimerCircuit(id){
  let test = confirm("Êtes-vous certain de retirer ce circuit ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin/deleteCircuit',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'html',
      success: (data) => {
      }
    })
  }
}

function createCircuit_simple(){

}

function getCircuits_Detail(){

}

function editCircuit(id){

}







/// NICHOLAS #2

function getCircuitEtapes(circuit_id) {
  $.ajax({
    url: '/admin_circuits_etapes',
    type: 'POST',
    data:{circuit_id},
    success: (data) => {
      let containter = document.getElementById('contenu');
      containter.innerHTML = data;
    }
  })
}

function getSteps_create(circuit_id) {
  $.ajax({
    url: 'admin_creation_etape_simple',
    type: 'POST',
    data: {circuit_id},
    success: (data) => {
      let container = document.getElementById('modalContenuEtape');
      container.innerHTML = data;
      $('#modalCreationEtape').modal('toggle');
    }
  })
}

function creerEtape(){
  let form = new FormData(document.getElementById('formCreateEtape'));
  $.ajax({
    url: 'admin_etape_simple_create',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalCreationEtape').modal('toggle');
    }
  })
  return false;
}

function getSteps_update(id) {
  $.ajax({
    url: 'admin_etape_getupdate',
    type: 'POST',
    data: {
      id: id
    },
    success: (data) => {
      let container = document.getElementById('modalContenuEtape');
      container.innerHTML = data;
      $('#modalUpdateEtape').modal('toggle')
    }
  })
}

function modifierEtape(){
  let form = new FormData(document.getElementById('formUpdateEtape'));
  $.ajax({
    url: 'admin_etape_update',
    type: 'POST',
    data : form,
    cache: false,
    processData: false,
    contentType: false,
    success: (data) => {
      $('#modalUpdateEtape').modal('toggle');
    }
  })
  return false;
}

function supprimerStep(id){
  let test = confirm("Êtes-vous certain de retirer cette étape ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_etape',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'html',
      success: (data) => {
      }
    })
  }
}

function getStepActivities(step_id){
  $.ajax({
    url: 'admin_activity_list',
    type: 'POST',
    data : {step_id},
    success: (data) => {
        let container = document.getElementById('contenu');
        container.innerHTML = data;
    }
  })
}

function getActivity_add(){
  $('#activity_form_add').modal('show');
}

function addActivity(step_id){
    let select = document.getElementById('activity_id');
    let activity_id = select.options[select.selectedIndex].value;
    let select2 = document.getElementById('activity_start');
    let start = select2.options[select2.selectedIndex].value;
    let select3 = document.getElementById('activity_duration');
    let duration = select3.options[select3.selectedIndex].value;

  $.ajax({
    url: 'admin_activity_add',
    type: 'POST',
    data : {
      activity_id,
      step_id,
      start,
      duration
    },
    success: (data) => {
      $('#activity_form_add').modal('hide');
    }
  })
}

function supprimerActivity(activity_id, step_id){
  let test = confirm("Êtes-vous certain de retirer cette étape ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_activity_step',
      type: 'POST',
      data: {
        activity_id,
        step_id
      },
      success: (data) => {

      }
    })
  }
}

function supprimerHebergement(accommodation_id, period_id){
  let test = confirm("Êtes-vous certain de retirer cette étape ? Ce changement est définitif.")
  if(test == true){
    $.ajax({
      url: 'admin_delete_accommodation_step',
      type: 'POST',
      data: {
        accommodation_id,
        period_id
      },
      success: (data) => {

      }
    })
  }
}

function getHebergement_add(){
  $('#hebergement_form_add').modal('show');
}

function addHebergement(period_id){
  let select = document.getElementById('accommodation_id');
  let accommodation_id = select.options[select.selectedIndex].value;

  $.ajax({
    url: 'admin_accommodation_step_add',
    type: 'POST',
    data : {
      accommodation_id,
      period_id
    },
    success: (data) => {
      $('#hebergement_form_add').modal('hide');
    }
  })
}




