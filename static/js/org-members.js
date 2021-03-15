function triggerNewMemberFunction(){

    $(".member-item").each(function (e,i){

        i.style.display = "none";

    })

    $("#create-new-member-form").css("display", "block");

}