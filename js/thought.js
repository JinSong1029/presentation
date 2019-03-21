(function ($, root, window) {

    root.initThoughtsPage = function () {


        window.calendarFirstLoad = 0;
        // global function for collaboration with calendar
        window.calendarFilledDate = function (e) {
            var date = $('#thoughts-calendar').data("DateTimePicker");
            if(date) {
                var formatted_date = moment( date.date() ).format("YYYY-MM-DD");
                console.log(formatted_date);
                window.location.href = "/admin/thoughts/editByDate?date=" + formatted_date;
            }
        };

        // global function for collaboration with calendar
        window.calendarEmptyDate = function () {
            if(window.calendarFirstLoad) {
                var value = $('#calendar_value').val();
                $('.icc-publish-date').val(value).change();
            } else {
                window.calendarFirstLoad = 1;
            }
        };

        $('#thoughts-calendar').datetimepicker({
            inline: true,
            format: 'DD/MM/YYYY',
            daysOfWeekDisabled: [0, 6],
            disabledDates: window.dates,
            date: window.current ? window.current.publish_date : ""
        });

        $('.icc-thought-block-date').each(function (i, el) {
            var date = $(el).text();
            date = new Date(date);
            var newdate = moment(date).format('dddd MMMM Do YYYY');
            if($(el).parents('.icc-thougth-today').length > 0) {
                newdate = "Today";
            }
            $(el).text(newdate); //Uncomment to js managment of thought date format
        });



        $('#thoughts-quote').redactor({
            source: false,
            buttonsHide: ['bold', 'unorderedlist', 'italic', 'formatting', 'deleted', 'orderedlist', 'indent', 'outdent', 'alignment', 'horizontalrule'],
            minHeight: 180,
            maxHeight: 180
        });




        $('#remove-entry-link').on('click', function () {
            $('#remove-entry-form').submit();
            return false;
        });

        $('#thoughts-main-form').on('submit', function (e) {
            var $input = $(this).find('.icc-publish-date');
            var date = moment($input.val(), "DD/MM/YYYY").format("YYYY-MM-DD");
            $(this).find('.publish_date_formatted').val(date);
        });


        $(document).on('click', '.icc-thoughts-calendar', function () {

        });

        $(document).on('click', '.icc-thought-block-delete a', function (e) {
            $(this).parents('.icc-thought-block').find('.icc-thoughts-delete-confirm').addClass('active');
            e.preventDefault();
        });

        $(document).on('click', '.icc-thoughts-delete-confirm .btn-link', function (e) {
            $(this).parents('.icc-thoughts-delete-confirm').removeClass('active');
            e.preventDefault();
        });

        $('#remove-entry-confirm').on('click', function (e) {
            e.preventDefault();
            $('#edit-form-delete').fadeIn(200);
        });

        $('#edit-form-delete-cancel').on('click', function (e) {
            e.preventDefault();
            $('#edit-form-delete').fadeOut(200);
        });

    };

})(jQuery, main, window);