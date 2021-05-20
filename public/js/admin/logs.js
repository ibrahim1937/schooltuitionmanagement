$(document).ready(function() {
    showAll();
    // handling role select
    $(document).on("change", "#roleselect", function(e) {
        if ($(this).val()) {
            showSectionByRole(parseInt($(this).val()));
        } else {
            hideAllSections();
            showAll();
        }
    });
    // handling radio button select
    $(document).on("change", "input[name='dateoption']:checked", function() {
        var option = $(this).val();
        showDateSection(option);
    });
    // reset button
    $("#reset").click(function(e) {
        e.preventDefault();
        hideAllSections();
        hideDateSections();
        resetAllInputs();
    });

    $(document).on("change", "#filiereselect", function(e) {
        if ($(this).val()) {
            $.ajax({
                url: logsurl,
                type: "post",
                data: {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "etudiant",
                    id_filiere: $(this).val()
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    remplirSelect(
                        $("#etudiantselect"),
                        data,
                        '<option value="">Choisissez un etudiant</option>'
                    );
                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            $("#etudiantselect").html(
                '<option value="">Choisissez un etudiant</option>'
            );
        }
    });

    $("#searchlogs").click(function(e) {
        e.preventDefault();
        hideError();
        var role =
            $("#roleselect").val() == "" ? 0 : parseInt($("#roleselect").val());

        if (role == 0) {
            showAll();
            return;
        }
        var option = $("input[name='dateoption']:checked").val();
        if (option == "datedepart") {
            if ($("#date-only").val()) {
                if (role == 5) {
                    // etudiant
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "etudiantfiliere",
                        id_filiere:
                            $("#filiereselect").val() == ""
                                ? undefined
                                : parseInt($("#filiereselect").val()),
                        id_etudiant:
                            $("#etudiantselect").val() == ""
                                ? undefined
                                : parseInt($("#etudiantselect").val()),
                        date: $("#date-only").val()
                    };
                } else if (role == 2) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "professeur",
                        id_prof:
                            $("#professeurselect").val() == ""
                                ? undefined
                                : parseInt($("#professeurselect").val()),
                        date: $("#date-only").val()
                    };
                } else if (role == 3) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "agentscolarite",
                        id_agentscolarite:
                            $("#agentscolariteselect").val() == ""
                                ? undefined
                                : parseInt($("#agentscolariteselect").val()),
                        date: $("#date-only").val()
                    };
                } else if (role == 4) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "agentexamen",
                        id_agentexamen:
                            $("#agentexamenselect").val() == ""
                                ? undefined
                                : parseInt($("#agentexamenselect").val()),
                        date: $("#date-only").val()
                    };
                }
            } else {
                $("#date-only").addClass("is-invalid");
                $(".datecontainer").append(
                    '<span class="text text-danger failfield">La date doit etre selectionner</span>'
                );
            }
        } else if (option == "datedepartarrivee") {
            if ($("#start-date").val() && $("#end-date").val()) {
                console.log($("#start-date").val());
                if (role == 5) {
                    // etudiant
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "etudiantfiliere",
                        id_filiere:
                            $("#filiereselect").val() == ""
                                ? undefined
                                : parseInt($("#filiereselect").val()),
                        id_etudiant:
                            $("#etudiantselect").val() == ""
                                ? undefined
                                : parseInt($("#etudiantselect").val()),
                        date_debut: $("#start-date").val(),
                        date_fin: $("#end-date").val()
                    };
                } else if (role == 2) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "professeur",
                        id_prof:
                            $("#professeurselect").val() == ""
                                ? undefined
                                : parseInt($("#professeurselect").val()),
                        date_debut: $("#start-date").val(),
                        date_fin: $("#end-date").val()
                    };
                } else if (role == 3) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "agentscolarite",
                        id_agentscolarite:
                            $("#agentscolariteselect").val() == ""
                                ? undefined
                                : parseInt($("#agentscolariteselect").val()),
                        date_debut: $("#start-date").val(),
                        date_fin: $("#end-date").val()
                    };
                } else if (role == 4) {
                    var myData = {
                        _token: $(document)
                            .find("meta[name=csrf-token]")
                            .attr("content"),
                        op: "filtre",
                        filtreOp: "agentexamen",
                        id_agentexamen:
                            $("#agentexamenselect").val() == ""
                                ? undefined
                                : parseInt($("#agentexamenselect").val()),
                        date_debut: $("#start-date").val(),
                        date_fin: $("#end-date").val()
                    };
                }
            } else {
                $(".betweendates")
                    .find(":input")
                    .each(function() {
                        if (!$(this).val()) {
                            $(this).addClass("is-invalid");
                            $(this)
                                .parent()
                                .append(
                                    '<span class="text text-danger failfield">La date doit etre selectionner</span>'
                                );
                        }
                    });
            }
        } else {
            if (role == 5) {
                // etudiant
                var myData = {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "filtre",
                    filtreOp: "etudiantfiliere",
                    id_filiere:
                        $("#filiereselect").val() == ""
                            ? undefined
                            : parseInt($("#filiereselect").val()),
                    id_etudiant:
                        $("#etudiantselect").val() == ""
                            ? undefined
                            : parseInt($("#etudiantselect").val())
                };
            } else if (role == 2) {
                var myData = {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "filtre",
                    filtreOp: "professeur",
                    id_prof:
                        $("#professeurselect").val() == ""
                            ? undefined
                            : parseInt($("#professeurselect").val())
                };
            } else if (role == 3) {
                var myData = {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "filtre",
                    filtreOp: "agentscolarite",
                    id_agentscolarite:
                        $("#agentscolariteselect").val() == ""
                            ? undefined
                            : parseInt($("#agentscolariteselect").val())
                };
            } else if (role == 4) {
                var myData = {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "filtre",
                    filtreOp: "agentexamen",
                    id_agentexamen:
                        $("#agentexamenselect").val() == ""
                            ? undefined
                            : parseInt($("#agentexamenselect").val())
                };
            }
        }

        if (typeof myData !== "undefined") {
            $.ajax({
                url: logsurl,
                type: "post",
                data: myData,
                dataType: "json",
                success: function(data) {
                    fillAll(".display", $("#content-logs"), data);
                    console.log(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
});

// hide section
function hideSection(selector) {
    selector.hide();
}
function showSection(selector) {
    selector.show();
}

function hideAllSections() {
    hideSection($(".etudiantoption"));
    hideSection($(".professeuroption"));
    hideSection($(".agentscolariteoption"));
    hideSection($(".agentexamenoption"));
}

function showSectionByRole(role_id) {
    hideAllSections();
    if (role_id == 2) {
        showSection($(".professeuroption"));
    } else if (role_id == 3) {
        showSection($(".agentscolariteoption"));
    } else if (role_id == 4) {
        showSection($(".agentexamenoption"));
    } else if (role_id == 5) {
        showSection($(".etudiantoption"));
    }
}

function hideDateSections() {
    hideSection($(".dateunjour"));
    hideSection($(".betweendates"));
}

function showDateSection(option) {
    if (option == "datedepart") {
        showSection($(".dateunjour"));
        hideSection($(".betweendates"));
    } else if (option == "datedepartarrivee") {
        showSection($(".betweendates"));
        hideSection($(".dateunjour"));
    }
}

function resetAllInputs() {
    $("#roleselect").prop("selectedIndex", 0);
    $("#filiereselect").prop("selectedIndex", 0);
    $("#etudiantselect").prop("selectedIndex", 0);
    $("#agentscolariteselect").prop("selectedIndex", 0);
    $("#professeurselect").prop("selectedIndex", 0);
    $("#agentexamenselect").prop("selectedIndex", 0);

    // date input reset

    $("#date-only").val("");
    $("#start-date").val("");
    $("#end-date").val("");

    $('input[name="dateoption"]').prop("checked", false);

    showAll();
}

function showAll() {
    $.ajax({
        url: logsurl,
        type: "post",
        data: {
            _token: $(document)
                .find("meta[name=csrf-token]")
                .attr("content"),
            op: "afficher"
        },
        dataType: "json",
        success: function(data) {
            fillAll(".display", $("#content-logs"), data);
            console.log(data);
        },
        error: function(data) {
            console.log(data);
        }
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
            '"><input type="checkbox" name="profs" value="">&nbsp' +
            (i + 1) +
            "</th>";
        ligne += "<td> " + myData[i].nom + "</td>";
        ligne += "<td> " + myData[i].prenom + "</td>";
        ligne += "<td> " + myData[i].date_depart + "</td>";
        ligne += "<td> " + myData[i].date_fin + "</td>";
        ligne += "<td> " + myData[i].activity + "</td></tr>";
    }

    selector.html(ligne);
}

function remplirSelect(selector, data, message) {
    ligne = message;
    for (let i = 0; i < data.length; i++) {
        ligne +=
            '<option value="' +
            data[i].id +
            '"> ' +
            data[i].nom +
            " " +
            data[i].prenom +
            "</option>";
    }
    selector.html(ligne);
}

function hideError() {
    $(".dateunjour")
        .find(":input")
        .each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });
    $(".betweendates")
        .find(":input")
        .each(function() {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
            }
        });

    $(document)
        .find(".formcontainer")
        .children()
        .find(".failfield")
        .each(function() {
            $(this).hide();
        });
}
