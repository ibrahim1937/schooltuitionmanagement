$(document).ready(function () {
    var ctx = document.getElementById("myAreaChart");
    $.ajax({
        url: chart3,
        type: "post",
        data: {
            _token: $(document).find("meta[name=csrf-token]").attr("content"),
            op: "afficher",
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            remplir($("#content-table"), data.table);
            // remplir($("#content-table2"), data.statutrectife);
            showGraph2(data.chart1.count, data.chart1.categorie);
            // showGraph3(data.rectifier.count, data.rectifier.etat);
            // showGraph4(data.date1.demande_count_data, data.date1.months);
            // showGraph5(data.date2.demande_count_data, data.date2.months);
        },
        error: function (error) {
            console.log(error);
        },
    });

    function showGraph2(x, y) {
        var myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: y,
                datasets: [
                    {
                        data: x,
                        backgroundColor: [
                            "#4e73df",
                            "#1cc88a",
                            "#36b9cc",
                            "#90EE90",
                        ],
                        hoverBackgroundColor: [
                            "#2e59d9",
                            "#17a673",
                            "#2c9faf",
                            "#90EE90",
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                    position: "right",
                },
                title: {
                    display: true,
                    text: "Nombre de demande pour chaque certificate",
                },
                cutoutPercentage: 80,
            },
        });
    }
});
function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne += "<tr><td> " + myData[i].nom + "</td>";
        ligne += "<td> " + myData[i].prenom + "</td>";
        ligne += "<td> " + myData[i].demande + "</td>";
        ligne += "<td> " + myData[i].created_at + "</td> </tr>";
    }

    selector.html(ligne);
}
