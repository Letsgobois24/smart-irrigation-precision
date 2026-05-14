import './bootstrap';

import clock from './clock';
window.clock = clock;

import lineChart from './line-chart';
window.lineChart = lineChart;

import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

function dateRange(wire, enableDateRange) {
    return {
        mode: 'range',
        dateFormat: 'Y-m-d',
        minDate: enableDateRange.from,
        maxDate: enableDateRange.to,
        onClose(selectedDates) {
            if (selectedDates.length === 2) {
                const startDate = flatpickr.formatDate(
                    selectedDates[0],
                    'Y-m-d'
                );
                const endDate = flatpickr.formatDate(
                    selectedDates[1],
                    'Y-m-d'
                );
                wire.set('startDate', startDate);
                wire.set('endDate', endDate);
            }
        }
    }
}

window.dateRange = dateRange;