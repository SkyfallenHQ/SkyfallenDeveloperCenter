$(document).ready(function () {

    var greetText = "Have a nice day"

    var d = new Date();
    var n = d.getHours();

    if (n < 13 && n >= 7){

        greetText = "Good Morning";

    }

    if (n < 19 && n >= 13){

        greetText = "Good Afternoon";

    }

    if (n < 24 && n >= 19){

        greetText = "Good Night";

    }

    if (n < 7 && n >= 0){

        greetText = "New day";

    }

    var newMessage = $("#greeting").text().replaceAll("Hi", greetText);
    $("#greeting").text(newMessage);

    console.log('%c You really should not be messing here. If you really know what you doing, here is the link to go: https://theskyfallen.com/volunteer', 'background: #222; color: #bada55');


})