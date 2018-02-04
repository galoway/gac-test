$(document).ready(function(){
    $('#import').click(function(){
        var ajaxurl = 'ajax.php';
        var data =  {'action': 'import'};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            window.location.replace("index.php");
        });
    });

    $('#clear').click(function(){
        var ajaxurl = 'ajax.php';
        var data =  {'action': 'clear'};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            window.location.replace("index.php");
        });
    });

});

$( document ).ajaxStart(function() {
    $('#loader').show();
});

$( document ).ajaxStop(function() {
    $('#loader').hide();
});