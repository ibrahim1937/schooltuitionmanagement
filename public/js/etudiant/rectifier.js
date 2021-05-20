$(document).ready(function () {
    $.ajax({
        url: rectifier1,
        type: "post",
        data: {
            _token: $(document).find("meta[name=csrf-token]").attr("content"),
            op: "afficher",
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            remplir($("#content-rectifier"), data);
            $(".display").DataTable();
        },
        error: function (error) {
            console.log(error);
        },
    });
    $(document).on("change", "#module", function () {
        if ($("#module").find(":selected").val()) {
            console.log("tr");
            $.ajax({
                url: rectifier1,
                type: "post",
                data: {
                    _token: $(document)
                        .find("meta[name=csrf-token]")
                        .attr("content"),
                    op: "element",
                    id_module: $("#module").val(),
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    remplirselect(data, $("#element"));
                    $("#element").prop("disabled", false);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });
    $(".btn").click(function (e) {
        e.preventDefault();

        $.ajax({
            url: rectifier1,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "ajouter",
                id_module: $("#module").val(),
                id_element: $("#element").val(),
                commentaire: $("#commentaire").val(),
            },
            dataType: "json",
            dataType: "json",
            success: function (data) {
                console.log(data.data);

                if (data.message.title == "fail") {
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
                }
                $(".display").DataTable().destroy();
                remplir($("#content-rectifier"), data.data);
                $(".display").DataTable();

                $("#add")[0].reset();

                hideMessage();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});

function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne +=
            '<tr><th scope="row"><input type="checkbox" name="elemets" value=""> &nbsp ' +
            myData[i].id +
            "</th>";
        ligne += "<td> " + myData[i].module + "</td>";
        ligne += "<td> " + myData[i].element + "</td>";
        myData[i].commentaire
            ? (ligne += "<td> " + myData[i].commentaire + "</td>")
            : (ligne += "<td> " + "No commentaire" + "</td>");
        // ligne += "<td> " + myData[i].commentaire + "</td>";
        ligne += "<td> " + (myData[i].message == 'prête' ? 'acceptée' : myData[i].message) + "</td></tr>";
    }

    selector.html(ligne);
}

function remplirselect(myData, selector) {
    lignes = '<option value="">Choisissez un element</option>';
    for (let i = 0; i < myData.length; i++) {
        lignes +=
            '<option value="' +
            myData[i].id +
            '">' +
            myData[i].nom +
            "</option>";
    }
    selector.html(lignes);
}

function hideMessage() {
    if ($(".fail")) {
        setTimeout(function () {
            $(".fail").hide();
        }, 5000);
    }
    if ($(".success")) {
        setTimeout(function () {
            $(".success").hide();
        }, 5000);
    }
}
