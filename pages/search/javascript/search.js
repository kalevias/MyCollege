$(document).ready(function () {
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output.innerHTML = this.value;
    };

    slider = document.getElementById("myRange2");
    var output2 = document.getElementById("demo2");
    output2.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output2.innerHTML = this.value;
    };

    slider = document.getElementById("myRange3");
    var output3 = document.getElementById("demo3");
    output3.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output3.innerHTML = this.value;
    };

    slider = document.getElementById("myRange4");
    var output4 = document.getElementById("demo4");
    output4.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function () {
        output4.innerHTML = this.value;
    };
});
$(document).on("click", "h3", function () {
    var params = {
        c: $(this).data("id")
    };
    post("/mycollege/pages/college/college.php", params, "GET");
});