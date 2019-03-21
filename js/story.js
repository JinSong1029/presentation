(function ($, root, window) {

    root.initStoryPage = function () {

        root.ajaxImageUploaderSettings.url = '/admin/stories/uploadTemp';
        $('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);

        var portraitUploaderSettings = {
            url: '/admin/stories/uploadTemp',
            type: 'POST',
            dataType: 'json',
            formData: {"_token": $('input[name="_token"]').val()},
            beforeSend: function (e, data) {
                var input = data.fileInput[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#portrait-16-9').css('background-image', 'url(' + e.target.result + ')');
                        var img = new Image();
                        img.onload = root.checkImageLowres.bind($('#portrait-16-9').find('span').first(), img);
                        img.src = reader.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            },
            done: function (e, data) {
                data.fileInputClone.siblings(".image-id").val(data.result.id);
                data.fileInputClone.siblings(".image-path").val(data.result.path);
                $('#portrait-round').html("<img class='hide' src='"+window.assets+"images/temp/"+data.result.path+"' />");
                root.setImageCropper();
            }
        };

        $('#portrait-uploader').fileupload(portraitUploaderSettings);

        $('#story-form').on('submit', function (e) {

            if(!root.useAjaxStoryValidation) {
                return;
            }

            if($('.icc-uploader-ajax.loading').length > 0) {
                $("html, body").animate({ scrollTop: "0px" });
                $('#validation-errors').html('<div class="alert alert-danger">You have one or more images which are not fully uploaded.</div>');
                $('#story-submit-button').removeAttr('disabled');
                return false;
            }

            e.preventDefault();

            var formData = new FormData(this);
            $('#story-submit-button').attr('disabled', 'disabled');

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    window.location.href = "/admin/stories";
                },
                error: function(errors){
                    $("html, body").animate({ scrollTop: "0px" });
                    if(errors.responseText.length < 5000) {
                        var err = root.toJSON(errors.responseText);
                        var dump = "";
                        $.each(err, function (name, val) {
                            dump += '<div class="alert alert-danger">'+val.join(', ')+'</div>';
                        });
                        $('#validation-errors').html(dump);
                        $('#story-submit-button').removeAttr('disabled');
                    } else {
                        $('#validation-errors').html('<div class="alert alert-danger">500 Server error</div>');
                        $('#story-submit-button').removeAttr('disabled');
                    }
                }
            });

        });



        root.setImageCropper = function (path) {
            var $image = $('#portrait-round img');
            $image.on("load", function () {
                $image.removeClass('hide');
                $image.off("load");

                $image.guillotine({
                    width: 200,
                    height: 200,
                    eventOnChange: 'guillotinechange'
                }).guillotine('fit');

                var offset = {
                    x: $('.portrait-offset-x').val(),
                    y: $('.portrait-offset-y').val()
                };

                if(offset.x && offset.y) {
                    $('.icc-guillotine-wrapper').find('.guillotine-canvas').css({
                        left: '-'+( $('.portrait-offset-x').val())+'%',
                        top: '-'+( $('.portrait-offset-y').val())+'%'
                    });
                }

                $image.on('guillotinechange', function(ev, data, action){
                    data.offset_x = Math.round(100 / 200 * data.x);
                    data.offset_y = Math.round(100 / 200 * data.y);
                    $('.portrait-offset-x').val(data.offset_x);
                    $('.portrait-offset-y').val(data.offset_y);
                });

            }.bind(this));

            $image.attr('src', $image.data('src'));

        };

        if($('.icc-guillotine-wrapper').length > 0) {
            root.setImageCropper();
        }


        root.refreshStoryPlugins = function ($el) {
            var $enhanced = $el.find('#enhanced-redactor');
            if($enhanced.length > 0) {
                root.initRedactorWithMediaElements.call($enhanced);
            } else {
                clearInterval(root.redactorInterval);
            }

            $el.find('.redactor:visible').each(main.initRedactor);
            $el.find('.redactor-quote:visible').each(main.initRedactorQuote);

            //root.initTimestampInterval
            if($el.find('.redactor-timestamp:visible').length > 0) {
                $('.redactor-timestamp:visible').each(main.initRedactorTimestamp);
                root.initTimestampInterval();
            } else {
                clearInterval(root.redactorIntervalTimestamp);
            }

            $el.find('.icc-timepicker:visible').datetimepicker({
                format: 'h:mm a',
                stepping: 5
            });
            $el.find('#related-files-uploader').fileupload(relatedFilesUploaderSettings);

            $el.find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
            $el.find('#portrait-uploader').fileupload(portraitUploaderSettings);

            if($('.icc-guillotine-wrapper').length > 0) {
                root.setImageCropper();
            }
        };


        var relatedFilesUploaderSettings = {
            dataType: 'json',
            formData: {"_token": root.token},
            done: function (e, data) {
                var res = root.toJSON(data);
                var file = {
                    id: res.result.id,
                    name: res.result.files[0].path
                };
                relatedFilesAdd(file.id, file.name, file.name);
            }
        };

        $('#related-files-uploader').fileupload(relatedFilesUploaderSettings);

        // Story select
        $('#story-select').change(function () {
            clearInterval(root.redactorInterval);
            root.redactorInterval = null;

            var id = $(this).val();
            var $old_story = $('#story-types div').first();
            var $new_story_template = $('#' + id);
            var $new_story = $('<div/>').html($new_story_template.html()).appendTo('#story-types');

            $old_story.addClass('special animated bounceOutLeft');
            $new_story.addClass('active animated bounceInRight');

            root.refreshStoryPlugins($new_story);

            /*
            * Change Spotlight, Partner bulletin topic (disable, enable, autoselect, etc)
            * */
            var $chosen = $('.icc-topics-select');
            var $spotlight = $chosen.find('option:contains("Spotlight")');
            var $bulletin = $chosen.find('option:contains("Partner bulletin")');
            var values = $chosen.data('checked-values') ? $chosen.data('checked-values').split(',') : [];

            if(id == "normal") {
                $spotlight.attr("disabled", "disabled");
                if (values.indexOf($spotlight.val()) !== -1) {
                    values.splice(values.indexOf($spotlight.val()), 1)
                }
                if(["partners", "directors"].indexOf($('.icc-story-access-select select').val()) !== -1) {
                    $bulletin.removeAttr("disabled");
                }
            } else {
                $spotlight.removeAttr("disabled");
                if (values.indexOf($spotlight.val()) === -1) {
                    values.push($spotlight.val());
                }
                $bulletin.attr("disabled", "disabled");
                if (values.indexOf($bulletin.val()) !== -1) {
                    values.splice(values.indexOf($bulletin.val()), 1)
                }
            }
            $chosen.data('checked-values', values.join(','));
            $chosen.change();
            /*
             * end Change Spotlight topic
             * */

            setTimeout(function () {
                $old_story.remove();
                $new_story.removeClass('animated bounceInRight');
            }, 550);
        });


        $('.icc-timepicker:visible').datetimepicker({
            format: 'h:mm a',
            stepping: 5
        });

        $(document).on('click', '.highlighted-story-checkbox', function () {
            if (this.checked) {
                $('.highlighted-story-checkbox').attr('checked', 'checked');
                $('.highlighted-hidden').slideDown(200);
            } else {
                $('.highlighted-story-checkbox').removeAttr('checked');
                $('.highlighted-hidden').slideUp(200);
            }
        });



        $('.icc-uploader-ajax:visible').each(function (i, el) {
            var bg = $(el).css('background-image') != "none" ? $(el).css('background-image').replace('url(', "").replace(')', "") : false;
            if(bg) {
                var $child = $(el).find('input, span').first();
                var img = new Image();
                img.onload = root.checkImageLowres.bind($child, img);
                img.src = bg;
            }
        });




        /*
        *
        *  Related stories
        *
        * */

        $(document).on('click', '.related-submit', function (e) {
            var query = $('.related-input').val();
            var id = $('input[name="story_id"]').val();
            root.send('/admin/stories/relatedSearch', {search_word: query,story_id:id}, function (result) {
                var res = root.toJSON(result);
                var dump = "";

                var selected = $('#related-stories-hidden').val();
                selected = (selected != "") ? selected.split(',') : [];

                dump += res.length == 0 ? "No results" : "";

                $.each(res, function (i, val) {
                    if (!_.contains(selected, val.id + "")) {
                        dump += '<a href="#" data-id="' + val.id + '" data-template="' + val.template + '">' + val.headline + '</a>';
                    }
                });
                $('#related-stories-list').html(dump);
            });
            e.preventDefault();
        });

        $(document).on('click', '#related-stories-list a', function (e) {
            var $this = $(this);
            var id = $this.data('id');
            var template = $this.data('template');
            var headline = $this.text();

            var selected = $('#related-stories-hidden').val();
            selected = (selected != "") ? selected.split(',') : [];
            selected.push(id);
            $('#related-stories-hidden').val(selected.join(','));

            var dump = '<a href="/admin/stories/'+id+'/edit?type='+template+'" data-id="'+id+'" data-template="'+template+'" target="_blank"><i class="fa fa-times-circle"></i> '+headline+'</a>';
            dump += '<input type="hidden" name="_related[' + id + ']" value="' + headline + '" />';

            $('#related-stories-result').append(dump);
            $this.remove();
            e.preventDefault();
        });

        $(document).on('click', '#related-stories-result i', function (e) {
            var $this = $(this).closest('a');
            var id = $this.data('id');
            var headline = $this.text();
            var template = $this.data('template');
            var selected = $('#related-stories-hidden').val();
            selected = (selected != "") ? selected.split(',') : [];
            selected = _.filter(selected, function (val) {
                return val != id;
            });
            $('#related-stories-hidden').val(selected.join(','));

            if(!$this.hasClass('no-return')) {
                var dump = '<a href="#" data-id="'+id+'" data-template="'+template+'">'+headline+'</a>';
                $('#related-stories-list').append(dump);
            }

            $this.remove();
            e.preventDefault();
        });


        $(document).on('keydown', '.related-input', function(e) {
            if (e.keyCode == 13) {
                $('.related-submit').trigger('click');
                e.preventDefault();
            }
        });





        /*
         *
         *  Related files
         *
         * */

        $(document).on('click', '.related-files-submit', function (e) {
            var query = $('.related-files-input').val();
            root.send('/admin/stories/relatedFilesSearch', {search_word: query}, function (result) {
                var res = root.toJSON(result);
                var dump = "";

                var selected = $('#related-files-hidden').val();
                selected = (selected != "") ? selected.split(',') : [];

                dump += res.length == 0 ? "No results" : "";

                $.each(res, function (i, val) {
                    if (!_.contains(selected, val.id + "")) {
                        dump += '<a href="#" data-path="'+val.files[0].path+'" data-id="' + val.id + '">' + val.files[0].path + '</a>';
                    }
                });
                $('#related-files-list').html(dump);
            });
            e.preventDefault();
        });

        function relatedFilesAdd(id, name, path) {
            var selected = $('#related-files-hidden').val();
            selected = (selected != "") ? selected.split(',') : [];
            selected.push(id);
            $('#related-files-hidden').val(selected.join(','));

            var dump = '<a href="/files/'+path+'" data-id="'+id+'" data-path="'+path+'" target="_blank"><i class="fa fa-times-circle"></i> '+name+'</a>';
            dump += '<input type="hidden" name="_related[' + id + ']" value="' + name + '" />';
            $('#related-files-result').append(dump);
        }

        $(document).on('click', '#related-files-list a', function (e) {
            var $this = $(this);
            var id = $this.data('id');
            var path = $this.data('path');
            var headline = $this.text();
            relatedFilesAdd(id, headline, path);
            $this.remove();
            e.preventDefault();
        });

        $(document).on('click', '#related-files-result i', function (e) {
            var $this = $(this).closest('a');
            var id = $this.data('id');
            var path = $this.data('path');
            var headline = $this.text();
            var data = {
                file_id: id,
                story_id: $('input[name="story_id"]').val()
            };
            root.send('/admin/stories/fileDetach', data);

            var selected = $('#related-files-hidden').val();
            selected = (selected != "") ? selected.split(',') : [];
            selected = _.filter(selected, function (val) {
                return val != id;
            });
            $('#related-files-hidden').val(selected.join(','));

            if(!$this.hasClass('no-return')) {
                var dump = '<a href="#" data-id="'+id+'" data-path="'+path+'">'+headline+'</a>';
                $('#related-files-list').append(dump);
            }

            $this.remove();
            e.preventDefault();
        });


        $(document).on('keydown', '.related-files-input', function(e) {
            if (e.keyCode == 13) {
                $('.related-files-submit').trigger('click');
                e.preventDefault();
            }
        });



        /*
        *
        *  Story status
        *
        * */

        $('#story-status').on('change', function () {
            var $this = $(this);
            if($this.val() == 2) {
                $('#story-submit-button').val('Publish');
            } else {
                $('#story-submit-button').val('Save and close');
            }
        }).trigger('change');



        /*
        *
        *  Embargoed
        *
        * */
        function checkEmbargoed (e) {
            var $alert = $('.icc-embargoed-alert');
            var publish = $('.icc-publish-date').val();
            if(publish.length == 0) {
                $alert.slideUp(200);
                return false;
            }

            var publishDate = moment(publish, "DD/MM/YYYY hh:mm a");
            var now = moment();

            if(publishDate - now > 0) {
                $alert.find('.embargoed-date').text( moment(publishDate).format("Do MMM") );
                $alert.slideDown(200);
            } else {
                $alert.slideUp(200);
            }

            if(e) {
                if( $(e.currentTarget).find('input').is('.icc-publish-date') ) {
                    $('.icc-end-date').parents('.input-group.date').data("DateTimePicker").minDate(e.date);
                } else {
                    $('.icc-publish-date').parents('.input-group.date').data("DateTimePicker").maxDate(e.date);
                }
            }

        }
        checkEmbargoed();
        $('.icc-publish-date').on('change', checkEmbargoed);
        $('.icc-story-dates').on('dp.change', checkEmbargoed);


        /*
         *
         *  Story Access
         *
         * */

         $('.icc-story-access-info .change').on('click', function () {
            $('.icc-story-access-info').addClass('hide');
            $('.icc-story-access-select').removeClass('hide');
            return false;
        });

        $('.icc-story-access-select select').on('change', function (e, data) {
            $('.icc-story-access-info').removeClass('hide').find('strong')
                .text( $(this).find("option[value='"+$(this).val()+"']").text() );
            $('.icc-story-access-select').addClass('hide');

            var access = $(this).val();
            var $chosen = $('.icc-topics-select');
            var $bulletin = $chosen.find('option:contains("Partner bulletin")');
            var $story = $('#story-select');

            if(access == "directors") {

                if($story.val() != "normal") {
                    $story.val("normal").change();
                }
                $story.attr('disabled', 'disabled');
                $bulletin.removeAttr("disabled", "disabled");

                if(typeof data == "undefined") {
/*
                    //$chosen.attr('disabled', 'disabled');
                    var checked = $chosen.data('checked-values') ? $chosen.data('checked-values').split(',') : [];
                    //$bulletin.val()
                    if(checked.indexOf($bulletin.val()) === -1) {
                        checked.push($bulletin.val());
                        $chosen.data('checked-values', checked.join(','));
                        $chosen.change();
                    }
*/
                }

            } else if(access == "firmwide") {

                $story.removeAttr('disabled', 'disabled');
                var values = $chosen.data('checked-values') ? $chosen.data('checked-values').split(',') : [];
                //$bulletin.attr("disabled", "disabled");
                if (values.indexOf($bulletin.val()) !== -1) {
                    values.splice(values.indexOf($bulletin.val()), 1)
                }
                $chosen.removeAttr('disabled', 'disabled');
                $chosen.data('checked-values', values.join(','));
                $chosen.change();

            } else {

            }

        }).trigger('change');


        /*
        *
        *  Timelines
        *
        * */

        // New timeline entry in Day in the Life template
        var newEntryBlock = function () {
            var $entries = $('.icc-stories-entry');
            var counter = $entries.data('counter');
            var content = $('#day-in-the-life-timestamp-template').html();
            var $new_entry = $('<div style="display: none" class="timeline-block"/>').html(content).appendTo('.icc-stories-entry');

            $new_entry.find('select, input, textarea').each(function (i, el) {
                var new_name = $(el).attr('name').replace(/_DayInTheLife\[[0-9]\]/g, "_DayInTheLife["+counter+"]");
                $(el).attr('name', new_name);
            });

            $new_entry.find('.icc-timepicker').datetimepicker({
                format: 'h:mm a',
                stepping: 5
            });

            $new_entry.slideDown(200);

            $new_entry.find('.redactor-timestamp:visible').each(main.initRedactorTimestamp);
            $entries.data('counter', counter+1);
            return false;
        };


        $(document).on('click', '.icc-add-entry-button', newEntryBlock);
        $(document).on('click', '.icc-remove-timeline-entry-button', function () {

            var $entries = $('.icc-stories-entry');
            var counter = $entries.data('counter');
            $entries.data('counter', counter-1);

            var $block = $(this).parents('.timeline-block');
            var id = $block.find('.timeline_id').val();
            id && root.send('/admin/stories/deleteTimeline', { timeline_id: id });

            $block.slideUp(200, function() {
                $block.remove();

                $entries.find('.timeline-block').each(function (j, block) {
                    $(block).find('select, input, textarea').each(function (i, el) {
                        var new_name = $(el).attr('name').replace(/\[[0-9]\]/g, "["+j+"]");
                        $(el).attr('name', new_name);
                    });
                });

            });
            return false;
        });




        /*
        *
        *  Quotes
        *
        * */


        // New quote entry in QuoteUnquote template
        var newQuoteBlock = function () {
            var $entries = $('.icc-stories-quotes');
            var counter = $entries.data('counter');
            var content = $('#quote-unquote-template').html();
            var $new_entry = $('<div style="display: none"/>').html(content).appendTo('.icc-stories-quotes');

            $new_entry.find('.redactor-quote').each(main.initRedactorQuote);

            $new_entry.find('select, input, textarea').each(function (i, el) {
                var new_name = $(el).attr('name').replace(/\[[0-9]\]/g, "["+counter+"]");
                $(el).attr('name', new_name);
            });

            $new_entry.slideDown(200);
            $entries.data('counter', counter+1);
            return false;
        };


        $(document).on('click', '.icc-add-quote', newQuoteBlock);
        $(document).on('click', '.icc-remove-quote-button', function () {

            var $entries = $('.icc-stories-quotes');
            var counter = $entries.data('counter');
            $entries.data('counter', counter-1);

            var $block = $(this).parents('.row');
            var id = $block.find('.quote-id').val();
            id && root.send('/admin/stories/deleteQuote', { quote_id: id });
            $block.parent('div').slideUp(200, function() {
                $(this).remove();

                $entries.find('.quote-block').each(function (j, block) {
                    $(block).find('select, input, textarea').each(function (i, el) {
                        var new_name = $(el).attr('name').replace(/\[[0-9]\]/g, "["+j+"]");
                        $(el).attr('name', new_name);
                    });
                });

            });
            return false;
        });
    };

})(jQuery, main, window);
