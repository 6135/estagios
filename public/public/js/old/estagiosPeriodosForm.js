var estagiosPeriodosForm = function() {
    var datepickerFormat = function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    };

    return {
        init: function() {
            datepickerFormat();
        },
    };
}();


jQuery(document).ready(function() {
    estagiosPeriodosForm.init();
});