/* ------------------ DEPRECATED -----------  */

function addStep() {
  let steplist = document.getElementById('steplist')
  let nbEtapes = steplist.childElementCount - 1
  $.ajax({
    url: '/admin/circuits/addstep_link',
    type: 'POST',
    data: {
      nbEtapes
    },
    success: (data) => {
      let button = document.getElementById('addstep_button')
      steplist.removeChild(button)
      steplist.innerHTML += data
    }
  })
  $.ajax({
    url: '/admin/circuits/addstep_tab',
    type: 'POST',
    data: {
      nbEtapes
    },
    success: (data) => {
      let tab_content = document.getElementById('pills-tabContent')
      tab_content.innerHTML += data
    }
  })

}

function addDay(nbEtapes) {
  let days_container = document.getElementById('daysForStep' + nbEtapes)
  // let nbJours = days_container.childElementCount - 1
  let selector = 'daysForStep' + nbEtapes
  let nbJours = $(`#${selector} .header`).length - 1

  let grille_hebergement = document.getElementById('grille_hebergement' + nbEtapes)
  let grille_ajout = document.getElementById('grille_ajout' + nbEtapes)

  grille_ajout.classList.remove('step-duration-' + nbJours)
  grille_hebergement.classList.remove('step-duration-' + nbJours)
  days_container.classList.remove('step-duration-' + nbJours)
  nbJours += 1
  grille_hebergement.classList.add('step-duration-' + nbJours)
  days_container.classList.add('step-duration-' + nbJours)
  grille_ajout.classList.add('step-duration-' + nbJours)

  let day = document.createElement('div')
  day.classList.add('header')
  day.innerHTML = 'Jour ' + nbJours
  days_container.insertBefore(day, days_container.childNodes[nbJours])

  let hebergement = document.createElement('div')
  hebergement.classList.add('hebergement')
  let i = document.createElement('i')
  i.classList.add('fas', 'fa-plus')
  hebergement.appendChild(i)
  grille_hebergement.appendChild(hebergement)

  let activity_ajout = document.createElement('div')
  activity_ajout.classList.add('activity_ajout')
  activity_ajout.onclick = showActivity
  let i2 = document.createElement('i')
  i2.classList.add('fas', 'fa-plus')
  let p = document.createElement('p')
  p.style.display = 'none'
  p.innerHTML = '' + nbJours
  activity_ajout.appendChild(i2)
  activity_ajout.appendChild(p)
  let p2 = document.createElement('p')
  p2.style.display = 'none'
  p2.innerHTML = '' + nbEtapes
  activity_ajout.appendChild(p2)
  grille_ajout.appendChild(activity_ajout)

}

function showActivity() {
  $('#activity_form').modal('show')
  let div = event.target
  let dayNb = div.childNodes[1].textContent
  $('#day_nb').val(dayNb)
  let stepNb = div.childNodes[2].textContent
  $('#step_nb').val(stepNb)
}

function createActivity() {
  let name = document.getElementById('activity_name').value
  let typeSelect = document.getElementById('activity_type')
  let type = typeSelect.options[typeSelect.selectedIndex].value
  let link = document.getElementById('activity_link').value
  let desc = document.getElementById('activity_desc').value
  let e1 = document.getElementById('activity_start')
  let start_time = e1.options[e1.selectedIndex].text
  let e2 = document.getElementById('activity_duration')
  let end_time = e2.options[e2.selectedIndex].text

  $.ajax({
    url: '/admin/circuits/activity_create',
    type: 'POST',
    data: {
      name,
      type,
      link,
      desc,
      start_time,
      end_time
    },
    success: (data) => {
      let activity = document.createElement('div')
      activity.classList.add('activity')
      activity.classList.add('activity--start-' + start_time, 'activity--end-' + end_time)
      let dayNb = document.getElementById('day_nb')
      activity.style.gridColumn = dayNb.value
      let stepNb = document.getElementById('step_nb')
      let days_container = document.getElementById('daysForStep' + stepNb.value)

      let p = document.createElement('p')
      p.innerHTML = name

      activity.appendChild(p)

      let p2 = document.createElement('input')
      p2.style.display = "none"
      p2.innerHTML = data.id


      days_container.appendChild(activity)
      $('#activity_form').modal('hide')
    }
  })
}
