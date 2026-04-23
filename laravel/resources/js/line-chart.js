export default function lineChart(data, seriesOptions) {
    return {
        chart: null,
        data: data,

        init() {
            this.renderChart();
        },

        renderChart() {
            if (this.chart) return;
            const options = setLineOptionChart(data, seriesOptions);
            console.log(options);
            this.chart = new ApexCharts(this.$el, options);
            this.chart.render();

        },
    }
}

function setLineOptionChart(data, seriesOptions) {
    return {
        stroke: {
            width: 2,
        },
        chart: {
            type: 'line'
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
                    return val;
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