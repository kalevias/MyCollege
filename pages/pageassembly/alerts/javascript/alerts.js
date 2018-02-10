$(document).on("click", ".remove-alert", function () {
    $(this).parent().animate({height: "0px"}, 200);
    $(this).parent().parent().animate({height: "0px"}, 200, function () {
        $(this).remove();
    });
});