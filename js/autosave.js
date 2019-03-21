(function ($, root, window) {

    root.initAutosave = function () {

        var $autosave = $('#autosaved-message');
        var is_service = $autosave.hasClass('load-immediately');
        var story = $autosave.data('story');

        root.send('/admin/stories/restoreSaved', {story_id: story}, function (res) {
            if (res != "null" && root.toJSON(res)) {
                var result = root.toJSON(res);
                window.autoloaded = result.fields_data;

                if(checkAutosaveNotEmpty(result.fields_data) && !is_service) {
                    var message;
                    if (result.story_id == 0) {
                        message = 'There is an autosaved only story called "' + result.fields_data.headline + '" (' + moment(result.created_at).format('LLLL') + ')';
                    } else {
                        message = 'We have autosave for this story (' + moment(result.created_at).format('LLLL') + ')';
                    }
                    var html = '<div class="alert alert-warning">' + message +
                        ' &nbsp; <a href="#" class="btn btn-primary" data-dismiss="alert" id="load-autosaved">Restore it</a> <button type="button" class="btn btn-link" id="wipe-autosaved" style="color:#666" data-dismiss="alert">No, thanks</button></div>';
                    $('#autosaved-message').html(html);
                }

                if (is_service) {
                    loadAutosave();
                }
            }
            window.autosaveFormLength = $('#story-form').serialize().length;
        });


        $(document).on('click', '.icc-library-redirect', function () {
            var $this = $(this);
            var $select = $this.parents('.icc-media-elements').find('select.icc-media-element_select');

            var data = $this.data();

            if($select.val() == "") {
                $select.val('single-image');
            }
            var type = $select.val();

            var libType;
            if(type == "single-image") {
                libType = "images";
            } else
            if(type == "carousel") {
                libType = "imageCarousels";
            } else
            if(type == "video") {
                libType = "videos";
            } else
            if(type == "podcast") {
                libType = "podcasts";
            }

            var name = $select.attr('name').replace('[type]', '');

            root.autosave(function () {
                var params = {
                    selectMode: 1,
                    mediaName: data.name ? data.name : name
                };
                if(data.id > 0) {
                    params.storyId = data.id;
                    params.storyTemplate = data.template;
                }
                window.location.href = "/admin/media/"+libType+"?" + $.param(params);
            });
            return false;
        });


        root.autosave = function (callback) {
            var $form = $('#story-form');
            var formData = new FormData( $form[0] );
            $.ajax({
                type: "POST",
                url: "/admin/stories/autoSave",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    $('.icc-autosave-info').text('Autosaved: ' + moment().format('lll'));
                    if(typeof callback == "function") {
                        callback();
                    }
                }
            });
        };

        $(document).on('click', '#foo_autosave', function () {
            root.autosave();
            return false;
        });

        setInterval(function () {
            var $form = $('#story-form');
            if($('#headline:visible').length > 0 && $('#headline:visible').val().length < 1) {
                return false;
            }
            if(window.autosaveFormLength == $form.serialize().length) {
                return false;
            }
            window.autosaveFormLength = $form.serialize().length;
            root.autosave();
        }, 90000);


        $(document).on('click', '#load-autosaved', function (e) {
            loadAutosave();
            e.preventDefault();
        });


        $(document).on('click', '#wipe-autosaved', function (e) {
            var story = $('#autosaved-message').data('story');
            root.send('/admin/stories/wipeAutosave', {story_id:story});
            e.preventDefault();
        });


        function loadAutosave () {
            if($('#story-select').val() && $('#story-select').val() != window.autoloaded.template) {
                $('#story-select').val(window.autoloaded.template);
                var $new_story_template = $('<div/>').html($('#' + window.autoloaded.template).html());
                $('#story-types').html($new_story_template);
                root.refreshStoryPlugins( $('#story-types') );
            }

            $.each(window.autoloaded, function (name, value) {
                if(name != "_token" && value) {

                    var $el = $("[name='"+name+"']");

                    /*
                     *
                     *  Simple inline inputs
                     *
                     * */
                    var simple_inputs = [
                        'access',
                        'story_id',
                        'ticker',
                        'status',
                        'publish_date',
                        'end_date',
                        'name',
                        'headline',
                        'abstract',
                        'headline_highlighted',
                        'abstract_highlighted',
                        'name_DayInTheLife',
                        'job_title_DayInTheLife',
                        'soundbite_DayInTheLife'
                    ];

                    if(simple_inputs.indexOf(name) !== -1) {
                        if($el.val() != value) {
                            $el.val(value).trigger('change');
                        }
                    }

                    /*
                     *
                     *  Inputs arrays
                     *
                     * */

                    var array_inputs = [
                        'id_BigDebate',
                        'job_title_BigDebate',
                        'name_BigDebate',
                        'soundbite_BigDebate'
                    ];

                    if(array_inputs.indexOf(name) !== -1) {
                        $.each(value, function (i, val) {
                            var $el = $("[name='"+name+"["+i+"]']");
                            $el.val(val).trigger('change');
                        });
                    }

                    if(name == "opinion_BigDebate") {
                        $.each(value, function (i, val) {
                            var $el = $("[name='"+name+"["+i+"]']");
                            $el.redactor('insert.set', val);
                        });
                    }

                    /*
                     *
                     *  Simple redactors inputs
                     *
                     * */
                    var redactor_inputs = [
                        'content',
                        'minute_CatchUp',
                        'ten_minutes_CatchUp',
                        'three_minutes_CatchUp'
                    ];

                    if(redactor_inputs.indexOf(name) !== -1) {
                        $el.redactor('insert.set', value);
                    }

                    if(name == "access") {
                        $('.icc-story-access-info strong').text(value);
                    }

                    /*
                     *
                     *  Checkbox
                     *
                     * */

                    if(name == "highlighted") {
                        if(value == 1 || value == "on") {
                            $el.trigger('click');
                            $el.prop("checked", true);
                        }
                    }

                    /*
                     *
                     *  Chosen inputs
                     *
                     * */

                    if(["categories", "loses", "topics"].indexOf(name) !== -1) {
                        var $chosen = $('.icc-'+name+'-select');
                        $chosen.data('checked-values', value[0]);
                        $chosen.change();
                    }

                    /*
                     *
                     *  WAIDH timelines
                     *
                     * */
                    if(name == "summary_DayInTheLife") {
                        for (var i=0; i<value.length; i++) {

                            if(i>0) {
                                $('.icc-add-entry-button').trigger('click');
                            }

                            $("[name='timestamp_DayInTheLife["+i+"]']")
                                .val( window.autoloaded.timestamp_DayInTheLife[i] );
                            $("[name='text_DayInTheLife["+i+"]']")
                                .val( window.autoloaded.text_DayInTheLife[i] );
                            $("[name='summary_DayInTheLife["+i+"]']")
                                .val( window.autoloaded.summary_DayInTheLife[i] );
                            $("[name='content_DayInTheLife["+i+"]']")
                                .redactor('insert.set', window.autoloaded.content_DayInTheLife[i]);
                        }
                    }


                    /*
                     *
                     *  All media elements
                     *
                     * */
                    var media_names = ["media_main", "media_elements", "media_BigDebate", "media_DayInTheLife", "timelines_media_DayInTheLife"];

                    if(media_names.indexOf(name) !== -1) {
                        $.each(value, function (i, val) {

                            if(val.type == "carousel") {
                                $.each(val, function (_name, _value) {
                                    if(_value != "") {
                                        var $el = $("[name='"+ name + "[" + i + "]" + "["+ _name +"]" +"']");
                                        if($el.val() != _value) {
                                            $el.val(_value).trigger('change');
                                        }
                                        if(!$el.length) {
                                            $el = $('<input type="hidden" name="'+name+'['+i+']['+_name+']" />');
                                            $el.val(_value);
                                            $("#autosaved-message").after($el);
                                        }
                                    }
                                    if(_name == "image") {
                                        var $first = $("[name='"+ name + "[" + i + "]" + "[image][0][image]" +"']");
                                        var $addButton = $first.parents('.icc-media-element_content').find('.icc_carousel-add-button');
                                        for(var ii=1; ii<_value.length; ii++) {
                                            $addButton.trigger('click');
                                        }
                                        $.each(_value, function (j, _slide) {
                                            var $el = $("[name='"+ name + "[" + i + "]" + "[image]["+j+"][image]" +"']");
                                            var origin = (_slide.file_id || _slide.fromLibrary) ? "original" : "temp";
                                            $el.parents('.icc-uploader-ajax').addClass('uploaded').css('background-image', "url('"+window.assets + "images/"+origin+"/" + _slide._path +"')");
                                            $el.siblings('.image-path').val(_slide._path);

                                            $("[name='"+ name + "["+i+"]" + "["+ _name +"]["+j+"][image]"+"']").val( _slide.image );
                                            $("[name='"+ name + "["+i+"]" + "["+ _name +"]["+j+"][caption]"+"']").val( _slide.caption );
                                            $("[name='"+ name + "["+i+"]" + "["+ _name +"]["+j+"][_path]"+"']").val( _slide._path );
                                        });
                                    }
                                });
                            } else {
                                $.each(val, function (_name, _value) {
                                    if(_value != "") {

                                        var $el = $("[name='"+ name + "[" + i + "]" + "["+ _name +"]" +"']");

                                        if($el.val() != _value) {
                                            $el.val(_value).trigger('change');
                                        }

                                        if(!$el.length) {
                                            $el = $('<input type="hidden" name="'+name+'['+i+']['+_name+']" />');
                                            $el.val(_value);
                                            $("#autosaved-message").after($el);
                                        }

                                        if(_name == "_path") {
                                            var origin = (val.file_id || val.fromLibrary) ? "original" : "temp";
                                            $el.parents('.icc-uploader-ajax, .icc-uploader-ajax')
                                                .css('background-image', "url('"+window.assets + "images/"+origin+"/" + _value +"')")
                                                .addClass('uploaded');
                                        }

                                    }
                                });
                            }
                        });
                    }


                    /*
                     *
                     *  Quotes
                     *
                     * */
                    if(name == "quotes") {
                        for (var i=0; i<value.length; i++) {

                            if(i>0) {
                                $('.icc-add-quote').trigger('click');
                            }

                            $("[name='quotes["+i+"][id]']")
                                .val( window.autoloaded.quotes[i].id );
                            $("[name='quotes["+i+"][name]']")
                                .val( window.autoloaded.quotes[i].name );
                            $("[name='quotes["+i+"][quote]']")
                                .redactor('insert.set', window.autoloaded.quotes[i].quote);
                        }
                    }


                    /*
                     *
                     *   Hack for portrait format
                     *
                     * */
                    if(name == "media_DayInTheLife") {
                        var val = value[0];
                        var origin = val.image == "" ? "original" : "temp";
                        $('#portrait-16-9').css('background-image', "url('"+window.assets + "images/"+origin+"/" + val.path +"')");
                        $('#portrait-round').html("<img class='hide' src='"+window.assets + "images/"+origin+"/"+val.path+"' />");
                        root.setImageCropper();
                    }


                    /*
                     *
                     *   Related stories
                     *
                     * */
                    if(name == "related" && value[0] != "") {
                        var dump = "";
                        $('#related-stories-hidden').val(value);
                        $.each(value[0].split(','), function (i, val) {
                            var headline = window.autoloaded._related[val];
                            dump += '<a href="#" data-id="'+val+'"><i class="fa fa-times-circle"></i> '+ headline +'</a>';
                            dump += '<input type="hidden" name="_related[' + val + ']" value="' + headline + '" />';
                        });
                        $('.icc-related-stories-result').html(dump);
                    }


                    /*
                     *
                     *  Related files
                     *
                     * */

                    if(name == "relatedFiles" && value[0] != "") {
                        var dump = "";
                        $('#related-files-hidden').val(value);
                        $.each(value[0].split(','), function (i, val) {
                            var headline = window.autoloaded._related ? window.autoloaded._related[val] : "noname";
                            dump += '<a href="#" data-id="'+val+'"><i class="fa fa-times-circle"></i> '+ headline +'</a>';
                            dump += '<input type="hidden" name="_related[' + val + ']" value="' + headline + '" />';
                        });
                        $('.icc-related-files-result').html(dump);
                    }

                }
            });

            if(window.libraryMedia) {
                var $select = $("[name='"+ window.libraryName + "[type]" +"']");
                $select.val(window.libraryMedia.type).trigger('change');

                if(window.libraryMedia.type == "carousel") {
                    var $el = $("[name='"+ window.libraryName + "[image][0][image]" +"']");
                    var $addButton = $el.parents('.icc-media-element_content').find('.icc_carousel-add-button');
                    for(var i=1; i<window.libraryMedia.files.length; i++) {
                        $addButton.trigger('click');
                    }
                    $.each(window.libraryMedia.files, function (i, val) {
                        var $el = $("[name='"+ window.libraryName + "[image]["+i+"][image]" +"']");
                        $el.parents('.icc-uploader-ajax').addClass('uploaded').css('background-image', "url('"+window.assets + "images/original/" + val.path +"')");
                        $el.siblings('.image-path').val(val.path);
                        $("[name='"+ window.libraryName + "[image]["+i+"][caption]" +"']").val( val.name );
                    });
                } else {
                    var $el = $("[name='"+ window.libraryName + "[image]" +"']");
                    var mlf = window.libraryMedia.files;
                    var source, source_poster;
                    if(mlf[1]) {
                        source = mlf[0].mime_type == "video" || mlf[0].mime_type == "podcast" ? mlf[0] : mlf[1];
                        source_poster = mlf[0].mime_type == "video" || mlf[0].mime_type == "podcast" ? mlf[1] : mlf[0];
                    } else {
                        source = mlf[0];
                        source_poster = mlf[0];
                    }
                    var path = source.path;
                    var poster = source_poster.path;

                    $el.parents('.icc-uploader-ajax').addClass('uploaded').css('background-image', "url('"+window.assets + "images/original/" + poster +"')");
                    $el.siblings('.image-path').val(poster);
                    $("[name='"+ window.libraryName + "[caption]" +"']").val( source.name );
                    $("[name='"+ window.libraryName + "[path]" +"']").val( path );
                    $("[name='"+ window.libraryName + "[transcript]" +"']").val( source.description );
                }
            }

        }

        function checkAutosaveNotEmpty (autosave) {

            /* check: if we have headline - we load instantly */
            if(autosave.hasOwnProperty("headline") && autosave["headline"].length > 0) {
                return true;
            }

            /* if not - checks other fields */
            /* "points" - summ of all filled fields, so we can set threshold (at the end of function) */
            var points = 0;

            var simple_fields = [
                'headline',
                'headline_highlighted',
                'abstract',
                'abstract_highlighted',
                'content',
                'name_DayInTheLife',
                'job_title_DayInTheLife',
                'soundbite_DayInTheLife',
                'minute_CatchUp',
                'ten_minutes_CatchUp',
                'three_minutes_CatchUp'
            ];

            $.each(simple_fields, function (i, val) {
                if(autosave.hasOwnProperty(val) && autosave[val].length > 0) {
                    points++;
                }
            });

            var array_fields = [
                'job_title_BigDebate',
                'name_BigDebate',
                'soundbite_BigDebate',
                'opinion_BigDebate',
                'timestamp_DayInTheLife',
                'timelines_media_DayInTheLife',
                'text_DayInTheLife',
                'summary_DayInTheLife',
                'content_DayInTheLife'
            ];

            $.each(array_fields, function (i, val) {
                if (autosave.hasOwnProperty(val)) {
                    if(autosave[val][0] && autosave[val][0].length > 0) {
                        points++;
                    }
                    if(autosave[val][1] && autosave[val][1].length > 0) {
                        points++;
                    }
                }
            });

            if(autosave.hasOwnProperty('quotes')) {
                $.each(autosave['quotes'], function (i, val) {
                    if(val.name.length > 0 || val.quote.length > 0) {
                        points++;
                    }
                });
            }

            if(autosave.hasOwnProperty('media_main')) {
                if (autosave['media_main'][0]['image'].length > 0) {
                    points++;
                }
            }

            if(autosave.hasOwnProperty('media_main')) {
                if (autosave['media_main'][0]['image'].length > 0) {
                    points++;
                }
            }

            if(autosave.hasOwnProperty('media_elements')) {
                if (autosave['media_elements'][0] && typeof autosave['media_elements'][0]['image'] == "string" && autosave['media_elements'][0]['image'].length > 0) {
                    points++;
                }
                if (autosave['media_elements'][1] && typeof autosave['media_elements'][1]['image'] == "string" && autosave['media_elements'][1]['image'].length > 0) {
                    points++;
                }
            }

            if(autosave.hasOwnProperty('media_BigDebate')) {
                if (autosave['media_BigDebate'][0] && typeof autosave['media_BigDebate'][0]['image'] == "string" && autosave['media_BigDebate'][0]['image'].length > 0) {
                    points++;
                }
                if (autosave['media_BigDebate'][1] && typeof autosave['media_BigDebate'][1]['image'] == "string" && autosave['media_BigDebate'][1]['image'].length > 0) {
                    points++;
                }
            }

            /* threshold of filled fields. If no headline is filled - we can adjust occupancy on all fields */
            return points > 2;
        }

    };

})(jQuery, main, window);