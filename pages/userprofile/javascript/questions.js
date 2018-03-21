$(document).on("click", "#nextQuestion", function () {
    var params = {
        requestType: "nextQuestion",
        question: $("#questionID").data("id"),
        answer: $("input[name='answer']:checked").val(),
        importance: $("input[name='importance']:checked").val()
    };
    if(params.answer == null) {
        summonAlert("warning","You must supply an answer to the question to proceed");
    } else {
        post("", params);
    }

});

$(document).on("click", "#prevQuestion", function () {
    var params = {
        requestType: "prevQuestion",
        question: $("#questionID").data("id"),
        answer: $("input[name='answer']:checked").val(),
        importance: $("input[name='importance']:checked").val()
    };
    if(params.answer == null) {
        summonAlert("warning","You must supply an answer to the question to proceed");
    } else {
        post("", params);
    }
});