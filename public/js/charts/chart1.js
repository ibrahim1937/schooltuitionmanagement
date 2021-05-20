
$(document).ready(function () {
    var ctx = document.getElementById("myPieChart");
    var ctx2 = document.getElementById("myPieChart2");
    // let chart1 = "{{ route('etudiant.chart1') }}";
    $.ajax({
        url: chart1,
        type: "post",
        data: {
            _token: $(document).find("meta[name=csrf-token]").attr("content"),
            op: "afficher",
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            remplir($("#content-table"), data.statutdemandes);
            remplir($("#content-table2"), data.statutrectife);
            showGraph2(data.demande.count, data.demande.etat);
            showGraph3(data.rectifier.count, data.rectifier.etat);
            showGraph4(data.date1.demande_count_data, data.date1.months);
            showGraph5(data.date2.demande_count_data, data.date2.months);
        },
        error: function (error) {
            console.log(error);
        },
    });

    function showGraph2(x,y){
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: y,
                datasets: [{
                data: x,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc',"#90EE90"],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf',"#90EE90"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
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
    function showGraph3(x){
        var myPieChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['encoure','accepter','refuser'],
                datasets: [{
                data: x,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc',"#90EE90"],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf',"#90EE90"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
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
    var ctx3 = document.getElementById("myAreaChart");
    function showGraph4(x,y){
        var myLineChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: y,
                datasets: [{
                label: "Earnings",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: x,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false,
                    drawBorder: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return '$' + number_format(value);
                    }
                    },
                    gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                display: false
                },
                title: {
                    display: true,
                    text: "chart"
                },
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                    }
                }
                }
            }
            });
    }
    var ctx4 = document.getElementById("myAreaChart2");
    function showGraph5(x,y){
        var myLineChart = new Chart(ctx4, {
            type: 'line',
            data: {
                labels: y,
                datasets: [{
                label: "Earnings",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: x,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false,
                    drawBorder: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return '$' + number_format(value);
                    }
                    },
                    gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                display: false
                },
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                    }
                }
                }
            }
            });
    }

});
function remplir(selector, myData) {
    var ligne = "";

    for (let i = 0; i < myData.length; i++) {
        ligne += "<tr><td> " + myData[i].cat + "</td>";
        ligne += "<td> " + myData[i].etat + "</td></tr>";

    }

    selector.html(ligne);
}
