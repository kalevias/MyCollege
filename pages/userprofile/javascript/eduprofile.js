$(document).ready(function () {
    $(".chosen-ones").not("#preferredMajors").chosen({width: "100%"});
    $("#preferredMajors").chosen({max_selected_options: 3, width: "100%"});
});

$(document).on("click", "#updateEduProfile", function () {
    var params = {
        gpa: $("#gpa").val(),
        act: $("#act").val(),
        sat: $("#sat").val(),
        ap: $("#ap").is(":checked"),
        income: $("#income").val(),
        entry: $("#entry").val(),
        length: $("#length").val(),
        desiredMajor: $("#desiredMajor").val(),
        preferredMajors: $("#preferredMajors").val(),
        requestType: "updateEduProfile"
    };
    var inputs = [
        {
            name: "GPA",
            value: params.gpa,
            validationType: "float",
            alertLevel: "warning",
            alertMessage: "GPA must be a floating point number"
        },
        {
            name: "ACT",
            value: params.act,
            validationType: "int",
            alertLevel: "warning",
            alertMessage: "ACT score must be an integer"
        },
        {
            name: "SAT",
            value: params.sat,
            validationType: "int",
            alertLevel: "warning",
            alertMessage: "SAT score must be an integer"
        },
        {
            name: "income",
            value: params.income,
            validationType: "int",
            alertLevel: "warning",
            alertMessage: "household income must be an integer"
        },
        {
            name: "desired college entry year",
            value: params.entry,
            validationType: "int",
            alertLevel: "warning",
            alertMessage: "year must be an integer"
        },
        {
            name: "desired college length",
            value: params.length,
            validationType: "int",
            alertLevel: "warning",
            alertMessage: "length must be an integer"
        }
    ];
    if (validateInput(inputs)) {
        post("", params);
    }
});