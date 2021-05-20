$(document).ready(function() {
    $("#forgetform").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: forgetpassword,
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                hideError();
                if (data.error) {
                    showError(data.error);
                } else if (data.success) {
                    displayErrorOrSuccessMessages(
                        $("#forgetform"),
                        data.success
                    );
                    $("#email").val("");
                } else if (data.failemail) {
                    displayErrorOrSuccessMessages(
                        $("#forgetform"),
                        data.failemail
                    );
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});

function showError(data) {
    for (property in data) {
        if (property == "email") {
            $(".emailcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".emailcontainer :input").addClass("is-invalid");
        }
    }
}

function hideError() {
    $(document)
        .find("#forgetform")
        .eq(0)
        .children()
        .find(".failfield")
        .each(function(e) {
            $(this).hide();
        });
    $("#forgetform :input").each(function() {
        if ($(this).hasClass("is-invalid")) {
            $(this).removeClass("is-invalid");
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
            '<div class="alert alert-success m-3 fail">' + message + "</div>"
        );
    }
    hideMessage();
}
