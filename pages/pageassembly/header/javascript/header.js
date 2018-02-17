$(document).on("click", "#logoutButton", function () {
    var params = {
        requestType: "logout"
    };
    post("#", params);
});