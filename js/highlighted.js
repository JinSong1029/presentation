(function ($, root, window) {

    root.initHighlightedPage = function () {

        var url = "/admin/highlighted";
        var urlUpdate = "/admin/highlighted/%7Bhighlighted%7D";

        var vent = _.extend({}, Backbone.Events);

        var HighlightedStory = Backbone.View.extend({
            template: _.template($('#highlighted-template').html()),
            events: {
                "click .list": "showList",
                "click .edit": "openEditForm",
                "submit .icc-highlighted-edit-form": "editHighlighted",
                "click .icc-highlighted-story-list > a": "selectStory"
            },
            render: function () {
                var item = this.model.stories_highlighted[ this.model.index ] || {};
                //item.image = root.getMediaImage(item);
                this.setElement(this.template({ model: this.model, item: item }));
                return this;
            },
            showList: function (e) {
                if(!this.$el.find('.story-list').is(':visible')) {
                    $('.story-list').slideUp(200);
                    this.$el.find('.story-list').slideDown(200);
                } else {
                    this.$el.find('.story-list').slideUp(200);
                }
                e.preventDefault();
            },
            selectStory: function (e) {
                var $list = this.$el.find('.story-list');
                var old_id = $list.data('old-id');
                $list.slideUp(200);

                var data = $(e.currentTarget).data();
                var story = this.model.stories_other[ data.index ];
                var send_data = {};

                if(old_id != 0) {
                    send_data['old_highlighted'] = old_id;
                }

                send_data['story_id'] = story.id;
                send_data['topic_id'] = this.model.id;
                send_data['position'] = data.position;
                send_data['type'] = story.template;

                root.send(url, send_data, function (result) {
                    window.topics= root.toJSON(result);
                    vent.trigger('refresh.highlighted');
                }.bind(this));
                e.preventDefault();
            },
            openEditForm: function (e) {
                if (!this.$el.find('.icc-highlighted-edit-form').is(':visible')) {
                    $('.icc-highlighted-edit-form').slideUp(200);
                    this.$el.find('.icc-highlighted-edit-form').slideDown(200);
                } else {
                    this.$el.find('.icc-highlighted-edit-form').slideUp(200);
                }
                e.preventDefault();
            },
            editHighlighted: function (e) {
                var $form = this.$el.find('.icc-highlighted-edit-form');
                var data = {
                    _method: "PUT",
                    default_id: $form.data('id'),
                    headline: $form.find('.update_headline').val(),
                    abstract: $form.find('.update_abstract').val(),
                    position: $form.data('position')
                };

                if($form.data('highlighted-id')) {
                    data.highlighted_id = $form.data('highlighted-id');
                }

                this.model.stories_highlighted[ $form.data('position')-1].short_headline = data.headline;
                this.model.stories_highlighted[ $form.data('position')-1].short_abstract = data.abstract;

                root.send(urlUpdate, data, function (result) {
                    vent.trigger('refresh.highlighted');
                }.bind(this));

                this.$el.find('.icc-highlighted-edit-form').slideUp(200);
                e.preventDefault();
            }
        });


        var HighlightedBlock = Backbone.View.extend({
            tagName: "div",
            className: "icc-highlighted-block col-sm-6",
            events: {
            },
            render: function () {
                this.$el.append('<h3>'+this.model.topicName+'</h3>');

                for(i=0; i<3; i++) {
                    this.model.index = i;
                    var row = new HighlightedStory({ model: this.model });
                    this.$el.append(row.render().el);
                }

                return this;
            }
        });

        var Highlighted = Backbone.View.extend({
            el: $('#highlighted'),
            collection: window.topics,
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.highlighted', this.render.bind(this));
            },
            render: function () {
                this.collection = window.topics;
                this.$el.html('');
                this.$el.append('<div class="row">');
                $.each(this.collection, function (i, item) {
                    if(i%2 == 0) {
                        this.$el.append('<div style="float:left;width: 100%; height: 1px;" class="clearfix"></div>');
                    }
                    var row = new HighlightedBlock({ model: item });
                    this.$el.append(row.render().el);
                }.bind(this));
                this.$el.append('</div>');
            }
        });

        var highlighted = new Highlighted();
        highlighted.init();


    };

})(jQuery, main, window);