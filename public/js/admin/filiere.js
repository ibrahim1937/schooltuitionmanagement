sessionStorage.clear();

$(document).ready(function() {
    $.ajax({
        url: gestionfiliereurl,
        type: "post",
        data: {
            _token: $(document)
                .find("meta[name=csrf-token]")
                .attr("content"),
            op: "afficher"
        },
        success: function(data) {
            fillAll(".display", $("#content-filiere"), data);
        },
        error: function(error) {
            console.log(error);
        }
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

    $("#add").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: gestionfiliereurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "ajouter",
                code: $("#code").val(),
                libelle: $("#libelle").val()
            },
            dataType: "json",
            success: function(data) {
                hideError();
                hideErrorMessage("#add");
                console.log(data);
                if (data.error) {
                    showError(data.error);
                } else if (data.message.title == "fail") {
                    $("#add").prepend(
                        '<div class="alert alert-danger m-3 fail">' +
                            data.message.message +
                            "</div>"
                    );
                } else if (data.message.title == "success") {
                    $("#add").prepend(
                        '<div class="alert alert-success m-3 success">' +
                            data.message.message +
                            "</div>"
                    );
                    remplir($("#content-filiere"), data.data);
                    $("#add")[0].reset();
                }

                hideMessage();
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $("#delete").click(function(e) {
        e.preventDefault();
        var msg = "Veuillez vous vraiment supprimer ";
        var message =
            checkedcount() == 1
                ? msg + "cette filiere ? "
                : msg + checkedcount() + " filieres ?";
        $(".confirmtext").text(message);
    });

    $("#deletebutton").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: gestionfiliereurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "delete",
                items: checkedids()
            },
            success: function(data) {
                $(".display")
                    .DataTable()
                    .destroy();
                remplir($("#content-filiere"), data);
                $(".display").DataTable();
            },
            error: function(error) {
                console.log(error);
            }
        });

        $("#deletefiliere").modal("hide");
    });

    $(document).on("click", ".modifier", function(e) {
        e.preventDefault();
        $("#codem").val(
            $(this)
                .parent()
                .closest("tr")
                .find("td")
                .eq(0)
                .text()
        );
        $("#libellem").val(
            $(this)
                .parent()
                .closest("tr")
                .find("td")
                .eq(1)
                .text()
        );
        sessionStorage.setItem(
            "idfiliere",
            parseInt(
                $(this)
                    .parent()
                    .closest("tr")
                    .find("th")
                    .eq(0)
                    .attr("value")
            )
        );
    });

    $("#modifier").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: gestionfiliereurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "update",
                code: $("#codem").val(),
                libelle: $("#libellem").val(),
                id: sessionStorage.getItem("idfiliere")
            },
            dataType: "json",
            success: function(data) {
                hideErrorMessage("#form-modifier");
                console.log(data);
                hideError("modifier");
                if (data.error) {
                    showErrorModifier(data.error);
                } else {
                    fillAll(".display", $("#content-filiere"), data);
                    $("#exampleModal").modal("hide");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $("#exampleModal").on("hidden.bs.modal", function() {
        $(document)
            .find(".failfield")
            .hide();
        hideError("modifier");
        $("#form-modifier")[0].reset();
    });
});

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
            '"><input type="checkbox" name="filieres" value=""> &nbsp ' +
            (i + 1) +
            "</th>";
        ligne += "<td> " + myData[i].code + "</td>";
        ligne += "<td> " + myData[i].libelle + "</td>";
        ligne +=
            '<td class="text-center"><button type="button" class="btn btn-primary modifier" title="Modifier une filiere" data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier</button></td></tr>';
    }

    selector.html(ligne);
}

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
        if (property == "code") {
            $(".codecontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".codecontainer :input").addClass("is-invalid");
        } else if (property == "libelle") {
            $(".libellecontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".libellecontainer :input").addClass("is-invalid");
        }
    }
}

function showErrorModifier(data) {
    for (property in data) {
        if (property == "code") {
            $(".codemcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".codemcontainer :input").addClass("is-invalid");
        } else if (property == "libelle") {
            $(".libellemcontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".libellemcontainer :input").addClass("is-invalid");
        }
    }
}

function hideError(option = "normal") {
    if (option == "normal") {
        $("#add :input").each(function() {
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
