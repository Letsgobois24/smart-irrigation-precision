export default function lineChart(data, seriesOptions, ylabel = '') {
    return {
        chart: null,
        data: data,

        init() {
            this.renderChart();
        },

        renderChart() {
            if (this.chart) return;
            const options = setLineOptionChart(this.data, seriesOptions, ylabel);
            this.chart = new ApexCharts(this.$el, options);
            this.chart.render();

        },
    }
}

function setLineOptionChart(data, seriesOptions, ylabel) {
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
        series: getSeriesOptions(data, seriesOptions),
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
            x: {
                format: 'dd MMM HH:mm'
            }
        }

    }
}

function getSeriesOptions(data, seriesOptions) {
    return seriesOptions.map((option) => {
        return {
            name: option,
            data: data,
            parsing: {
                y: option,
            }
        }
    })
}