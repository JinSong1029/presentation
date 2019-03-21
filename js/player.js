(function ($, root, window) {

    root.initPlayerPage = function () {

        root.ajaxImageUploaderSettings.url = '/admin/player/uploadTemp';

        var url = "/admin/player";
        var url_store = root.getAppUrl() + "/admin/player";
        var url_update = root.getAppUrl() + "/admin/player/%7Bplayer%7D";
        var url_delete = root.getAppUrl() + "/admin/player/delete";

        var vent = _.extend({}, Backbone.Events);

        function equalHeight(group) {
            var tallest = 0;
            group.each(function() {
                var thisHeight = $(this).height();
                if(thisHeight > tallest) {
                    tallest = thisHeight;
                }
            });
            group.height(tallest);
        }


        var StoryList = Backbone.View.extend({
            template: _.template($('#story-list-template').html()),
            events: {
                "click .story": "fetchMedia",
                "click .media-add": "addFromStory"
            },
            init: function () {
                vent.on('storylist.refresh', this.render.bind(this));
                this.render();
            },
            render: function () {
                this.setElement(this.template({ stories: window.stories }));
                this.$el.find('.story').each(function (i, el) {
                    var mark = 0;
                    var current = _.filter(window.stories, function (val) {
                        return val.id == $(el).data('id');
                    })[0];
                    if(!current) {
                        return false;
                    }
                    $.each(current.parsed_medias, function (j, value) {
                        if (window.used_media.indexOf(value.id) !== -1) {
                            mark++;
                        }
                    });
                    if(mark > 0) {
                        $(el).addClass('all-used');
                    }
                });

                $('#media-form').html(this.el).slideDown(200);
                return this;
            },
            fetchMedia: function (e) {
                var id = $(e.currentTarget).data('id');
                var $container = $(e.currentTarget).next('.icc-player-story-medias');
                $container.html("");

                var res = _.filter(window.stories, function (val) {
                    return val.id == id;
                })[0];
                $.each(res.parsed_medias, function (i, media) {
                    var item = media.files[0] || false;
                    if (item) {
                        var used = (window.used_media.indexOf(media.id) !== -1) ? 'used' : '';
                        $container.append('<a href="#" class="media-add ' + used + '" data-id="' + media.id + '" data-story-id="' + id + '">' +
                        '<img src="' + window.assets + 'images/80x80/' + item.path + '"/> ' + item.name + ' (' + media.type + ')</a>')
                    }
                });
            },
            addFromStory: function (e) {
                var $this = $(e.currentTarget);
                if($this.hasClass('used')) {
                    return false;
                }
                $this.addClass('used');
                $sibl = $this.siblings('.media-add:not(.used)');
                if($sibl.length == 0) {
                    $this.parents('.icc-player-story-medias').siblings('.story').addClass('all-used');
                }

                var id = $this.data('id');
                var story_id = $this.data('story-id');
                root.send(url_store + '/addMediaToPlayer', {media_id: id, story_id: story_id}, function (result) {
                    var res = root.toJSON(result);
                    $.each(window.media, function (i, val) {
                        delete val.recently_added;
                    });
                    $.each(res, function (i, val) {
                        val.recently_added = 1;
                        window.media.unshift( val );
                    });
                    vent.trigger('refresh.table');
                });
                e.preventDefault();
            }
        });


        var MediaForm = Backbone.View.extend({
            template: _.template($('#media-form-template').html()),
            events: {
                "click .cancel": "cancel"
            },
            render: function () {
                if(!this.model.type) {
                    this.model.type = this.model.medias && this.model.medias[0].files[1] ? this.model.medias[0].files[1].mime_type : 'video';
                }
                this.setElement(this.template({ item: this.model }));
                return this;
            },
            cancel: function (e) {
                $('#media-form').slideUp(200, function () {
                    $('#media-form').html('');
                });
                e.preventDefault();
            }
        });


        var MediaManagerRow = Backbone.View.extend({
            template: _.template($('#media-block-template').html()),
            events: {
                "click .edit": "edit",
                "click .featured": "featured",
                "click .remove": "remove"
            },
            render: function () {
                window.used_media.push(this.model.medias[0].id);
                this.model.image = root.getMediaImage(this.model);
                this.setElement(this.template({ item: this.model }));
                return this;
            },
            edit: function () {
                $("html, body").animate({ scrollTop: 210 });
                var row = new MediaForm({model: this.model});
                $('#media-form').html(row.render().el);
                $('#media-form').find('.icc-player-form').attr('action', url_update)
                    .append('<input name="_method" type="hidden" value="PUT">');
                $('#media-form:hidden').slideDown(200);
                $('#media-form').find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
                initPlayerRedactor();
                return false;
            },
            featured: function () {
                $.each(window.media, function (i, val) {
                    if(val.featured) {
                        val.featured = 0;
                        root.send('/admin/player/makeFeatured', {id: val.id, featured: 0});
                    }
                });

                this.model.featured = this.model.featured ? 0 : 1;

                var data = {
                    id: this.model.id,
                    featured: this.model.featured
                };
                root.send('/admin/player/makeFeatured', data, function (result) {
                    vent.trigger('refresh.table');
                }.bind(this));
                return false;
            },
            remove: function (e) {
                window.media = _.without(window.media, this.model);
                root.send(url_delete, {id: this.model.id});
                vent.trigger('refresh.table');
                e.preventDefault();

                vent.trigger('storylist.refresh');
            }
        });


        var MediaManager = Backbone.View.extend({
            el: $('#player-media'),
            collection: window.media,
            tagName: 'tr',
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.table', this.render.bind(this));
            },
            render: function () {
                window.used_media = [];
                this.collection = window.media;
                this.$el.html('');
                $.each(this.collection, function (i, item) {
                    var row = new MediaManagerRow({model: item});
                    this.$el.append(row.render().el);
                }.bind(this));

                equalHeight($('.icc-player-block'));

                this.$el.find('.recently-added').find('.edit').trigger('click');
            },
            sort: function () {

            }
        });


        var media = new MediaManager();
        media.init();

        if(window.oldFields) {
            var row = new MediaForm({model: window.oldFields});
            $('#media-form').html(row.render().el).show();
            initPlayerRedactor();
        }


        var buttonBlock = {
            setActive: function (className) {
                this.reset();
                $('.icc-player-buttons').addClass('disabled').find('.btn.'+className).addClass('chosen');
            },
            reset: function () {
                $('.icc-player-buttons').removeClass('disabled').find('.btn').removeClass('chosen');
            }
        };

        $('.icc-add-from-story').on('click', function () {
            buttonBlock.setActive('icc-add-from-story');
            var row = new StoryList();
            row.init();
            return false;
        });

        $('.icc-add-video').on('click', function () {
            buttonBlock.setActive('icc-add-video');
            var row = new MediaForm({model: { type: "video" }});
            $('#media-form').html(row.render().el).slideDown(200);
            $('#media-form').find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
            initPlayerRedactor();
            return false;
        });

        $('.icc-add-podcast').on('click', function () {
            buttonBlock.setActive('icc-add-podcast');
            var row = new MediaForm({model: { type: "podcast" }});
            $('#media-form').html(row.render().el).slideDown(200);
            $('#media-form').find('.icc-uploader-ajax > input[type="file"]').fileupload(root.ajaxImageUploaderSettings);
            initPlayerRedactor();
            return false;
        });

        function initPlayerRedactor () {
            $('#player-redactor').redactor({
                source: false,
                buttonsHide: ['unorderedlist', 'formatting', 'deleted', 'orderedlist', 'indent', 'outdent', 'alignment', 'horizontalrule'],
                minHeight: 180,
                maxHeight: 180
            });
        }

        $(document).on('click', '.icc-player-access-info .change', function () {
            $('.icc-player-access-info').addClass('hide');
            $('.icc-player-access-select').removeClass('hide');
            return false;
        });

        $(document).ready(function(){
            if($('div').is('.alert-danger') && window.oldFields && window.oldFields.id){
                $('#media-form').find('.icc-player-form').attr('action', url_update)
                    .append('<input name="_method" type="hidden" value="PUT">');
            }
            $('#media-form').find('.icc-uploader-ajax > input[type="file"]')
                .fileupload(root.ajaxImageUploaderSettings);
        });

    };

})(jQuery, main, window);