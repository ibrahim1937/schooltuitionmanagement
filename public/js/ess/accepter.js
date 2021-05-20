$(document).ready(function () {
    $.ajax({
        url: accepter1,
        type: "post",
        data: {
            _token: $(document).find("meta[name=csrf-token]").attr("content"),
            op: "afficher",
        },
        dataType: "json",
        success: function (data) {
            //var obj = jQuery.parseJSON(data);
            // console.log(data);
            remplir($("#content-demande"), data);
            $(".display").DataTable();
        },
        error: function (error) {
            console.log(error);
        },
    });

    $(document).on("click", ".livree", function (e) {
        e.preventDefault();
        sessionStorage.setItem(
            "id_demande",
            parseInt($(this).parent().closest("tr").find("th").eq(0).text())
        );
        var id = $(this).closest("tr").find("th").text();
        console.log(id);
        $.ajax({
            url: accepter1,
            type: "post",
            data: {
                _token: $(document)
                    .find("meta[name=csrf-token]")
                    .attr("content"),
                op: "livree",
                id: sessionStorage.getItem("id_demande"),
            },

            dataType: "json",
            success: function (data) {
                // console.log("tt");
                // $(".display").DataTable().destroy();
                // remplir($("#content-demande"), data);

                // $(".display").DataTable();
                // console.log(data);
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
                remplir($("#content-demande"), data.data);
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
            '<tr><th scope="row"><input type="checkbox" name="demande" value=""> &nbsp ' +
            myData[i].id +
            "</th>";
        ligne += "<td> " + myData[i].demande + "</td>";
        ligne += "<td> " + myData[i].nom + "</td>";
        ligne += "<td> " + myData[i].prenom + "</td>";
        ligne += "<td> " + myData[i].Date_livraison + "</td>";
        ligne += "<td> " + myData[i].updated_at + "</td>";
        ligne += "<td> " + myData[i].etat + "</td>";
        ligne +=
            '<td class="text-center"><button type="button" class="btn btn-success livree">livree</button></td></tr>';
    }

    selector.html(ligne);
}
function hideMessage() {
    if ($(".fail")) {
        setTimeout(function () {
            $(".fail").hide();
        }, 3000);
    }
    if ($(".success")) {
        setTimeout(function () {
            $(".success").hide();
        }, 3000);
    }
    if ($(".dark")) {
        setTimeout(function () {
            $(".success").hide();
        }, 3000);
    }
}
