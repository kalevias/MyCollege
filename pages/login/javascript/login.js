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

$("#login").on("click", function() {
    var params = {
        email:$("#email").value(),
        password:$("#password").value(),
        requestType:"login"
    };
    post("",params);
});

$("#reset").on("click", function() {
    var params = {
        email:$("#email").value(),
        requestType:"sentResetEmail"
    };
    post("",params);
});