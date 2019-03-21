(function ($, root, window) {

    root.initRedactorWithMediaElements = function () {

        var variables = {
            source: false,
            buttons: ['html', 'bold', 'italic', 'unorderedlist', 'blockquote', 'image', 'link'],
            plugins: ['blockquote', 'media1', 'media2'],
            imageEditable: false,
            imageResizable: false,
            imagePosition: false,
            imageLink: false
        };
        var height = $(this).data('redactor-height');
        if (height) {
            variables.minHeight = height;
            variables.maxHeight = height;
        }
        $(this).redactor(variables);

        $('.re-media1').addClass('disabled');
        $('.re-media2').addClass('disabled');

        $(document).on('dragstart', '.iam_media1, .iam_media1', function (e) {
            e.preventDefault();
        });

        root.redactorInterval = setInterval(function () {
            var type = $('select[name="media_elements[0][type]"]').val();
            var image = $('input[name="media_elements[0][path]"]').val();
            var existed = $('input[name="media_elements[0][file_id]"]');
            if ((type == "" || image == "") && existed.length == 0) {
                $('.re-media1').addClass('disabled');
                $('.iam_media1').remove();
            } else {
                $('.re-media1').removeClass('disabled');
            }

            var type2 = $('select[name="media_elements[1][type]"]').val();
            var image2 = $('input[name="media_elements[1][path]"]').val();
            var existed2 = $('input[name="media_elements[1][file_id]"]');
            if ((type2 == "" || image2 == "") && existed2.length == 0) {
                $('.re-media2').addClass('disabled');
                $('.iam_media2').remove();
            } else {
                $('.re-media2').removeClass('disabled');
            }
        }, 500);

    };


    root.initTimestampInterval = function () {
        root.redactorIntervalTimestamp = setInterval(function () {
            $('.timeline-block').each(function (i, el) {
                var $el = $(el);

                var $button = $el.find('.re-icon.re-media_free');

                var type = $el.find('.form-control.icc-media-element_select').val();
                var image = $el.find('input[name$="[path]"]').val();
                var existed = $el.find('input[name$="[file_id]"]');

                if(type != "" && (existed.length>0 || image != "")) {
                    $button.removeClass('disabled');
                } else {
                    $button.addClass('disabled');
                    $(this).find('.iam_media1').remove();
                }

            });
        }, 500);
    }

})(jQuery, main, window);
