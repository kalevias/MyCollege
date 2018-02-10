/**
 * The post function is used to send input data via an http request to a PHP (or
 * other) page without the hassle of using the "form" element.
 *
 * The "form" element is limited, in the sense that all input elements must
 * either be children, or they have to include that "for" attribute. Furthermore
 * text areas cannot be outside of a form, so they can't even use the
 * versaitility provided by the "for" attribute (at least, this was true last
 * time I checked). Additionally, each input needs a unique "name" attribute on
 * top of (sometimes) a unique "id" attribute, an altogether unnecessary step.
 *
 * The post method solves these problems by allowing you to specify which
 * values you wish to send on an http request. The usage of the function shall
 * be broken down below by argument, and then described as a whole afterwards:
 *
 *  1. path
 *      The path argument accepts a string which is a file path (relative or
 *      absolute, from the website root) that leads to the file where the http
 *      request should be submitted. The value specified here should be
 *      identical to the value specified in an "action" attribute of a "form"
 *      element.
 *  2. parameters
 *      The parameters argument accepts an object used as an associative array
 *      with the following structure scheme:
 *      parameters = {
    *          "name of value in http request" : "value for name"
*          i.e.
*          "key" : "value"
*      }
 *      The "key" for each parameter is used to specify the "name" attribute
 *      for a generated "input" element with a "value" attribute set to the
 *      value specified in "value" for that same given "key". These inputs are
 *      then added as children to a "form" element which is generated on-demand
 *      whenever the function is called, and then the form is sumbitted to the
 *      file specified at the path argument.
 *  3. method
 *      The method argument is optional, and it accepts a string. It allows you
 *      to specify which http request method you'd like to use when calling
 *      the function. By default, the function will use a POST method, but you
 *      can specify others (i.e. GET), should you like to. The value of this
 *      argument should be identical to the value of a "method" attribute for
 *      a "form" element.
 *
 *  After properly calling the function, it generates a form and corresponding
 *  inputs on-demand with all of the values you specified, and it submits the
 *  form to the path specified.
 *
 *  Note: in addition to sending inputs and their values, you can use more
 *        helpful names as keys, and you can see all of the inputs you'll be
 *        sending in one place so you don't have to hunt across your HTML for
 *        them. Furthermore, you can also send along additional information
 *        without cluttering your HTML with hidden inputs. On top of this, you
 *        get to manually specify exactly what value you want to send with each
 *        key. So this way you're not limited to sending the contents of the
 *        "value" attribute of an element. Essentially, anything that can be
 *        stored in a variable can be sent along.
 *
 * @param path
 * @param parameters
 * @param method
 */
function post(path, parameters, method) {
    var form = $('<form></form>');
    method = method || "POST";

    form.attr("method", method);
    form.attr("action", path);

    $.each(parameters, function (key, value) {
        var field = $('<input></input>');

        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);

        form.append(field);
    });

    $(document.body).append(form);
    form.submit();
}

/**
 * The two functions below are client-side methods for displaying alerts to the
 * user. Each takes a type (either 'notification', 'warning', or 'error), a
 * message to be displayed in the alert (can use HTML, it will be parsed), and
 * an optional "isDismissible" boolean value (default true) which indicates if
 * an alert can be dismissed by the user, or if it will remain until the page
 * refreshes.
 *
 * The differences between the two functions are as follows: summonAlert will
 * append an alert to the currently displayed alerts, while overwriteAlert will
 * remove all previous alerts and then append itself.
 *
 * @param type
 * @param message
 * @param isDismissible
 */
function summonAlert(type, message, isDismissible) {

    var alert = "<div>";

    if (typeof isDismissible === "undefined" || isDismissible) {
        alert += "<span>" +
            "<img class='remove-alert' src='/newjustice/images/32x32/cancel.png' title='Dismiss'>" +
            "</span>";
    }

    switch (type) {
        case "notification":
            alert += "<img src='/mycollege/resources/images/information.png'>";
            break;
        case "warning":
            alert += "<img src='/mycollege/resources/images/error.png'>";
            break;
        case "error":
            alert += "<img src='/mycollege/resources/images/exclamation.png'>";
            break;
    }

    alert += message + "</div>";

    $("#" + type + "s").append(alert);
}

/**
 *
 * @param type
 * @param message
 * @param isDismissible
 */
function overwriteAlert(type, message, isDismissible) {
    var alert = "<div>";

    if (typeof isDismissible === "undefined" || isDismissible) {
        alert += "<span>" +
            "<img class='remove-alert' src='/newjustice/images/32x32/cancel.png' title='Dismiss'>" +
            "</span>";
    }

    switch (type) {
        case "notification":
            alert += "<img src='/mycollege/resources/images/information.png'>";
            break;
        case "warning":
            alert += "<img src='/mycollege/resources/images/error.png'>";
            break;
        case "error":
            alert += "<img src='/mycollege/resources/images/exclamation.png'>";
            break;
    }

    alert += message + "</div>";

    $("#errors, #warnings, #notifications").children("div:not([id])").remove();
    $("#" + type + "s").append(alert);
}

/**
 *
 * @param string
 * @returns {number}
 */
function validate_REntropy(string) {
    var lowers = /[a-z]/;
    var uppers = /[A-Z]/;
    var digits = /\d/;
    var specials = /[^a-zA-Z0-9]/;
    var size = (lowers.test(string) ? 26 : 0) + (uppers.test(string) ? 26 : 0) + (digits.test(string) ? 10 : 0) + (specials.test(string) ? 32 : 0);
    var chars = {};
    for (var i = 0; i < string.length; i++) {
        if (string.charAt(i) in chars) {
            chars[string.charAt(i)]++;
        } else {
            chars[string.charAt(i)] = 1;
        }
    }
    var h = 0, p;
    for (var char in chars) {
        p = chars[char] / (size * 1.0);
        h -= Math.log(p) / Math.log(2);
    }
    return h;
}

/**
 * This function is used to simplify the process of validating user input in
 * forms, and the process of notifying the user via the alert system that an
 * error has occured. The function takes one argument, an array storing objects
 * used as associative arrays, with the following structure scheme:
 *
 * ( "[[" and "]]" denote optional/depends on other conditions)
 *
 *  inputs = [
 *      {
 *          "name" : name,
 *          [["elements" : elements,]]
 *          [["value" : value,]]
 *          "validationType" : validationType,
 *          "alertLevel" : alertLevel,
 *          "alertMessage" : alertMessage[[,]]
 *          [["regex" : regex]]
 *      },
 *  ]
 *
 *  In this scheme,
 *
 *      name should be the name of an element (not the "name"
 *      attribute), in a human-readable form (e.g. "username" for
 *      "txUsername-input").
 *
 *      elements should be an array of strings, each of which containing the ID
 *      of an element in this particular set to be validated (only applies to
 *      certain validation types, see below)
 *
 *      value should be a string containing one value of an input (pre-fetched).
 *      This value is only required for certain validation types (see below).
 *
 *      validationType should be one of the following validation options:
 *           buttonRadio-oneChecked : one of the elements in "elements" is checked
 *                    buttonCheck-n : n elements in "elements" are checked, negative values for n are not allowed
 *                            email : "value" is an email
 *                           file-n : n files have been chosen by "elements"
 *                            float : "value" is a float
 *                              int : "value" is an integer
 *                        non-empty : "value" isn't empty
 *                      non-numeric : "value" does not contain any numbers
 *                            phone : "value" is a phone number
 *                            regex : "value" is checked against "regex"
 *                         select-n : n options have been selected by "elements" (select elements only), negative values for n are not allowed
 *                              url : "value" is a URL
 *
 *      alertLevel should be a string, of one of the following values:
 *          notification
 *          warning
 *          error
 *
 *          on a failed validation, an alert of the appropriate level will be
 *          generated and displayed to the user.
 *
 *      alertMessage should be the message displayed in the alert, should the
 *      given validation fail.
 *
 *      regex should be a regular expression used to compare "value" against.
 *      This is only used in certain validation types, see above.
 *
 *
 * @param inputs array
 * @returns {boolean}
 */
function validateInput(inputs) {

    var returnVal = true;

    for (var input in inputs) {

        var n, count, regex, val, flag = false;

        switch (true) {
            case input.validationType === "buttonRadio-oneChecked":
                for (var element in input.elements) {
                    if ($(element).is(":checked") && flag) {
                        flag = false;
                        break;
                    } else if ($(element).is(":checked")) {
                        flag = true;
                    }
                }
                break;
            case new RegExp("^buttonCheck-").test(input.validationType):
                n = parseInt(input.validationType.substring(12));
                count = 0;
                for (element in input.elements) {
                    count += $(element + ":checked").length;
                }
                if (count === n) {
                    flag = true;
                }
                break;
            case input.validationType === "email":
                regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
                flag = regex.test(input.value);
                break;
            case new RegExp("^file-").test(input.validationType):
                n = parseInt(input.validationType.substring(5));
                count = 0;
                for (element in input.elements) {
                    count += $(element)[0].files.length;
                }
                if (count === n) {
                    flag = true;
                }
                break;
            case input.validationType === "float":
                val = parseFloat(input.value);
                if (!isNaN(val)) {
                    flag = true;
                }
                break;
            case input.validationType === "int":
                val = parseInt(input.value);
                if (!isNaN(val)) {
                    flag = true;
                }
                break;
            case input.validationType === "non-empty":
                if (input.value !== "") {
                    flag = true;
                }
                break;
            case input.validationType === "non-numeric":
                regex = /[0-9]/;
                if (!regex.test(input.value)) {
                    flag = true;
                }
                break;
            case input.validationType === "phone":
                /*
                 * http://stackoverflow.com/a/123666
                 */
                regex = /^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/;
                if (regex.test(input.value)) {
                    flag = true;
                }
                break;
            case input.validationType === "regex":
                regex = input.regex;
                if (regex.test(input.value)) {
                    flag = true;
                }
                break;
            case new RegExp("^select-").test(input.validationType):
                n = parseInt(input.validationType.substring(7));
                count = 0;
                for (element in input.elements) {
                    count += $(element + " option:selected").length;
                }
                break;
            case input.validationType === "url":
                /*
                 * http://stackoverflow.com/a/8317014
                 */
                regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i;
                if (regex.test(input.value)) {
                    flag = true;
                }
                break;
            default:
                alert("Invalid validation type passed");
        }

        if (!flag) {
            returnVal = false;
            var image;
            switch (input.alertLevel) {
                case "notification":
                    image = "information.png";
                    break;
                case "warning":
                    image = "error.png";
                    break;
                case "error":
                    image = "exclamation.png";
                    break;
            }
            var alerts = '<div>\n' +
                '    <span>\n' +
                '        <img class="remove-alert" src="' + window.location.hostname + '/mycollege/resources/images/cancel.png"; ?>" title="Dismiss">\n' +
                '    </span>\n' +
                '    <img src="' + window.location.hostname + '/mycollege/resources/images/' + image + '">\n' +
                '    The value for ' + input.name + ' could not be validated. ' + input.alertLevel + ' message: ' + input.alertMessage + '\n' +
                '</div>';

            $("#" + input.alertLevel + "s").append(alerts);
        }
    }
    return returnVal;
}