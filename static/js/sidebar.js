var sidebarstate = true;

function toggleNav(){

    if(sidebarstate == false){
        openNav();
    } else {
        closeNav();
    }

}

$(document).ready(function () {

    if($(window).width() < 800){
        closeNav()
    }

})

function openNav() {
    document.getElementById("side-menu").style.width = "300px";
    document.getElementById("content").style.marginLeft = "300px";
    document.getElementById("org-select").classList.add("hide-if-small");
    document.getElementById("profile-circle").classList.add("hide-if-small");
    document.getElementById("content").classList.add("hide-content-if-small");
    document.getElementById("menu-toggle-a").style.transform = "rotate(90deg)";
    sidebarstate = true;
}

function closeNav() {
    document.getElementById("side-menu").style.width = "0";
    document.getElementById("content").style.marginLeft = "0";
    document.getElementById("org-select").classList.remove("hide-if-small");
    document.getElementById("profile-circle").classList.remove("hide-if-small");
    document.getElementById("content").classList.remove("hide-content-if-small");
    document.getElementById("menu-toggle-a").style.transform = "rotate(0deg)";
    sidebarstate = false;
}

function openPage(newURL){

    window.location.href = newURL;

}