////////////////////////////////////////////// MAIN SCRIPT /////////////////////////////////////////////////
if ("undefined" != typeof window.jQuery) var main = {

    useAjaxStoryValidation: true,

    token: "",

    send: function (url, data, success, error) {
        //detect if application installed into subdir

        console.log('Sending to ' + url);
        console.log('Sended data:', data);

        var app_url = main.getAppUrl();
        data._token = main.token;
        $.post(app_url + url, data, success, error);
    },

    init: function () {

        main.token = $('meta[name="csrf-token"]').attr('content');

        $('.delete-row-action a, .status-hidden .status-td').click(function (e) {
            $(this).closest('tr').toggleClass('row-delete').next().fadeToggle('fast');
            $('.gradeX').removeClass('selected');
            return false;
        });

        $('.row-confirm .btn-cancel').click(function (e) {
            $(this).closest('tr').fadeToggle('fast').prev().toggleClass('row-delete');

            return false;
        });
        // highlight when you want to update name or default
        if ($('.update-row-form').length !== 0) {
            var
                form = $('.update-row-form'),
                expectedRowId = form.data('id'),
                row = $('[data-row-index=' + expectedRowId + ']');

            row.addClass('selected');
        }


        // Bootstrap datepicker
        /*
         $('.icc-story-dates').datetimepicker({
         format: "DD/MM/YYYY hh:mm a",
         useCurrent: "day",
         showTodayButton: true,
         sideBySide: true
         });
         */

        $('.js__fancybox').fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: 'auto',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });

        $(document).on('click', '.icc-date-reset-addon a', function (e) {
            $(this).parents('.input-group').data("DateTimePicker").minDate(false);
            $(this).parents('.input-group').find('input').val('').change();
            e.preventDefault();
        });


        $('.redactor:visible').each(main.initRedactorTest);
        $('.redactor-for-text').each(main.initRedactorTest);
        $('.redactor-for-long-description').each(main.initRedactorTest);


        var $enhanced = $('#enhanced-redactor');
        if ($enhanced.length > 0) {
            main.initRedactorWithMediaElements.call($enhanced);
        }


        // home thought pagination
        /*        $('.icc-home-thought-block .calender li').on('click', function() {
         $(this).addClass('active').siblings().removeClass('active');
         $(this).closest('.icc-home-thought-block').find('.thought-item:eq('+$(this).index()+')').addClass('active').siblings().removeClass('active');
         });

         $('.icc-announcements-publish-date').on('change', function () {
         var unpublish = $('.icc-announcements-unpublish-date');
         if(unpublish.val().length == 0) {
         var next_date = moment( $(this).val(), "DD/MM/YYYY" ).add(7, 'days').format("DD/MM/YYYY");
         unpublish.val(next_date);
         }
         });*/


        $('.morris-uploader').each(function () {
            var $el = $(this),
                newImageChecker = $el.parent().find('input[class=onchange]');

            var circle = new Sonic({
                width: 50,
                height: 50,
                padding: 50,

                strokeColor: '#000',

                pointDistance: .01,
                stepsPerFrame: 3,
                trailLength: .7,

                step: 'fader',

                setup: function () {
                    this._.lineWidth = 5;
                },

                path: [
                    ['arc', 25, 25, 25, 0, 360]
                ]

            });
            circle.play();

            var _this = this;
            $(this).find('input[type="file"]').on('change', function () {

                $el.append(circle.canvas);


                var type = $(this).attr('data-type');

                var name = type ? type : 'Logo';

                $(_this).find('input[name="detached' + name + 'Id"]').val('');

                if (this.files && this.files[0]) {

                    var reader = new FileReader();

                    $el.removeClass('editing');
                    newImageChecker.val(true);
                    reader.onload = function (e) {

                        $('.sonic').remove();

                        $el.css('background-image', 'url(' + e.target.result + ')');

                        if (!$el.hasClass('uploaded')) {

                            $el.addClass('uploaded');
                        }

                    };
                    reader.readAsDataURL(this.files[0]);

                    //checking edit logo page and add file name in input
                    var
                        $this = $(this),
                        inputParent = $this.parents().parents(),
                        logoImage = $this.parents().next().children('.morris-presentation-slide-logo-name');

                    if (inputParent.hasClass('morris-presentation-slide-logo')) {
                        logoImage.val(this.files[0].name);
                    }
                }
            });
        });

    },
    initRedactor: function () {
        var variables = {
            source: false,
            buttonsHide: ['formatting', 'deleted', 'unorderedlist', 'link', 'orderedlist', 'indent', 'outdent', 'alignment', 'horizontalrule'],
            plugins: ['blockquote']
        };
        var height = $(this).data('redactor-height');
        if (height) {
            variables.minHeight = height;
            variables.maxHeight = height;
        }
        $(this).redactor(variables);
    },

    initRedactorLarge: function () {
        var variables = {
            source: false,
            buttonsHide: ['deleted', 'orderedlist', 'indent', 'outdent', 'alignment', 'horizontalrule'],
            plugins: ['blockquote'],
            formatting: [],
            formattingAdd: {
                "heading": {
                    "tag": "h1",
                    title: 'Heading',
                },
                "subheading": {
                    "tag": "h2",
                    title: 'Subheading'
                },
                "medium": {
                    "tag": "h3",
                    title: 'Medium'
                },
                "small": {
                    "tag": "p",
                    title: 'Small'
                }
            }
        };
        var height = $(this).data('redactor-height');
        var enter = $(this).data('enter-key');
        if (enter == 'false') {
            variables.enterKey = false;
        }
        if (height) {
            variables.minHeight = height;
            variables.maxHeight = height;
        }
        $(this).redactor(variables);
    },

    initRedactorLong: function () {
        var variables = {
            source: false,
            buttonsHide: ['formatting', 'deleted', 'orderedlist', 'indent', 'outdent', 'alignment', 'horizontalrule'],
            plugins: ['blockquote']
        };
        var height = $(this).data('redactor-height');
        if (height) {
            variables.minHeight = height;
            variables.maxHeight = height;
        }
        $(this).redactor(variables);
    },
    initRedactorTest: function () {
        $.FroalaEditor.DefineIcon('paragraphFormat', {NAME: 'text-height'});
        $.FroalaEditor.DefineIcon('insertLink', {NAME: '<span class="new-r-link"></span>', template: 'text'});
        $.FroalaEditor.DefineIcon('paragraphStyle', {NAME: 'text-height'});

        var height = $(this).data('redactor-height');
        var enter = $(this).data('enter-key');
        var quoteEnabled = $(this).data('enable-quote');
        var minimal = $(this).data('minimal');

        var settings = {
            useClasses: true,
            paragraphMultipleStyles: false,
            tabSpaces: 4,
            toolbarBottom: false,
            theme: 'gray',
            zIndex: 2001,
            end_with_newline: false,
            indent_inner_html: false,
            brace_style: 'expand',
            paragraphStyles: {
                'wmo-rich-heading': '<h1>Heading</h1>',
                'wmo-rich-subheading': '<h2>Subheading</h2>',
                'wmo-rich-medium': '<h3>Medium</h3>',
                'wmo-rich-small': '<p>Small</p>',
            },
            placeholderText: '',
            paragraphFormat: {
                H1: 'Heading',
                H2: 'Subheading',
                h3: 'Medium',
                N: 'Small'
            },
            colorsDefaultTab: 'text',
            colorsBackground: [

            ],
            colorsText: [
                '#5e5e5e','#00464c', '#a3b9b5', '#4eb7af'
            ]
////            'fontSizeSelection':true,
        };
        if (height) {
            settings.height = height;
        }

        var buttons = ['paragraphStyle', 'bold', 'italic', 'formatUL', 'insertLink','color'];

        if (minimal) {
            buttons = ['bold', 'italic'];
        }

        if (enter === false) {
            settings.multiLine = false;
            settings.editorClass = 'oneline';
        }



        var remove_controls = $(this).data('remove-controls');

        if (typeof remove_controls !== 'undefined') {

            if (remove_controls == 'all')
                buttons = ['|'];
            else{
                $.each(remove_controls.split(','), function (i, val) {
                    var index = buttons.indexOf(val);
                    if (index > -1) {
                        buttons.splice(index, 1);
                    }
                });
            }
        }
        settings.toolbarButtons = buttons;


        $(this).froalaEditor(settings);
        var $this = $(this);
        $(this).on('froalaEditor.contentChanged', function (e, editor) {

            var text = $this.froalaEditor('html.get');
            //text = text.replace(/<[^\/>][^>]*><\/[^>]+>/gim, "");
            $this.html(text);

            //$this.froalaEditor('toolbar.disable');
            $this.parent().append('<input type="hidden" name="hasBeenEdited" value="1">');

        });

        $this.on('froalaEditor.commands.before', function (e, editor, cmd) {

            if (cmd == 'paragraphFormat') {

                $this.froalaEditor('commands.clearFormatting');
                var text = main.clearText($.selection('html'));
                main.replaceSelection(text, true);

            }

        });
    },
    clearText: function (text) {

        var oldList = text.match(/<ul>(.*?)<\/ul>/g);

        if (oldList) {
            var newList = main.strip_tags(oldList[0], '<ul><li><strong>');
            return text.replace(/<ul>(.*?)<\/ul>/g, newList);
        }
        return text;
    },

    replaceSelection: function (html, selectInserted) {
        var sel, range, fragment;

        if (typeof window.getSelection != "undefined") {
            // IE 9 and other non-IE browsers
            sel = window.getSelection();

            // Test that the Selection object contains at least one Range
            if (sel.getRangeAt && sel.rangeCount) {
                // Get the first Range (only Firefox supports more than one)
                range = window.getSelection().getRangeAt(0);
                range.deleteContents();

                // Create a DocumentFragment to insert and populate it with HTML
                // Need to test for the existence of range.createContextualFragment
                // because it's non-standard and IE 9 does not support it
                if (range.createContextualFragment) {
                    fragment = range.createContextualFragment(html);
                } else {
                    // In IE 9 we need to use innerHTML of a temporary element
                    var div = document.createElement("div"), child;
                    div.innerHTML = html;
                    fragment = document.createDocumentFragment();
                    while ((child = div.firstChild)) {
                        fragment.appendChild(child);
                    }
                }
                var firstInsertedNode = fragment.firstChild;
                var lastInsertedNode = fragment.lastChild;
                range.insertNode(fragment);
                if (selectInserted) {
                    if (firstInsertedNode) {
                        range.setStartBefore(firstInsertedNode);
                        range.setEndAfter(lastInsertedNode);
                    }
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        } else if (document.selection && document.selection.type != "Control") {
            // IE 8 and below
            range = document.selection.createRange();
            range.pasteHTML(html);
        }
    },

    strip_tags: function (input, allowed) {
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    },
    toJSON: function (data) {
        return (typeof data == "string") ? eval("(" + data + ")") : data;
    },
    checkUrl: function (url) {
        return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
    },
    log: function (b) {
        "undefined" != typeof console && main.settings.debug && console.log(b)
    },
    getMediaImage: function (story) {
        var assets = window.assets + "images/original/";
        return (story.medias && story.medias[0] && story.medias[0].files[0]) ? assets + story.medias[0].files[0].path : "";
    },
    getAppUrl: function () {
        var loc = window.location.pathname.split('/')[1];
        var app_url = '';
        if (loc.indexOf("admin")) {
            app_url = "/" + loc;
        }
        return app_url;
    },

    checkImageLowres: function (img) {
        var min_width = 651;
        var min_height = 366;

        if (img.width > min_width && img.height > min_height) {
            this.siblings('.icc-uploader-lowres-warning').remove();
        } else {
            this.after('<div class="icc-uploader-lowres-warning""><b>Warning! Low resolution</b>' +
                '<div class="hint">Recommended image size: <br/> more than ' + min_width + 'x' + min_height + ' pixels</div></div>');
        }
    },

    ajaxImageUploaderSettings: {
        //url: '/admin/stories/uploadTemp',
        type: 'POST',
        dataType: 'json',
        formData: {"_token": $('input[name="_token"]').val()},
        beforeSend: function (e, data) {

            var input = data.fileInput[0];
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    data.fileInputClone.siblings('span').text('Loading...');
                    data.fileInputClone.parent().addClass('uploaded loading').css('background-image', 'url(' + e.target.result + ')');
                    var img = new Image();
                    img.onload = main.checkImageLowres.bind(data.fileInputClone, img);
                    img.src = reader.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        },
        done: function (e, data) {
            data.fileInputClone.siblings(".image-id").val(data.result.id);
            data.fileInputClone.siblings(".image-path").val(data.result.path);
            data.fileInputClone.siblings('span').text("Click to change image");
            data.fileInputClone.parent().removeClass('loading');
        },
        error: function (data, e) {
            if (data.responseText.length < 200) {
                $('.uploaded.loading').removeClass('uploaded').find('span').addClass('error').text(data.responseText);
            } else {
                $('.uploaded.loading').removeClass('uploaded').find('span').addClass('error').text("Unsupportable image size or format");
            }
        }
    }
};

$(document).ready(main.init);

////////////////////////////////////////////// END OF MAIN SCRIPT /////////////////////////////////////////////////