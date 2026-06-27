export default function multiLineChart(data, ylabel = '') {
    return {
        chart: null,
        data: data,

        init() {
            this.renderChart();
        },

        renderChart() {
            if (this.chart) return;
            const options = setOption(this.data, ylabel);
            this.chart = new ApexCharts(this.$el, options);
            this.chart.render();
        },
    }
}

function setOption(data, ylabel) {
    return {
        stroke: {
            width: 2,
        },
        chart: {
            type: 'line',
            height: 320
        },
        parsing: {
            x: 'time'
        },
        series: data,
        xaxis: {
            type: 'datetime',
            labels: {
                datetimeUTC: false
            }
        },
        legend: {
            show: true,
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
                    return val + ylabel;
                }
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            x: {
                format: 'dd MMM HH:mm'
            }
        }

    }
}