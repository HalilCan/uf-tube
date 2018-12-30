function subscribe(userTo, userFrom, button) {
    if(userTo == userFrom) {
        alert("You can't sub to yourself!");
        return;
    }

    $.post("ajax/subscribe.php", {userTo: userTo, userFrom: userFrom})
        .done(function(count){
            if(count != null) {
                $(button).toggleClass("subscribe unsubscribe");
                let buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED";
                $(button).text(buttonText + " " + count);
            } else {
                alert("something went wrong :(");
            }
        }
    );
}