(function ($, root, window) {

    root.initMediaLibraryPage = function () {

        root.ajaxImageUploaderSettings.url = '/admin/stories/uploadTemp';

        //root.ajaxImageUploaderSettings.url = '/admin/player/uploadTemp';
        $('.icc-uploader > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);


        $('#file-select').fileupload({
            type: 'POST',
            dataType: 'json',
            formData: {"_token": $('input[name="_token"]').val()},
            beforeSend: function (e, data) {
                $('#selected-filename').text('File is downloading...');
            },
            done: function (e, data) {
                $('#selected-filename').text( data.fileInput[0].files[0].name );
                data.fileInputClone.siblings(".image-id").val(data.result.id);
                $('#file-upload-button').removeClass('disabled');
            },
            error: function(e, status){
                $('#selected-filename').text('ERROR : File did not downloaded');
                $('#file-upload-button').addClass('disabled');
            }
        });

        
        if($('#tags-table').length > 0) {
            main.initTopicsAndCategories();
        }


        $('#topics-filter').on('change', function (e) {
            var id = $(this).val();
            window.location.href = id != 0 ? "?Topics=" + id : "?";
        });

        $('#los-filter').on('change', function (e) {
            var id = $(this).val();
            window.location.href = id != 0 ? "?Loses=" + id : "?";
        });

        $('#category-filter').on('change', function (e) {
            var id = $(this).val();
            window.location.href = id != 0 ? "?Categories=" + id : "?";
        });



        $('#carousel-add-slide').on('click', function (e) {
            var $parent = $('#carousel-slides');
            var count = $parent.data('count');
            var $template = $('#carousel-slide').clone();

            $template.find('input, select, textarea').each(function (i, el) {
                var new_name = $(el).attr('name').replace('[]', '['+count+']');
                $(el).attr('name', new_name);
            }).html();

            $('<div class="icc-media-carousel-slide" style="display: none;"/>')
                .html($template.html())
                .appendTo($parent)
                .slideDown('fast');

            $parent.data('count', count+1);
            $parent.find('.icc-uploader > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
            e.preventDefault();
        });

        $(document).on('click', '.carousel-slide-remove', function (e) {
            var id = $(e.currentTarget).data('id');
            var $parent = $('#carousel-slides');
            var count = $parent.data('count');
            $parent.data('count', count-1);

            var $block = $(this).parents('.icc-media-carousel-slide');
            $block.slideUp(200, function () {
                $block.remove();
            }.bind(this));

            root.send('/admin/media/imageCarousels/removeImage', {image_id: id});

            $('.icc-media-carousel-slide').each(function (i, el) {
                var index = $(el).index() - 1;
                $(el).find('select, input, textarea').each(function (i, el) {
                    var new_name = $(el).attr('name').replace(/\[[0-9]\]/g, "[" + index + "]");
                    console.log(index, $(el).attr('name'), new_name);
                    $(el).attr('name', new_name);
                });
            });
            e.preventDefault();
        });


        $(document).on('click', '.icc-media-image-row-controls .remove', function (e) {
            e.preventDefault();
            $('.icc-media-library-confirm.active').removeClass('active');
            $(this).siblings('.icc-media-library-confirm').addClass('active');
        });

        $(document).on('click', '.icc-media-library-confirm .cancel', function (e) {
            e.preventDefault();
            $(this).parents('.icc-media-library-confirm').removeClass('active');
        });

        $(document).on('click', '.icc-media-library-remove-item', function (e) {
            e.preventDefault();
            var data = $(this).data();
            root.send("/admin/media/remove", { media_id: data.id });
            $(this).parents('.icc-media-image-row').slideUp(300);
        });
    };

})(jQuery, main, window);