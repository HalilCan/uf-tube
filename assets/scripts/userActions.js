function subscribe(userTo, userFrom, button) {
    if(userTo == userFrom) {
        alert("You can't sub to yourself!");
        return;
    }

    $.post("ajax/subscribe.php", {userTo: userTo, userFrom: userFrom})
        .done(function(data){
            console.log(data);
        }
    );
}