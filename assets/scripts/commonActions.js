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