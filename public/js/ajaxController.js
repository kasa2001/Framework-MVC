$(document).ready(function(){
    $("button").click(function () {
        $.post(window.location.href, function(){
            $("input").each(function () {
                alert($(this).val());
            });
        });
    });
});