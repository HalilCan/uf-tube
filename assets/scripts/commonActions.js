$(document).ready(() => { //jQuery executes this only when the page is fully loaded or "ready"
    /* Alternate toggleSidebar using jQuery */
    $(".navShowHide").on("click", function () {
        let main = $("#mainSectionContainer");
        let nav = $("#sideNavContainer");

        if (main.hasClass("mainLeftPadding")) {
            nav.hide();
        } else {
            nav.show();
        }

        main.toggleClass("mainLeftPadding");
    })

    $(".subFeedRowHideButton").on("click", (event) => {
        let button = event.currentTarget;
        $(button).parent().parent().hide();
    });

    $(".subFeedRowScrollLeftButton").on("click", (event) => {
        let button = event.currentTarget;
        let oppositeButton = $(button).siblings(".subFeedRowScrollRightButton");
        let row = $(button).parent().next();

        let count = $(row).children().length / 2;
        let windowWidth = parseInt($(window).width());
        let windowMaxCount = Math.floor(windowWidth / 210);
        //TODO: in the first place, only show buttons if count > WMC
        let marginLeft = parseInt($(row).css('marginLeft'));
        if (marginLeft > 210 * (count - 1) || marginLeft + (count + 2) * 210 > windowWidth) {
            $(button).hide();
        }  else {
            $(oppositeButton).show();
        } 
        console.log(marginLeft);
        marginLeft += 210;

        console.log(marginLeft + 'px');
        $(row).css('marginLeft', marginLeft + 'px');
    });
    $(".subFeedRowScrollRightButton").on("click", (event) => {
        let button = event.currentTarget;
        let oppositeButton = $(button).siblings(".subFeedRowScrollLeftButton");
        let row = $(button).parent().next();
        
        let marginLeft = parseInt($(row).css('marginLeft'));
        if (marginLeft <= 0) {
            $(button).hide();
        } else {
            $(oppositeButton).show();
        }
          
        marginLeft -= 210;
        console.log(marginLeft + 'px');
        $(row).css('marginLeft', marginLeft + 'px');
    });
    
});

/*
let toggleSidebar = () => {
    let sideBar = document.getElementById("sideNavContainer");
    let mainSectionContainer = document.getElementById("mainSectionContainer");
    if (sideBar.style.display === "flex") {
        mainSectionContainer.style.marginLeft = "0";
        sideBar.style.display = "none";
    } else {
        mainSectionContainer.style.marginLeft = "240px";
        sideBar.style.display = "flex";
    }
}  
*/

function notSignedIn() {
    alert("You must be signed in to do this");
}