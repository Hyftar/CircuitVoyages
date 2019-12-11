function myFunction(x) {
    x.classList.toggle("change");
    let sidebar = document.getElementById("myGroup");
    if (!x.classList.contains("change")) {
        $('#myGroup .collapse').collapse('hide');
    }
    sidebar.classList.toggle('sidebar-show');
}

$(function() {
    $('#myGroup li a').hover(function() {
        $(this).next().collapse('show');
    });

    $('#myGroup').mouseleave(function() {
        $('#myGroup .collapse').collapse('hide');
    });
});

$(() => {
    getCircuits()
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
            let containter = document.getElementById('contenu')
            containter.innerHTML = data
        }
    })
}