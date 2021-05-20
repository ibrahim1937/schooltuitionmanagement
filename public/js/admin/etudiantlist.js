sessionStorage.clear();
$(document).ready(function() {
    showAll();

    $("#deletebutton").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: gestionurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "delete",
                items: checkedids()
            },
            dataType: "json",
            success: function(data) {
                fillAll(".display", $("#content-etudiant"), data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });

        $("#deleteetudiant").modal("hide");
    });
    $(document).on("click", "#selectall", function(e) {
        selectAll();
    });

    $(document).on("change", "th[scope=row]>input", function(e) {
        if (checkedcount() > 0) {
            $("#delete").removeAttr("disabled");
        } else {
            $("#delete").attr("disabled", "disabled");
        }
    });

    $(document).on("click", ".modifier", function(e) {
        e.preventDefault();
        element = $(this);
        $("#nomm").val(
            element
                .parent()
                .closest("tr")
                .find("td")
                .eq(0)
                .text()
        );
        $("#prenomm").val(
            element
                .parent()
                .closest("tr")
                .find("td")
                .eq(1)
                .text()
        );
        $("#emailm").val(
            element
                .parent()
                .closest("tr")
                .find("td")
                .eq(3)
                .text()
        );
        $("#cinm").val(
            element
                .parent()
                .closest("tr")
                .find("td")
                .eq(2)
                .text()
        );
        console.log(
            parseInt(
                element
                    .parent()
                    .closest("tr")
                    .find("td")
                    .eq(4)
                    .attr("value")
            )
        );
        selectItem(
            $("#filierem"),
            parseInt(
                element
                    .parent()
                    .closest("tr")
                    .find("td")
                    .eq(4)
                    .attr("value")
            )
        );

        sessionStorage.setItem(
            "idetudiant",
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
        hideError();
        $.ajax({
            url: gestionurl,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "update",
                nom: $("#nomm").val(),
                prenom: $("#prenomm").val(),
                email: $("#emailm").val(),
                cin: $("#cinm").val(),
                id_filiere: $("#filierem").val(),
                id: sessionStorage.getItem("idetudiant")
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data.error) {
                    showError(data.error);
                } else {
                    fillAll(".display", $("#content-etudiant"), data);
                    $("#exampleModal").modal("hide");
                    $("#form-modifier")[0].reset();
                    sessionStorage.removeItem("idetudiant");
                }
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
                ? msg + "cet etudiant ? "
                : msg + checkedcount() + " etudiants ?";
        $(".confirmtext").text(message);
    });

    $(document).on("change", "#filiereselect", function() {
        if ($(this).val()) {
            $.ajax({
                url: gestionurl,
                type: "post",
                data: {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "filtragefiliere",
                    id_filiere: parseInt($(this).val())
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    fillAll(".display", $("#content-etudiant"), data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            showAll();
        }
    });
});

function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne +=
            '<tr><th scope="row" value="' +
            myData[i].id +
            '"><input type="checkbox" name="profs" value="">&nbsp' +
            (i + 1) +
            "</th>";
        ligne += "<td> " + myData[i].nom + "</td>";
        ligne += "<td> " + myData[i].prenom + "</td>";
        ligne += "<td> " + myData[i].cin + "</td>";
        ligne += "<td> " + myData[i].email + "</td>";
        ligne +=
            '<td value="' +
            myData[i].filiere.id +
            '"> ' +
            myData[i].filiere.code +
            "</td>";
        ligne +=
            '<td class="text-center"><button type="button" class="btn btn-primary modifier" title="Modifier un etudiant" data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier</button></td></tr>';
    }

    selector.html(ligne);
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

function showAll() {
    $.ajax({
        url: gestionurl,
        type: "POST",
        data: {
            _token: $(document)
                .find("meta[name=csrf-token]")
                .attr("content"),
            op: "afficher"
        },
        dataType: "json",
        success: function(data) {
            console.log(data);
            fillAll(".display", $("#content-etudiant"), data);
        },
        error: function(error) {
            console.log(error);
        }
    });
}
function selectItem(selector, Item) {
    selector.children().each(function() {
        if ($(this).attr("value") == Item) {
            $(this).prop("selected", true);
        }
    });
}

function showError(myData) {
    for (const property in myData) {
        if (property == "email") {
            $(".emailcontainerm").append(
                '<span class="text-danger failfield">' +
                    myData[property] +
                    "</span>"
            );
            $("#emailm").addClass("is-invalid");
        } else if (property == "cin") {
            $(".cincontainerm").append(
                '<span class="text-danger failfield">' +
                    myData[property] +
                    "</span>"
            );
            $("#cinm").addClass("is-invalid");
        } else if (property == "nom") {
            $(".nomcontainerm").append(
                '<span class="text-danger failfield">' +
                    myData[property] +
                    "</span>"
            );
            $("#nomm").addClass("is-invalid");
        } else if (property == "prenom") {
            $(".prenomcontainerm").append(
                '<span class="text-danger failfield">' +
                    myData[property] +
                    "</span>"
            );
            $("#prenomm").addClass("is-invalid");
        } else if (property == "id_filiere") {
            $(".filierecontainerm").append(
                '<span class="text-danger failfield">' +
                    myData[property] +
                    "</span>"
            );
            $("#filierem").addClass("is-invalid");
        }
    }
}

function hideError() {
    $(document)
        .find("#form-modifier")
        .eq(0)
        .find(":input")
        .each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
    $(document)
        .find("#form-modifier")
        .eq(0)
        .children()
        .find(".failfield")
        .each(function() {
            $(this).hide();
        });
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
                $("#delete").attr("disabled", "disabled");
            });
        sessionStorage.removeItem("allchecked");
        return;
    }

    $(document)
        .find("th[scope=row]>input")
        .each(function() {
            $(this)
                .eq(0)
                .prop("checked", true);
            $("#delete").removeAttr("disabled");
            checkedids();
        });
    sessionStorage.setItem("allchecked", true);
}
