document.addEventListener('DOMContentLoaded', function() {

    // The global window.Apex variable below can be used to set common options for all charts on the page
    Apex = {
        tooltip: {
            followCursor: false,
            theme: 'light',
            x: {
                show: false
            },
            marker: {
                show: false
            },
            y: {
                title: {
                    formatter: function() {
                        return ''
                    }
                }
            }
        }
    }

    ////////////////////////////////
    var options = {
        chart: {
            height: 380,
            type: "area",
            background: '#fff',
            toolbar: {
                show: false
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: [0, 1, 2],
                top: -10,
                left: 0,
                blur: 20,
                color: '#fbcab7',
                opacity: 0.35
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: ['#fff'],
            width: 1.5,
            dashArray: 0,
        },
        series: [{
            name: "Number of Records Processed",
            //data: [20, 130, 160, 65, 40, 45, 80, 70, 110, 105]
            data: [442, 7901, 1152, 3010, 5905, 9282, 4508, 3323]

        }],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 0.4,
                opacityFrom: 1,
                opacityTo: 0.5,
                stops: [30, 100, 100]
            },
            colors: ['#0096c7', '#00b4d8', '#9C27B0']
        },
        xaxis: {
            tooltip: {
                enabled: false
            },
            categories: ["Apr", "Aug", "Jul", "Jun", "Mar", "May", "Oct", "Sep"],
            labels: {
                show: true,
                align: 'center',
                minWidth: 0,
                maxWidth: 160,
                style: {
                    fontSize: '10px',
                    fontFamily: "Nunito Sans",
                    colors: ['#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae', '#8b9bae']
                },
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            },
        },
        yaxis: [{
            axisBorder: {
                show: true,
                color: '#EBEEF2',
                offsetX: 0
            },

            labels: {
                show: true,
                align: 'center',
                minWidth: 0,
                maxWidth: 160,
                style: {
                    fontSize: '10px',
                    fontFamily: "Nunito Sans",
                    color: '#8b9bae'
                },
            }
        }],
        grid: {
            show: true,
            borderColor: '#EBEEF2',
            strokeDashArray: 0,
            position: 'back',
            xaxis: {
                lines: {
                    show: true,
                }
            },
            yaxis: {
                lines: {
                    show: true,
                }
            },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 10
            },
        },
        legend: {
            show: true,
            showForSingleSeries: true,
            position: 'top',
            horizontalAlign: 'center',
            offsetX: 0,
            fontSize: '10px',
            fontFamily: 'Nunito Sans',
            markers: {
                width: 7,
                height: 7,
                strokeWidth: 0,
                strokeColor: '#fff',
                radius: 7,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            labels: {
                colors: ['#8b9bae'],
                useSeriesColors: false
            },
            itemMargin: {
                horizontal: 0,
                vertical: 0
            },
            onItemClick: {
                toggleDataSeries: false
            }
        },

        colors: ['#f45e25', '#808080', '#555555'],



        dataLabels: {
            enabled: false,
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                opacity: 0.45
            }
        }

    };

    var chart = new ApexCharts(document.getElementById("records-processed"), options);
    if (chart.el != null) {
        chart.render();
    }
});
