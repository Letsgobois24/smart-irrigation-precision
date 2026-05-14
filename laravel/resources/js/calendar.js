import flatpickr from 'flatpickr';

export default function dateRange(ref, wire, enableDateRange) {
    flatpickr(ref, {
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
                wire.applyDateRange();
            }
        }
    })
}