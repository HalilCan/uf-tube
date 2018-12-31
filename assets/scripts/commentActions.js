function postComment(button, postedBy, videoId, replyTo, containerClass) {
    let textArea = $(button).siblings("textarea");
    let commentText = textArea.val();
    textArea.val("");

    if (commentText) {
        $.post("ajax/postComment.php", {commentText: commentText, postedBy: postedBy, videoId: videoId, responseTo: replyTo})
        .done(function(comment){
            $("." + containerClass).prepend(comment);
        });

    } else {
        return;
    }
}

function toggleReply(button) {
    let parent = $(button).closest(".itemContainer");
    let commentForm = parent.find(".commentForm").first();

    commentForm.toggleClass("hidden");
}

function likeComment(commentId, button, videoId) {
    $.post("ajax/likeComment.php", {commentId: commentId, videoId: videoId})
    .done(function(numToChange){
        
        let likeButton = $(button);
        let dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        let likesCount = $(button).siblings(".likesCount");
        updateLikesValue(likesCount, numToChange);

        if(numToChange < 0) {
            likeButton.removeClass("active");
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");
        } else {
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up-active.png");
        }
        dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");
    });
}

function dislikeComment(commentId, button, videoId) {
    $.post("ajax/dislikeComment.php", {commentId: commentId, videoId: videoId})
    .done(function(numToChange){

        let dislikeButton = $(button);
        let likeButton = $(button).siblings(".likeButton");

        dislikeButton.addClass("active");
        likeButton.removeClass("active");

        let likesCount = $(button).siblings(".likesCount");
        updateLikesValue(likesCount, numToChange);

        if(numToChange) {
            dislikeButton.removeClass("active");
            dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down.png");
        } else {
            dislikeButton.find("img:first").attr("src", "assets/images/icons/thumb-down-active.png");
        }
        likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");
    });
}

function updateLikesValue(element, num) {
    let likesCountVal = element.text () || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}

function getReplies(commentId, button, videoId) {
    $.post("ajax/getCommentReplies.php", {commentId: commentId, videoId: videoId})
    .done((comments)=>{
        let replies = $("<div>").addClass("repliesSection");
        replies.append(comments);

        $(button).replaceWith(replies);
    });
}