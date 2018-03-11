$(document).ready(function () {
    $(".chosen-ones").chosen({width: "100%"});
    $("#phoneNumber").cleverMask();
    $("#gradYear").cleverMask();
});

$(document).on("change", "#country", function () {
    var provinceSelect = $("<select id='province' class='chosen-ones'></select>");
    var existingProvinceSelect = $("#province");
    var countrySelect = $("#country");

    var parameters = {
        requestType: "getprovinces",
        country: countrySelect.val()
    };
    $.ajax({
        "url": "/mycollege/resources/ajax/getprovinces.php",
        "type": "POST",
        "data": parameters,
        "success": function (data) {
            var result = JSON.parse(data);
            var province = "";
            for (var i = 0; i < result.length; i++) {
                province = $("<option></option>");
                province.attr("value", result[i]["iso"]);
                province.html(result[i]["name"]);
                $(provinceSelect).append(province);
            }
            if ($(provinceSelect).children("option").length === 0) {
                $(provinceSelect).append("<option value='None'>None</option>");
            }
            existingProvinceSelect.chosen("destroy");
            existingProvinceSelect.remove();
            provinceSelect.appendTo($("#provinceLabel"));
            provinceSelect.chosen({width: "100%"});
        },
        "error": function (xhr, ajaxOptions, thrownError) {
            summonAlert("error", xhr.status + " " + thrownError);
        }
    });
});

$(document).on("click", "#registerButton", function () {
    var params = {
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        email: $("#email").val(),
        altEmail: $("#altEmail").val(),
        streetAddress: $("#streetAddress").val(),
        city: $("#city").val(),
        province: $("#province").val(),
        postalCode: $("#postalCode").val(),
        phoneNumber: $("#phoneNumber").data("clevermaskout"),
        gradYear: $("#gradYear").data("clevermaskout"),
        password: $("#password").val(),
        confirmPassword: $("#confirmPassword").val(),
        requestType: "registerStudent"
    };

    if(validate_REntropy(params.password)>40) {
        post("#", params);
    } else {
        summonAlert("warning", "Warning: Your password isn't strong enough.");
    }
});

$(document).on("keyup", "#confirmPassword", function (e) {
    var key = e.which;
    if (key === 13)  // the enter key code
    {
        $('#registerButton').click();
        return false;
    }
});