$(document).on("click", "#login", function() {
    var params = {
        email:$("#email").val(),
        password:$("#password").val(),
        requestType:"login"
    };
    post("#",params);
});

$(document).on("click", "#reset", function() {
    var params = {
        email:$("#email").val(),
        requestType:"sentResetEmail"
    };
    post("#",params);
});

$(document).on("keyup", "#password", function (e) {
    var key = e.which;
    if(key === 13)  // the enter key code
    {
        $('#login').click();
        return false;
    }
});