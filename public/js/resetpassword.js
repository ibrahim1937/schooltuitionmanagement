$(document).ready(function() {
    $("#resetform").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: resetpassword,
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                hideError();
                if (data.error) {
                    showError(data.error);
                } else if (data.success) {
                    displayErrorOrSuccessMessages(
                        $("#resetform"),
                        data.success
                    );
                    $("#resetform")[0].reset();
                } else if (data.tokenerror) {
                    displayErrorOrSuccessMessages(
                        $("#resetform"),
                        data.tokenerror,
                        "fail"
                    );
                } else if (data.fail) {
                    displayErrorOrSuccessMessages(
                        $("#resetform"),
                        data.fail,
                        "fail"
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

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

function showError(data) {
    for (property in data) {
        if (property == "password") {
            var message =
                data[property].length == 2
                    ? data[property][0] + "<br>" + data[property][1]
                    : data[property];
            $(".passwordcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    message +
                    "</span>"
            );
            $(".passwordcontainer :input").addClass("is-invalid");
        } else if (property == "password_confirmation") {
            $(".passwordcontainerc").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".passwordcontainerc :input").addClass("is-invalid");
        }
    }
}

function hideError() {
    $(document)
        .find("#resetform")
        .eq(0)
        .children()
        .find(".failfield")
        .each(function(e) {
            $(this).hide();
        });
    $("#resetform :input").each(function() {
        if ($(this).hasClass("is-invalid")) {
            $(this).removeClass("is-invalid");
        }
    });
}
