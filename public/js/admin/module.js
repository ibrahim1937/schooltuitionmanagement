$(document).ready(function() {
    showAll();

    $("#modulesubmit").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: gestionmoduleurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "ajouter",
                nom: $("#nom").val(),
                id_filiere: $("#filiere").val()
            },
            dataType: "json",
            success: function(data) {
                hideErrorMessage(".moduleajoutcontainer");
                hideError();
                if (data.error) {
                    showError(data.error);
                } else if (data.message.title == "success") {
                    $(".moduleajoutcontainer").prepend(
                        '<div class="alert alert-success m-3 success">' +
                            data.message.message +
                            "</div>"
                    );
                    hideMessage();
                    $(".display")
                        .DataTable()
                        .destroy();
                    fillAll(".display", $("#content-module"), data.data);
                    $("#nom").val("");
                    $("#filiere").prop("selectedIndex", 0);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on("change", "th[scope=row]>input", function(e) {
        if (checkedcount() > 0) {
            $("#delete").removeAttr("disabled");
        } else {
            $("#delete").attr("disabled", "disabled");
        }
    });

    $(document).on("click", "#selectall", function(e) {
        selectAll();
    });

    $("#delete").click(function(e) {
        e.preventDefault();
        var msg = "Veuillez vous vraiment supprimer ";
        var message =
            checkedcount() == 1
                ? msg + " çe module ? "
                : msg + checkedcount() + " modules ?";
        $(".confirmtext").text(message);
    });

    $("#deletebutton").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: gestionmoduleurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "delete",
                items: checkedids()
            },
            success: function(data) {
                fillAll(".display", $("#content-module"), data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $("#deletemodule").modal("hide");
    });

    $(document).on("click", ".modifier", function(e) {
        e.preventDefault();
        $("#nomm").val(
            $(this)
                .parent()
                .closest("tr")
                .find("td")
                .eq(0)
                .text()
        );
        var idfiliere = parseInt(
            $(this)
                .parent()
                .closest("tr")
                .find("td")
                .eq(1)
                .attr("value")
        );
        sessionStorage.setItem(
            "idmodule",
            parseInt(
                $(this)
                    .parent()
                    .closest("tr")
                    .find("th")
                    .eq(0)
                    .attr("value")
            )
        );
        clearSelect($("#filierem"));
        $("#filierem")
            .children()
            .each(function() {
                if ($(this).val() == idfiliere) {
                    console.log("ok");
                    $(this).attr("selected", "selected");
                }
            });
    });

    $("#modifier").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: gestionmoduleurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "update",
                id: sessionStorage.getItem("idmodule"),
                nom: $("#nomm").val(),
                id_filiere: $("#filierem")
                    .find(":selected")
                    .val()
            },
            dataType: "json",
            success: function(data) {
                hideErrorMessage("#form-modifier");
                hideError("modifier");
                if (data.error) {
                    showErrorModifier(data.error);
                } else {
                    fillAll(".display", $("#content-module"), data);
                    $("#exampleModal").modal("hide");
                }
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on("change", "#filieresearch", function(e) {
        if ($(this).val()) {
            $.ajax({
                url: gestionmoduleurl,
                type: "post",
                data: {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "search",
                    id_filiere: $(this).val()
                },
                success: function(data) {
                    fillAll(".display", $("#content-module"), data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            showAll();
        }
    });

    $("#exampleModal").on("hidden.bs.modal", function() {
        $(document)
            .find(".failfield")
            .hide();
        hideError("modifier");
        $("#form-modifier")[0].reset();
    });
});

function checkedcount() {
    var count = 0;
    $(document)
        .find("th[scope=row]>input:checked")
        .each(function() {
            count++;
        });
    return count;
}
function checkedids() {
    var ids = new Array();
    $(document)
        .find("th[scope=row]>input:checked")
        .each(function() {
            ids.push(
                parseInt(
                    $(this)
                        .parent()
                        .attr("value")
                )
            );
        });
    return ids;
}

function selectAll() {
    if (sessionStorage.getItem("allchecked")) {
        $(document)
            .find("th[scope=row]>input")
            .each(function() {
                $(this)
                    .eq(0)
                    .prop("checked", false);
                sessionStorage.removeItem("allchecked");
                $("#delete").attr("disabled", "disabled");
            });
        return;
    }

    $(document)
        .find("th[scope=row]>input")
        .each(function() {
            $(this)
                .eq(0)
                .prop("checked", true);
            sessionStorage.setItem("allchecked", true);
            $("#delete").removeAttr("disabled");
        });
}
function fillAll(table, selector, myData) {
    if ($.fn.DataTable.isDataTable(table)) {
        $(table)
            .DataTable()
            .destroy();
    }
    remplir(selector, myData);
    $(table).DataTable({
        order: []
    });
}

function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne +=
            '<tr><th scope="row" value="' +
            myData[i].id +
            '"><input type="checkbox" name="modules" value=""> &nbsp ' +
            (i + 1) +
            "</th>";
        ligne += "<td> " + myData[i].nom + "</td>";
        ligne +=
            '<td value="' +
            myData[i].filiere.id +
            '"> ' +
            myData[i].filiere.code +
            "</td>";
        ligne +=
            '<td class="text-center"><button type="button" class="btn btn-primary modifier" title="Modifier un module" data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier</button></td></tr>';
    }

    selector.html(ligne);
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
// TODO check if i need this
function clearSelect(selector) {
    selector.children().each(function(e) {
        if ($(this).selected) {
            $(this).attr("selected", false);
        }
    });
}

function showError(data) {
    for (property in data) {
        if (property == "nom") {
            $(".codemodulecontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".codemodulecontainer :input").addClass("is-invalid");
        } else if (property == "id_filiere") {
            $(".filierecontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $("#filiere").addClass("is-invalid");
        }
    }
}

function showErrorModifier(data) {
    for (property in data) {
        if (property == "nom") {
            $(".nommcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".nommcontainer :input").addClass("is-invalid");
        } else if (property == "id_filiere") {
            $(".filieremcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $("#filierem").addClass("is-invalid");
        }
    }
}

function hideError(option = "addform") {
    if (option == "addform") {
        $(".moduleajoutcontainer :input").each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
    } else if (option == "modifier") {
        $("#form-modifier :input").each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
    }
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

function showAll() {
    $.ajax({
        url: gestionmoduleurl,
        type: "post",
        data: {
            _token: $(document)
                .find("meta[name=csrf-token]")
                .attr("content"),
            op: "afficher"
        },
        dataType: "json",
        success: function(data) {
            fillAll(".display", $("#content-module"), data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function hideErrorMessage(selector) {
    $(document)
        .find(selector)
        .eq(0)
        .children()
        .find(".failfield")
        .each(function() {
            $(this).hide();
        });
}
