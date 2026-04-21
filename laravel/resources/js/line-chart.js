export default function lineChart(data) {
    return {
        chart: null,
        data: data,

        init() {
            this.renderChart();
        },

        renderChart() {
            if (this.chart) return;
            const options = setLineOptionChart(data);

            this.chart = new ApexCharts(this.$el, options);
            this.chart.render();

        },
    }
}

function setLineOptionChart(seriesData, addLabel = '',) {
    return {
        stroke: {
            width: 2,
        },
        chart: {
            type: 'line'
        },
        series: seriesData,
        xaxis: {
            type: 'datetime'
        },
        legend: {
            show: false,
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                formatter: function(val) {
                    return val + addLabel;
                }
            }
        },
        tooltip: {
            x: {
                format: 'dd MMM HH:mm'
            }
        }

    }
}