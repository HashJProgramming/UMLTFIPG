var ctx = document.getElementById("chart-data").getContext("2d");
var chart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [], // Empty initially
        datasets: [
            {
                label: "Population",
                data: [], // Empty initially
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                fill: true,
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
                labels: {
                    fontStyle: "normal",
                },
            },
            title: {
                fontStyle: "normal",
            },
        },
        scales: {
            x: {
                grid: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    drawTicks: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2],
                    drawOnChartArea: false,
                },
                ticks: {
                    color: "#858796",
                    font: {
                        style: "normal",
                    },
                    padding: 20,
                },
            },
            y: {
                grid: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    drawTicks: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2],
                },
                ticks: {
                    color: "#858796",
                    font: {
                        style: "normal",
                    },
                    padding: 20,
                },
            },
        },
        animation: {
            duration: 5000, // Set the duration for the animation in milliseconds
        },
    },
});