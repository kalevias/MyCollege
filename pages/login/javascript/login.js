function post(path, parameters, method) {
    var form = $('<form></form>');
    method = method || "POST";

    form.attr("method", method);
    form.attr("action", path);

    $.each(parameters, function(key, value) {
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });

    $(document.body).append(form);
    form.submit();
}

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