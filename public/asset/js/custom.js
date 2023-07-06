
// NAVBAR RESPONSIVE FUNCTION START

function navbarfunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

// END NAVBAR RESPONSIVE FUNCTION

// CONTENT FEATURED SLIDER STARTS


function hideAll(){
    /*$("#addMore").hide();
    $("#presetShow").hide();
    $("#addAdditional").hide();
    $("#submitButtons").hide();
    $('#selectItem').select2({
        theme: "bootstrap",
        width: "100%",
    });*/
}

$(document).ready(function () {
    $('.my-owl-two').owlCarousel({
        center: true,
        items:2,
        margin:10,
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive:{
            100:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });
    $('.my-owl-one').owlCarousel({
        center: true,
        items:2,
        margin:10,
        autoplay:true,
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive:{
            100:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });

    $('.my-owl-three').owlCarousel({
        center: true,
        items:12,
        margin:30,
        autoplay:true,
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        responsive:{
            100:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:12
            }
        }
    });
});

// END CONTENT FEATURED SLIDER STARTS
