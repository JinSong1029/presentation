(function ($, root, window) {

    /* Preview */
    $('.story-preview').click(function(){

        var story_id = $(this).data('story');
        var _token   = $('input[name="_token"]').val();
        var type_story = $(this).data('type');

        if ( $(this).data('editor') ) {
            // console.log('asdf');
            root.autosave();

            var story = $('#autosaved-message').data('story');

            var defaults = {
                _token: _token,
                id : story,
                type : type_story,
                autosave: 1
            };
        } else {
            var defaults = {
                _token: _token,
                id: story_id,
                type: type_story,
                autosave: 0
            };
        }

        $.ajax({
            type : 'GET',
            url: '/admin/stories/getPreview',
            data : defaults,
            dataType: 'json',
            success: function (data, textStatus){
                var dataToFrontend = root.toJSON(data);
                $.ajax({
                    type : 'POST',
                    dataType: 'jsonp',
                    url: 'http://flatearth.co.uk/preview-test.php?callback=?',
                    data : dataToFrontend,
                    success: function (data, textStatus) {
                        // console.log(data);
                        // console.log(textStatus);
                        var dataToPreview = root.toJSON(data);
                        var storyObjToPreview = {
                            _token: _token,
                            story_preview: dataToPreview
                        };
                        $.ajax({
                            type : 'POST',
                            url: '/admin/preview',
                            data : storyObjToPreview,
                            dataType: 'json',
                            success: function (data, textStatus) {
                                // console.log(data);
                                // console.log(textStatus);
                                // console.log('I\'m here');
                                 window.open('/admin/preview');
                            }
                        });
                    }
                });
            }
        });
    });

})(jQuery, main, window);
