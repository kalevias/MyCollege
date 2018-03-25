$(document).on("click", ".collegeRating", function () {
    var college = $(".collegeRating");

    var parameters = {
        requestType: "getscorecard",
        college: college.data("id")
    };
    $.ajax({
        "url": "/mycollege/resources/ajax/getscorecard.php",
        "type": "POST",
        "data": parameters,
        "success": function (data) {
            var result = JSON.parse(data);
        },
        "error": function (xhr, ajaxOptions, thrownError) {
            summonAlert("error", xhr.status + " " + thrownError);
        }
    });
});