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
      $(".selectpicker").selectpicker()
      $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
      $('#hebergement_form_add > div > div > div.modal-body > form > div.form-group > div > button').click(() => {
        let inputs = $('#acc_filter').tagsinput('items');
        let choices = $('#hebergement_form_add > div > div > div.modal-body > form > div.form-group > div > div > div > ul')[0].children;
        if (inputs.length > 0) {
          for (let e of choices) {
            e.classList.add('hidden');
          }
          for (let e of inputs) {
            for (let f of choices) {
              if (f.innerText.toUpperCase().includes(e.toUpperCase())) {
                f.classList.remove('hidden');
              }
            }
          }
        } else {
          for (let f of choices) {
            f.classList.remove('hidden');
          }
        }

      });

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
  let dayInput = document.getElementById('activity_day');
  let day = dayInput.value;

  $.ajax({
    url: 'admin_activity_add',
    type: 'POST',
    data : {
      activity_id,
      step_id,
      start,
      duration,
      day
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
