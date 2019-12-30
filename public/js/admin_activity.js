function sendActivity() {
  $.ajax({
    data: $('#activity-add-form').serialize(),
    url: '/admin/activity',
    type: 'POST',
    success: () => {
      $('#activity-add-modal').modal('hide')
      indexActivity()
    },
    error: (data) => {
      document
        .getElementById('activity-errors')
        .innerHTML
    }
  })
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
      getStepActivities(step_id);
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
        getStepActivities(step_id);
      }
    })
  }
}

/* DEPRECATED */

function showActivity() {
  $('#exampleModalScrollable').modal('show')
}
