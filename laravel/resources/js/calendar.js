import flatpickr from 'flatpickr';

export default function dateRange(ref, wire, enableDateRange) {
    return flatpickr(ref, {
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
                wire.set('start_date', startDate);
                wire.set('end_date', endDate);
                wire.setDateRange();
            }
        }
    })

}