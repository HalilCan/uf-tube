function likeVideo(button, videoId) {
    $.post("ajax/likeVideo.php", {videoId: videoId})
    .done(function(data){
        alert(data);

        let likeButton = $(button);
        let dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");
    });
}

function dislikeVideo(button, videoId) {
    $.post("ajax/likeVideo.php", {videoId: videoId})
    .done(function(data){
        alert(data);

        let dislikeButton = $(button);
        let likeButton = $(button).siblings(".likeButton");

        dislikeButton.addClass("active");
        likeButton.removeClass("active");
    });
}