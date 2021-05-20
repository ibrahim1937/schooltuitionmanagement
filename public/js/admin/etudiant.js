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
    $("#reset").click(function() {
        resetImportForm();
    });

    $("#resetetudiant").click(function() {
        reset();
    });

    $("#submitetudiant").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: gestionurl,
            type: "POST",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "ajouter",
                nom: $("#nom").val(),
                prenom: $("#prenom").val(),
                email: $("#email").val(),
                cin: $("#cin").val(),
                id_filiere: $("#filiereselect").val()
            },
            dataType: "json",
            success: function(data) {
                hideErrorMessage(".formcontainer");
                if (data.error) {
                    hideErrorsAfterSubmit();
                    errorHandler(data.error);
                } else {
                    messagesHandler($(".error-ajout"));
                    hideErrorsAfterSubmit();
                    viderchamp();
                }
            },
            error: function(error, textStatus, jqXHR) {
                console.log(error);
            }
        });
    });

    $("#importform").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: importurl,
            type: "POST",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: "multipart/form-data",
            processData: false,
            dataType: "json",
            success: function(data) {
                hideErrorsAfterSubmit("importform");
                hideerrormessage();
                if (data.error) {
                    errorHandler(data.error, "importform");
                } else if (data.inserterrors) {
                    importerrorHandler(data.inserterrors);
                } else if (data.styleerror) {
                    $("#importform").prepend(
                        '<span class="text-danger failmessage m-3">' +
                            data.styleerror +
                            "</span>"
                    );
                } else if (data.success) {
                    viderimport();
                    $("#importform").prepend(
                        '<div class="alert alert-success success m-3" role="alert">' +
                            data.registeredcount +
                            "</div>"
                    );
                    hideMessage();
                }
            },
            error: function(error, textStatus, jqXHR) {
                console.log(error);
            }
        });
    });
});

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

function messagesHandler(selector, type = "success") {
    if (type == "success") {
        selector.prepend(
            '<div class="alert alert-success success m-3" role="alert">L\'étudiant est enregistrée avec succès</div>'
        );
    } else if (type == "faildatabase") {
        selector.prepend(
            '<div class="alert alert-danger m-3 fail">Problem lors de la connexion avec la database ressayer à nouveau ulterieurement </div>'
        );
    } else if (type == "fail") {
        selector.prepend(
            '<div class="alert alert-danger fail m-3" role="alert">Veuillez verifier la validité des valeurs entrées</div>'
        );
    }

    hideMessage();
}

function viderchamp() {
    $("#nom").val("");
    $("#prenom").val("");
    $("#email").val("");
    $("#cin").val("");
    $("#filiereselect").prop("selectedIndex", 0);
}

function errorHandler(myData, type = "form") {
    if (type == "form") {
        for (const property in myData) {
            if (property == "email") {
                $(".emailcontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#email").addClass("is-invalid");
            } else if (property == "cin") {
                $(".cincontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#cin").addClass("is-invalid");
            } else if (property == "nom") {
                $(".nomcontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#nom").addClass("is-invalid");
            } else if (property == "prenom") {
                $(".prenomcontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#prenom").addClass("is-invalid");
            } else if (property == "id_filiere") {
                $("#filiereselect").addClass("is-invalid");
                $(".filierecontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
            }
        }
    } else if (type == "modifierform") {
        for (const property in myData) {
            if (property == "email") {
                $(".emailcontainerm").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#emailm").addClass("is-invalid");
            } else if (property == "cin") {
                $(".cincontainerm").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#cinm").addClass("is-invalid");
            } else if (property == "nom") {
                $(".nomcontainerm").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#nomm").addClass("is-invalid");
            } else if (property == "prenom") {
                $(".prenomcontainerm").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#prenomm").addClass("is-invalid");
            } else if (property == "id_filiere") {
                $("#filierem").addClass("is-invalid");
                $(".filierecontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
            }
        }
    } else if (type == "importform") {
        for (const property in myData) {
            if (property == "filiere") {
                $(".filierecontainerimport").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#filiereselectimport").addClass("is-invalid");
            } else if (property == "file") {
                $(".filecontainer").append(
                    '<span class="text-danger failmessage">' +
                        myData[property] +
                        "</span>"
                );
                $("#customFile").addClass("is-invalid");
            }
        }
    }
}

function hideErrorsAfterSubmit(option = "ajouter") {
    if (option == "modifier") {
        $("#form-modifier :input").each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
        return;
    } else if (option == "importform") {
        $("#importform :input").each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
    }
    $(".formcontainer :input").each(function() {
        if ($(this).hasClass("is-invalid")) {
            $(this).removeClass("is-invalid");
        }
    });
}

function hideerrormessage() {
    if ($(".failmessage")) {
        $(".failmessage").hide();
    }
}

function importerrorHandler(myData) {
    var lignes = "";
    if (myData.length > 1) {
        for (let i = 0; i < myData.length; i++) {
            if (myData.length == 2 && i == 0) {
                lignes += " " + myData[i].ligne + " ";
                continue;
            }
            if (i == myData.length - 1) {
                lignes += "et " + myData[i].ligne;
                continue;
            }
            lignes += myData[i].ligne + ", ";
        }
        $("#importform").prepend(
            '<span class="text-danger failmessage m-3">Verrifiez que les informations des étudiants dans les lignes ' +
                lignes +
                " sont correctes et uniques" +
                "</span>"
        );
    } else if (myData.length == 1) {
        lignes += myData[0].ligne;
        $("#importform").prepend(
            '<span class="text-danger failmessage m-3">Verrifiez que les informations du l\'étudiant dans la ligne ' +
                lignes +
                " sont correctes et uniques" +
                "</span>"
        );
    }
}

function viderimport() {
    $("#filiereselectimport").prop("selectedIndex", 0);
    $(".custom-file-label").html("Choisissez un fichier excel");
}

function reset() {
    viderchamp();
    hideErrorsAfterSubmit();
    hideErrorMessage(".formcontainer");
}
function resetImportForm() {
    viderimport();
    hideErrorsAfterSubmit("importform");
    hideErrorMessage("#importform");
}

function hideErrorMessage(selector) {
    $(document)
        .find(selector)
        .eq(0)
        .children()
        .find(".failmessage")
        .each(function() {
            $(this).hide();
        });
}
