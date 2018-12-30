function likeVideo(button, videoId) {
    $.post("ajax/likeVideo.php", {videoId: videoId})
    .done(function(data){
        alert(data);

        let likeButton = $(button);
        let dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        ler result = JSON.parse(data);
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateLikesValue(dislikeButton.find(".text"), result.dislikes);
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

function updateLikesValue(element, num) {
    let likesCountVal = element.text () || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));

}