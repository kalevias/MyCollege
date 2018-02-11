$(document).ready(function () {
    $(".chosen-ones").chosen({width: "100%"});
});

$(document).on("change", "#country", function () {
    var provinceSelect = $("<select name='province' id='province' class='chosen-ones'></select>");
    var existingProvinceSelect = $("#province")
    var countrySelect = $("#country");

    var parameters = {
        requestType: "getprovinces",
        country: countrySelect.val()
    };
    $.ajax({
        "url": "/mycollege/pages/register/ajax/getprovinces.php",
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