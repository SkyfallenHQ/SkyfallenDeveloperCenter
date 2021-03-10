function triggerNewAppFunction(){

    $(".app-item").each(function (e,i){

        i.style.display = "none";

    })

    $("#create-new-app-form").css("display", "block");

}