var colorArray = [
    "#FF6633",
    "#FFB399",
    "#FF33FF",
    "#FFFF99",
    "#00B3E6",
    "#E6B333",
    "#3366E6",
    "#999966",
    "#99FF99",
    "#B34D4D",
    "#80B300",
    "#809900",
    "#E6B3B3",
    "#6680B3",
    "#66991A",
    "#FF99E6",
    "#CCFF1A",
    "#FF1A66",
    "#E6331A",
    "#33FFCC",
    "#66994D",
    "#B366CC",
    "#4D8000",
    "#B33300",
    "#CC80CC",
    "#66664D",
    "#991AFF",
    "#E666FF",
    "#4DB3FF",
    "#1AB399",
    "#E666B3",
    "#33991A",
    "#CC9999",
    "#B3B31A",
    "#00E680",
    "#4D8066",
    "#809980",
    "#E6FF80",
    "#1AFF33",
    "#999933",
    "#FF3380",
    "#CCCC00",
    "#66E64D",
    "#4D80CC",
    "#9900B3",
    "#E64D66",
    "#4DB380",
    "#FF4D4D",
    "#99E6E6",
    "#6666FF"
];
var token = $(document)
    .find("meta[name=csrf-token]")
    .attr("content");

$(document).ready(function() {
    // var ctx = document.getElementById("etudiantstats").getContext("2d");
    // var myChart = new Chart(ctx, {
    //     type: "bar",
    //     data: {
    //         labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    //         datasets: [
    //             {
    //                 label: "# of Votes",
    //                 data: [12, 19, 3, 5, 2, 3],
    //                 backgroundColor: [
    //                     "rgba(255, 99, 132, 0.2)",
    //                     "rgba(54, 162, 235, 0.2)",
    //                     "rgba(255, 206, 86, 0.2)",
    //                     "rgba(75, 192, 192, 0.2)",
    //                     "rgba(153, 102, 255, 0.2)",
    //                     "rgba(255, 159, 64, 0.2)"
    //                 ],
    //                 borderColor: [
    //                     "rgba(255, 99, 132, 1)",
    //                     "rgba(54, 162, 235, 1)",
    //                     "rgba(255, 206, 86, 1)",
    //                     "rgba(75, 192, 192, 1)",
    //                     "rgba(153, 102, 255, 1)",
    //                     "rgba(255, 159, 64, 1)"
    //                 ],
    //                 borderWidth: 1
    //             }
    //         ]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    $.ajax({
        url: gestionurl,
        type: "post",
        data: {
            _token: token,
            op: "afficher"
        },
        dataType: "json",
        success: function(data) {
            console.log(data);
            // var ctx = document.getElementById("etudiantstats").getContext("2d");
            barChart(document.getElementById("etudiantstats").getContext("2d"), data.etudiant);
            barChart(document.getElementById("modulestats").getContext("2d"), data.module);


        },
        error: function(error) {
            console.log(error);
        }
    });
});

function InsertValueInSelector(value) {
    selector.text(value);
}

function barChart(context, myData) {
    // var Mychart1 = document.getElementById("stats").getContext("2d");

    let chart = new Chart(context, {
        type: "bar",
        data: {
            labels: myData.labels,
            datasets: [
                {
                    data: myData.dataset,
                    backgroundColor: colorArray
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    position: "right",
                    labels: {
                        generateLabels: function(chart) {
                            return chart.data.labels.map(function(label, i) {
                                return {
                                    text: label,
                                    fillStyle: colorArray[i]
                                };
                            });
                        }
                    }
                },
                title: {
                    display: true,
                    text: myData.title
                }
            },

            scales: {
                y: {
                    title: {
                        display: true,
                        text: myData.ytitle
                    },
                    beginAtZero: true
                },
                x: {
                    title: {
                        display: true,
                        text: myData.xtitle
                    },
                    beginAtZero: true
                }
            }
        }
    });
}
