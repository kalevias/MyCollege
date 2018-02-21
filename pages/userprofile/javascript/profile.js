$(document).ready(function () {
    $(".chosen-ones").chosen({width: "100%"});
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

$(document).on("click", "#updateContactInfo", function () {
    var params = {
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        email: $("#email").val(),
        altEmail: $("#altEmail").val(),
        streetAddress: $("#streetAddress").val(),
        city: $("#city").val(),
        province: $("#province").val(),
        postalCode: $("#postalCode").val(),
        phoneNumber: $("#phoneNumber").val(),
        gradYear: $("#gradYear").data("clevermaskout"),
        requestType: "updateContactInfo"
    };
    var inputs = [
        {
            name: "email",
            value: params.email,
            validationType: "email",
            alertLevel: "warning",
            alertMessage: "Please enter a valid email"
        },
        {
            name: "alternative email",
            value: params.altEmail === "" ? "example@example.com" : params.altEmail, //dummy value to allow blanks
            validationType: "email",
            alertLevel: "warning",
            alertMessage: "Please enter a valid email"
        }
        // ,
        // {
        //     name: "phone",
        //     value: params.phoneNumber,
        //     validationType: "phone",
        //     alertLevel: "warning",
        //     alertMessage: "Please enter a valid phone number"
        // }
    ];
    if (validateInput(inputs)) {
        post("", params);
    }
});