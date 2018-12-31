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