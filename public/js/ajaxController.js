$(document).ready(function(){
    $("button").click(function () {
        if ($(this).hasClass("login")){
            $.post(window.location.href, function(){
                $("input").each(function () {
                    alert($(this).val());
                });
            });
        }else if ($(this).hasClass("registry")){
            alert("Nic nie robić. \n" +
                "Nie mieć zmartwień\n" +
            "Chłodne piwko w cieniu pić");
        }
    });
});