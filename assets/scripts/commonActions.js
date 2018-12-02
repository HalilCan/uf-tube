$(document).ready(() => { //jQuery executes this only when the page is fully loaded or "ready"
    /* Alternate toggleSidebar using jQuery
        $(".navShowHide").on("click", function () {
            $("#sideNavContainer")
        })
    */
});

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