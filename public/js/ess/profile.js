$(".custom-file-input").on("change", function() {
    var fileName = $(this)
        .val()
        .split("\\")
        .pop();
    $(this)
        .siblings(".custom-file-label")
        .addClass("selected")
        .html(fileName);
});

$(document).ready(function() {
    $("#passwordform").submit(function(e) {
        hideErrorPassword();
        e.preventDefault();
        $.ajax({
            url: profileurl,
            type: "post",
            data: $(this).serialize(),
            success: function(data) {
                if (data.error) {
                    showErrorPassword(data.error);
                } else if (data.success) {
                    displayErrorOrSuccessMessages(
                        $("#passwordform"),
                        data.success
                    );
                    $("#passwordform")[0].reset();
                }

                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(".editcontainer > i").click(function(e) {
        console.log("clicked");
        customHideElement($(this));
        $(this)
            .parent()
            .parent()
            .find(".validatecontainer > i")
            .eq(0)
            .show();
    });

    $(".validatecontainer > i").click(function(e) {
        hideError();
        var container = $(this).closest(".success-container");
        var attr = $(this)
            .parent()
            .parent()
            .find(":input")
            .eq(0)
            .attr("name");
        var value = $(this)
            .parent()
            .parent()
            .find(":input")
            .eq(0)
            .val();
        var token = $(document)
            .find("meta[name=csrf-token]")
            .attr("content");
        var myData;
        if (attr == "nom") {
            myData = {
                _token: token,
                op: "modifier",
                nom: value
            };
        } else if (attr == "prenom") {
            myData = {
                _token: token,
                op: "modifier",
                prenom: value
            };
        } else if (attr == "cin") {
            myData = {
                _token: token,
                op: "modifier",
                cin: value
            };
        } else if (attr == "email") {
            myData = {
                _token: token,
                op: "modifier",
                email: value
            };
        }
        $.ajax({
            url: profileurl,
            type: "post",
            data: myData,
            success: function(data) {
                if (data.error) {
                    showError(data.error);
                } else if (data.success) {
                    showSuccess(container, data.success);
                    // $(this)
                    //     .parent()
                    //     .parent()
                    //     .append("");
                }
                // if (data.error) {
                //     showErrorPassword(data.error);
                // } else if (data.success) {
                //     displayErrorOrSuccessMessages(
                //         $("#passwordform"),
                //         data.success
                //     );
                //     $("#passwordform")[0].reset();
                // }
                console.log(data);
            }
        });
        customHideElement($(this));
        $(this)
            .parent()
            .parent()
            .find(".editcontainer > i")
            .eq(0)
            .show();
    });
});

function showErrorPassword(data) {
    for (property in data) {
        if (property == "oldpassword") {
            $(".oldpasswordcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".oldpasswordcontainer :input").addClass("is-invalid");
        } else if (property == "newpassword") {
            $(".newpasswordcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".newpasswordcontainer :input").addClass("is-invalid");
        } else if (property == "newpassword_confirmation") {
            var message =
                data[property].length == 2
                    ? '<span class="text text-danger m-3 failfield">' +
                      data[property][0] +
                      "</span>" +
                      "<br>" +
                      '<span class="text text-danger m-3 failfield">' +
                      data[property][1] +
                      "</span>"
                    : '<span class="text text-danger m-3 failfield">' +
                      data[property] +
                      "</span>";
            $(".newpassword_confirmationcontainer").append(message);
            $(".newpassword_confirmationcontainer :input").addClass(
                "is-invalid"
            );
        }
    }
}
function hideErrorPassword() {
    $(document)
        .find("#passwordform")
        .eq(0)
        .children()
        .find(":input")
        .each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
                $(this)
                    .parent()
                    .find(".failfield")
                    .each(function() {
                        $(this).hide();
                    });
            }
        });
}
function hideMessage() {
    if ($(".fail")) {
        setTimeout(function() {
            $(".fail").hide();
        }, 5000);
    }
    if ($(".success")) {
        setTimeout(function() {
            $(".success").hide();
        }, 5000);
    }
}

function displayErrorOrSuccessMessages(selector, message, option = "success") {
    if (option == "success") {
        selector.prepend(
            '<div class="alert alert-success m-3 success">' + message + "</div>"
        );
    } else if (option == "fail") {
        selector.prepend(
            '<div class="alert alert-danger m-3 fail">' + message + "</div>"
        );
    }
    hideMessage();
}

function customHideElement(selector) {
    selector.hide();

    var input = selector
        .parent()
        .parent()
        .find(":input")
        .eq(0);
    if (input.is(":disabled")) {
        input.prop("disabled", false);
        input.focus();
    } else {
        input.prop("disabled", true);
        input.blur();
    }
}

function showError(data) {
    for (property in data) {
        if (property == "nom") {
            $(".nomcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".nomcontainer :input").addClass("is-invalid");
        } else if (property == "prenom") {
            $(".prenomcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".prenomcontainer :input").addClass("is-invalid");
        } else if (property == "email") {
            $(".emailcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".emailcontainer :input").addClass("is-invalid");
        } else if (property == "cin") {
            $(".cincontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".cincontainer :input").addClass("is-invalid");
        }
    }
}

function hideError() {
    $(document)
        .find(".formcontainer")
        .eq(0)
        .find(":input")
        .each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });

    $(document)
        .find(".formcontainer")
        .eq(0)
        .find(".failfield")
        .each(function() {
            $(this).hide();
        });
}

function showSuccess(selector, data) {
    selector.append(
        '<span class="text text-success m-3 success">' + data + "</span>"
    );
    hideMessage();
}
