$(document).ready(function () {
    $.ajax({
        url: gestionscolaritel,
        type: "post",
        data: {
            _token: $(document).find("meta[name=csrf-token]").attr("content"),
            op: "afficher",
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            remplir($("#content-demande"), data);
            $(".display").DataTable();
        },
        error: function (error) {
            console.log(error);
        },
    });

    $(".btn").click(function (e) {
        e.preventDefault();

        $.ajax({
            url: gestionscolaritel,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "ajouter",
                id_categorie: $("#demande").val(),
            },
            dataType: "json",
            success: function (data) {
                hideError();
                $(document).find(".failfield").hide();
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
                    remplir($("#content-demande"), data.data);
                    $("#add")[0].reset();
                }

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
            '<tr><th scope="row"><input type="checkbox" name="demande" value=""> ' +
            myData[i].id +
            "</th>";
        ligne += "<td> " + myData[i].demande + "</td>";
        ligne += "<td> " + myData[i].message + "</td>";
        myData[i].Date_livraison
            ? (ligne += "<td> " + myData[i].Date_livraison + "</td>")
            : (ligne += "<td> " + "en cours" + "</td>");
    }

    selector.html(ligne);
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
function showError(data) {
    for (property in data) {
        if (property == "id_categorie") {
            $(".demandecontainer").append(
                '<span class="text text-danger m-3 failfield">' +
                    data[property] +
                    "</span>"
            );
            $(".demandecontainer :input").addClass("is-invalid");
        }
    }
}
function hideError() {
    $("#add :input").each(function () {
        if ($(this).hasClass("is-invalid")) {
            $(this).removeClass("is-invalid");
        }
    });
}
