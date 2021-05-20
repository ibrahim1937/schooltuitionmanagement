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
            console.log(data);
            remplir($("#content-demande"), data);
            $(".display").DataTable();
        },
        error: function (error) {
            console.log(error);
        },
    });
});
function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne +=
            '<tr><th scope="row"><input type="checkbox" name="demande" value=""> &nbsp ' +
            myData[i].id +
            "</th>";
        ligne += "<td> " + myData[i].nom + "</td>";
        ligne += "<td> " + myData[i].prenom + "</td>";
        ligne += "<td> " + myData[i].module + "</td>";
        ligne += "<td> " + myData[i].element + "</td>";
        myData[i].commentaire
            ? (ligne += "<td> " + myData[i].commentaire + "</td>")
            : (ligne += "<td> " + "No commentaire" + "</td>");
        ligne += "<td> " + myData[i].updated_at + "</td>";
        ligne += "<td> " + "accepter" + "</td></tr>";
    }

    selector.html(ligne);
}
