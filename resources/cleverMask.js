/**
 * Helper function for cleverMask
 * @param str
 * @returns {boolean}
 */
function isAlpha(str) {
    return /^[a-zA-Z]+$/.test(str);
}

/**
 * Helper function for cleverMask
 * @param str
 * @returns {boolean}
 */
function isSpacer(str) {
    return /[\s,\-().]/.test(str);
}

/**
 * This is a custom jQuery addon to allow us to easily apply masks to input fields for user convenience.
 * It will automatically format the user's input into the form specified in the given mask in the data-clevermask
 * HTML attribute, and then save the actual value of the input to the data-clevermaskout HTML attribute.
 *
 * Currently, the following mask options are supported:
 * Mask characters:
 * 0 - Numerics
 * a - Alphas
 *
 * "-", ",", " ", "(", ")", "." - auto-formatting spacers
 *
 * Example use:
 * data-clevermask="000 000-0000" //for phone numbers
 * data-clevermask="0,000,000" //for an integer <= 9,999,999
 */
(function ($) {
    $.fn.cleverMask = function (options) {
        var mask = $(this).data("clevermask");
        return this.each(function () {
            $(this).on('keyup', function () {
                var inval = $(this).val().substr(0,Math.min($(this).val().length, mask.length));
                var outForm = "";
                var outVal = "";
                var j = 0;
                for (var i = 0; i < inval.length; i++) {
                    var activeChar = inval.charAt(i);
                    var activeMask = mask.charAt(j);
                    switch(activeMask) {
                        case "0": //Numerics
                            if(jQuery.isNumeric(activeChar)) {
                                outForm += activeChar;
                                outVal += activeChar;
                            } else if(isAlpha(activeChar)) {
                                j--; //bad input, recheck the current mask position with the next char
                            } else if(isSpacer(activeChar)) {
                                j--; //bad input, recheck the current mask position with the next char
                            }
                            break;
                        case "a": //Alphas
                            if(jQuery.isNumeric(activeChar)) {
                                j--; //bad input, recheck the current mask position with the next char
                            } else if(isAlpha(activeChar)) {
                                outForm += activeChar;
                                outVal += activeChar;
                            } else if(isSpacer(activeChar)) {
                                j--; //bad input, recheck the current mask position with the next char
                            }
                            break;
                        case " ": //Spacers
                        case ",":
                        case "-":
                        case "(":
                        case ")":
                        case ".":
                            if(jQuery.isNumeric(activeChar)) {
                                outForm += activeMask;
                                i--; //normal input, recheck current char at next mask position
                            } else if(isAlpha(activeChar)) {
                                outForm += activeMask;
                                i--; //normal input, recheck current char at next mask position
                            } else if(isSpacer(activeChar)) {
                                outForm += activeMask;
                            }
                            break;
                    }
                    j++;
                }
                $(this).val(outForm);
                $(this).attr("data-clevermaskout", outVal);
            });
        });
    };
})(jQuery);
