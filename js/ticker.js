(function ($, root, window) {

    root.initTickerPage = function () {

        var url = "/admin/ticker";
        var urlDelete = "/admin/ticker/delete";
        var urlAddStory = "/admin/ticker/addStory";

        var vent = _.extend({}, Backbone.Events);


        $('#ticker-external').on('submit', function (e) {

            var $this = $(this);
            var headline = $this.find('input.headline').val();
            var new_url = $this.find('input.url').val();

            if(headline.length < 3) {
                $(this).addClass('icc-headline-incorrect');
                $this.find('input.headline').focus();
                return false;
            }
            $(this).removeClass('icc-headline-incorrect');

            if(!root.checkUrl(new_url)) {
                $(this).addClass('icc-url-incorrect');
                $this.find('input.url').focus();
                return false;
            }
            $(this).removeClass('icc-url-incorrect');

            var data = {
                headline: $this.find('input.headline').val(),
                url: new_url,
                action: "ticker_add_external",
                story_id: "",
                publish_date: ""
            };

            $this.find('input.headline').val("");
            $this.find('input.url').val("");

            root.send(url, data, function (result) {
                window.ticker.push(result);
                vent.trigger('refresh.ticker');
            });


            e.preventDefault();
            return false;
        });


        var StoryListRow = Backbone.View.extend({
            tagName: 'tr',
            template: _.template($('#story-template').html()),
            events: {
                "click .add": "add"
            },
            render: function () {
                var status = _.filter(statuses, function(val){
                    return val.id == this.model.status_id;
                }.bind(this));
                this.model.status = status[0].name;
                this.$el.html(this.template({ item: this.model }));
                if(this.model.status == "Draft") {
                    this.$el.addClass("draft");
                }
                return this;
            },
            add: function (e) {
                var data = $.extend({}, this.model);
                data.action = "ticker_add_story";
                data.url = "";
                data.story_id = this.model.id;
                root.send(urlAddStory, data, function (result) {
                    window.ticker.push(result);
                    vent.trigger('refresh.ticker');
                });
                vent.trigger('remove.story', {id: this.model.id });
                e.preventDefault();
            }
        });

        var StoryList = Backbone.View.extend({
            el: "",
            collection: {},
            tagName: 'tr',
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.stories', this.render.bind(this));
                vent.on('remove.story', this.remove.bind(this));
            },
            render: function () {
                this.$el.html('');
                $.each(this.collection, function (i, item) {
                    var row = new StoryListRow({ model: item });
                    this.$el.append(row.render().el);
                }.bind(this));
            },
            remove: function (data) {
                this.collection = arr = _.without(this.collection, _.findWhere(this.collection, {id: data.id}));
                this.render();
            }
        });

        var stories = new StoryList({
            el: $('#pwc-stories'),
            collection: window.stories
        });
        stories.init();




        var TickerRow = Backbone.View.extend({
            tagName: 'tr',
            template: _.template($('#ticker-template').html()),
            templateEdit: _.template($('#ticker-edit-template').html()),
            events: {
                "click .edit": "edit",
                "click .remove": "remove",
                "submit .update-form": "update"
            },
            render: function () {
                if(this.model.story) {
                    var status = _.filter(statuses, function(val){
                        return val.id == this.model.story.status_id;
                    }.bind(this));
                    this.model.status = status[0].name;
                } else {
                    this.model.status = "";
                }
                this.$el.html(this.template({ item: this.model }));
                if(this.model.status == "Draft") {
                    this.$el.addClass("draft");
                }
                return this;
            },
            renderEdit: function () {
                this.$el.html(this.templateEdit({ item: this.model }));
                return this;
            },
            remove: function (e) {
                vent.trigger('removefrom.ticker', {id: this.model.id});
                e.preventDefault();
            },
            edit: function (e) {
                this.model.editMode = true;
                vent.trigger('refresh.ticker');
                e.preventDefault();
            },
            update: function (e) {
                delete this.model.editMode;
                this.model.headline = $(e.currentTarget).find('.headline').val();
                this.model.url = $(e.currentTarget).find('.url').val();

                var data = $.extend({
                    action: "edit",
                    story_id: "",
                    publish_date: ""
                }, this.model);

                root.send(url, data, function (result) {
                    vent.trigger('refresh.ticker');
                });

                e.preventDefault();
                return false;
            }
        });

        var Ticker = Backbone.View.extend({
            el: "",
            collection: {},
            tagName: 'tr',
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.ticker', this.render.bind(this));
                vent.on('removefrom.ticker', this.remove.bind(this));
            },
            render: function () {
                this.collection = window.ticker;
                this.$el.html('');
                $.each(this.collection, function (i, item) {
                    var row = new TickerRow({ model: item });
                    if(item.editMode) {
                        this.$el.append(row.renderEdit().el);
                    } else {
                        this.$el.append(row.render().el);
                    }
                }.bind(this));
            },
            remove: function (data) {
                window.ticker = this.collection = _.without(this.collection, _.findWhere(this.collection, {id: data.id}));
                data.action = "delete";
                root.send(urlDelete, data, function (result) {
                    stories.collection = root.toJSON(result);
                    vent.trigger('refresh.stories');
                });
                this.render();
            }
        });

        var ticker = new Ticker({
            el: $('#ticker'),
            collection: window.ticker
        });
        ticker.init();





    };

})(jQuery, main, window);