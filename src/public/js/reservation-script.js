$(function () {
    function updateDate() {
        var selectedDate = $('#date-input').val();
        $('#date-row .reservation__item').text(selectedDate);
    }

    function updateTime() {
        var selectedTime = $('#time-input').val();
        $('#time-row .reservation__item').text(selectedTime);
    }

    function updateNumberOfPeople() {
        var selectedNumberOfPeople = $('#number-input').val();
        $('#number-row .reservation__item').text(selectedNumberOfPeople);
    }

    function showSelected() {
        updateDate();
        updateTime();
        updateNumberOfPeople();
    }

    $('#date-input').on('change', showSelected);
    $('#time-input').on('change', showSelected);
    $('#number-input').on('change', showSelected);
});
