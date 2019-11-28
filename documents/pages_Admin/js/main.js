

function myFunction(x) {
    x.classList.toggle("change");
    let sidebar = document.getElementById("myGroup");
    if (!x.classList.contains("change")) {
        $('#myGroup .collapse').collapse('hide');
    }
    sidebar.classList.toggle('sidebar-show');
}

$(function() {
    $('#myGroup li a').hover(function () {
        $(this).next().collapse('show');
    });
    
    $('#myGroup').mouseleave(function () {
        $('#myGroup .collapse').collapse('hide');
    });
});





