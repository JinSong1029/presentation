(function ($, root, window) {

    root.initFeaturedPage = function () {

        var url = "/admin/featured";
        var vent = _.extend({}, Backbone.Events);

        function prepareFeaturedArray(raw_featured) {

            var featured = {};

            window.emptyFeatured = {
                position: 0,
                story: {},
                access: "",
                type: ""
            };

            var count = {
                firmwide: 3,
                partners: 3,
                secondary: 4
            };

            function makePlaceholders (access) {
                var arr = [];
                for (i = 1; i <= count[access]; i++) {
                    var o = $.extend({}, emptyFeatured);
                    o.position = i;
                    o.access = access;
                    o.type = (access == "secondary") ? "secondary" : "normal";
                    arr.push(o);
                }
                return arr;
            }

            featured = {
                firmwide: makePlaceholders('firmwide'),
                partners: makePlaceholders('partners'),
                secondary: makePlaceholders('secondary')
            };

            $.each(raw_featured, function (i, val) {
                if ( val.type == "normal" ) {
                    featured[val.access][val.position-1] = val;
                } else if ( val.type == "secondary" ) {
                    featured["secondary"][val.position-1] = val;
                }
            });

            return featured;
        }

        window.featured = prepareFeaturedArray(window.raw_featured);


        function getImage (story, type) {
            type = type || "original";
            return window.assets + "images/"+type+"/" + findImage(story);
        }

        function findImage (story) {
            return story.eximage;
        }


        var StoryList = Backbone.View.extend({
            template: _.template($('#storylist-template').html()),
            collection: window.stories,
            events: {
                "click .select": "add",
                "click .use-firmwide": "useFirmwide"
            },
            renderByLosId: function (los, access, position) {
                var filtered = _.filter(this.collection, function (val) {
                    var loses = (val.loses && val.loses.length) ? $.map(val.loses, function (val) { return Number(val.id); }) : [];
                    return loses.indexOf( Number(los) ) !== -1;
                });
                this.setElement(this.template({ stories: filtered, access: access, position: position, type: "secondary", button: false }));
                return this;
            },
            render: function (access, position) {
                var show_button = access && access == "partners";
                if (show_button) {
                    var firmwide = window.featured.firmwide[position-1].id;
                    show_button = firmwide || false;
                }
                //var used = $.map(window.featured[access], function (val) {
                //   return val.story_id;
                //});
                //var stories = $.grep(this.collection, function (val) {
                //    return used.indexOf(val.id) === -1;
                //});
                this.setElement(this.template({ stories: this.collection, access: access, position: position, button: show_button }));
                return this;
            },
            add: function (e) {
                var id = $(e.currentTarget).data('id');
                vent.trigger('story.selected', {id: id});
                return false;
            },
            useFirmwide: function (e) {
                var position = $(e.currentTarget).data('position');
                var id = window.featured['firmwide'][position-1]["story_id"];
                vent.trigger('story.selected', {id: id});
            }
        });


        var EditStory = Backbone.View.extend({
            templatePrimary: _.template($('#edit-primary-template').html()),
            templateSecondary: _.template($('#edit-secondary-template').html()),
            events: {
                "click .save": "save"
            },
            render: function () {
                if(this.model.type == "normal") {
                    this.setElement(this.templatePrimary({ item: this.model, image: getImage(this.model.story) }));
                } else if (this.model.type == "secondary") {
                    this.setElement(this.templateSecondary({ item: this.model, image: getImage(this.model.story, "305x305") }));
                }
                return this;
            },
            save: function (e) {
                var data = {
                    id: this.model.id,
                    story_id: this.model.story_id,
                    image: findImage(this.model.story),
                    headline: this.$el.find('.update_headline').val(),
                    abstract: this.$el.find('.update_abstract').val()
                };

                if(this.model.type == "normal") {
                    var coord = this.$image.guillotine('getData');
                    data.offset_x = Math.round(100 / 200 * coord.x);
                    data.offset_y = Math.round(100 / 200 * coord.y);
                }

                vent.trigger('story.save', data);
                return false;
            },
            bindEvents: function (model) {
                var $image = $('.icc-featured-edit-imagewrapper img');
                $image.on( "load", function () {

                    $image.guillotine({
                        width: 200,
                        height: 200
                    }).guillotine('fit');
                    this.$image = $image;

                    this.$image.parents('.guillotine-canvas').css({
                        left: '-'+(this.model.offset_x)+'%',
                        top: '-'+(this.model.offset_y)+'%'
                    });

                }.bind(this));
            }
        });


        var FeaturedRow = Backbone.View.extend({
            templatePrimary: _.template($('#primary-template').html()),
            templateSecondary: _.template($('#secondary-template').html()),
            events: {
                "click .list": "listOpen",
                "click .edit": "editStory",
                "click .list>.featured-remove": "removeStory",
                "change .los-selector": "filterLos",
                "change .access-selector": "setSecondaryAccess"
            },
            render: function () {

                var data = {
                    item: this.model
                };

                if(this.model.reloadImage) {
                    data.image = getImage(this.model.story, "305x305") + this.model.reloadImage;
                } else {
                    data.image = getImage(this.model.story, "305x305");
                }

                if(this.model.type == "normal") {
                    this.setElement(this.templatePrimary(data));
                } else if(this.model.type == "secondary") {
                    var los = this.model.story.loses && this.model.story.loses[0].id || 0;
                    this.setElement(this.templateSecondary(data));
                    this.$el.find('.los-selector').val(los);
                }

                return this;
            },
            editStory: function (icon) {
                if(!this.model.id) return false;
                var $old_form = $('.icc-featured-editprimary, .icc-featured-editsecondary');
                $.each($old_form, function (i, el) {
                    this.editClose($(el).parent());
                }.bind(this));

                $(icon.currentTarget).addClass('active');
                var edit = new EditStory({ model: this.model });
                if(this.model.type=="secondary") {
                    var row = this.model.position < 3 ? "row1" : "row2";
                    this.$edit = $('#edit-'+ row + '-' + (this.model.type == "normal" ? this.model.access : this.model.type));
                } else {
                    this.$edit = $('#edit-'+ (this.model.type == "normal" ? this.model.access : this.model.type));
                }
                this.$edit.html(edit.render().el).slideDown(200);
                edit.bindEvents(this.model);

                vent.on('story.save', this.editSave.bind(this));
                return false;
            },
            editSave: function (data) {
                data.action = "update_story";
                root.send(url, data);

                delete data.story_id;
                delete data.id;

                data.headline_highlighted = data.headline;
                data.abstract_highlighted = data.abstract;

                $.extend(this.model.story, data);

                this.model.offset_x = data.offset_x;
                this.model.offset_y = data.offset_y;

                vent.trigger('refresh.featured', {story_id: this.model.story.id});
                this.editClose(this.$edit);
            },
            editClose: function ($el) {
                $el.find('.icc-featured-edit-imagewrapper img').guillotine('remove');
                vent.off('story.save');
                $('.edit.active').removeClass('active');
                $el.slideUp(200, function () {
                    $el.html('');
                }.bind(this));
            },
            filterLos: function (el) {
                var los = $(el.currentTarget).val();
                var list = new StoryList();
                var listName = '#list-'+(this.model.type == "normal" ? this.model.access : this.model.type)+'-'+this.model.position;
                this.$list = $(listName);
                this.$list.html(list.renderByLosId(los, this.model.access, this.model.position).el).slideDown(200);
                vent.off('story.selected');
                vent.on('story.selected', this.listClose.bind(this));
            },
            listOpen: function (icon) {
                if($('.icc-featured-storylist').length > 0) {
                    this.listClose({});
                }
                $(icon.currentTarget).addClass('active');

                var req = {};
                req.collection = this.model.access == "partners" && this.model.type == "normal" ? window.partnersStories : window.stories;

                var list = new StoryList(req);
                var listName = '#list-'+(this.model.type == "normal" ? this.model.access : this.model.type)+'-'+this.model.position;
                this.$list = $(listName);
                if($(icon.currentTarget).hasClass('icc-featured-secondary-toolbar')) {
                    var los = this.$el.find('.los-selector').val();
                    this.$list.html(list.renderByLosId(los, this.model.access, this.model.position).el).slideDown(200);
                } else {
                    this.$list.html(list.render(this.model.access, this.model.position).el).slideDown(200);
                }
                vent.on('story.selected', this.listClose.bind(this));
                return false;
            },
            listClose: function (data) {
                data.id && this.changeStory(data.id);
                vent.off('story.selected');
                $('.icc-featured-toolbar.active').removeClass('active');
                $('.icc-featured-storylist').parent().slideUp(200, function () {
                    $(this).html('');
                });
            },
            changeStory: function (id) {
                this.model.story_id = id;
                var data = $.extend({}, this.model);
                data.action = data.id ? "update_featured" : "make_featured";
                data.los_id = data.los_id || "";
                delete data.story;
                this.returnStoryToList();
                root.send(url, data, this.updateStory.bind(this));
            },
            updateStory: function (result) {
                if(result.current) {
                    this.model.id = result.featured_id;
                    this.model.story = result.current;
                } else {
                    this.model.story = result;
                }
                if(result.partners) {
                    var pos = result.partners.position - 1;
                    window.featured.partners[ pos ] = result.partners;
                    window.featured.partners[ pos ].story = result.current;
                }
                vent.trigger('refresh.featured');
            },
            returnStoryToList: function () {
                var id = this.model.story.id;
                var allStories = $.grep(window.stories, function (val) {
                    return val.id == id;
                });
                if(!allStories.length) {
                    window.stories.unshift(this.model.story);
                }
                var allSartnersStories = $.grep(window.partnersStories, function (val) {
                    return val.id == id;
                });
                if(!allSartnersStories.length) {
                    window.partnersStories.unshift(this.model.story);
                }
            },
            removeStory: function () {
                var empty = emptyFeatured;
                empty.position = this.model.position;
                empty.access = this.model.access;
                empty.type = this.model.type;
                empty.action = "remove_featured";

                window.featured[ this.model.access ][ this.model.position-1 ] = emptyFeatured;

                root.send(url, $.extend({id: this.model.id}, empty), function (result) {
                });

                this.returnStoryToList();

                vent.trigger('refresh.featured');
                return false;
            },
            setSecondaryAccess: function (e) {

                if(this.model.id) {
                    var newAccess = $(e.currentTarget).val();
                    var data = {
                        id: this.model.id,
                        access: newAccess,
                        image: this.model.story.eximage,
                        story_id: this.model.story_id,
                        headline: this.model.story.headline_highlighted ? this.model.story.headline_highlighted : this.model.story.headline,
                        abstract: this.model.story.abstract_highlighted ? this.model.story.abstract_highlighted : this.model.story.abstract,
                        action: "update_story"
                    };

                    root.send(url, data);
                }
            }
        });

        var Featured = Backbone.View.extend({
            el: $('.icc-featured'),
            collection: [],
            count: {
                firmwide: 3,
                partners: 3,
                secondary: 4
            },
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.featured', this.render.bind(this));
            },
            render: function (data) {
                $.each(this.collection, function (i, access) {
                    var $el = $('.icc-featured-'+i);
                    $el.html('');
                    $.each(access, function (j, item) {
                        if(data && data.story_id == item.story.id) {
                            item.reloadImage = "?t=" + (new Date()).getTime() + "&r=" + Math.round(Math.random()*100000) + "#" + Math.round(Math.random()*10000);
                        }
                        var row = new FeaturedRow({ model: item });
                        $el.append(row.render().el);
                        if(item.type == "secondary" && j===1) {
                            $el.append('<div id="edit-row1-secondary" class="col-sm-12"></div></div><div class="row">');
                        }
                    });
                }.bind(this));

                this.sortablePlugin();
            },
            sortablePlugin: function () {

                var self = this;

                var firmwide = $('.icc-featured-firmwide')[0];
                var partners = $('.icc-featured-partners')[0];

                if(firmwide) {
                    new window.Sortable.create(firmwide, {
                        handle: ".move",
                        onSort: self.updatePositions,
                        onStart: function () {
                            $('body').addClass('sort-firmwide');
                        },
                        onEnd: function () {
                            $('body').removeClass('sort-firmwide');
                        }
                    });
                }

                if(partners) {
                    new window.Sortable.create(partners, {
                        handle: ".move",
                        onSort: self.updatePositions,
                        onStart: function () {
                            $('body').addClass('sort-partners');
                        },
                        onEnd: function () {
                            $('body').removeClass('sort-partners');
                        }
                    });
                }
            },
            updatePositions: function (e) {
                var $this = $(this.el);
                var data = {
                    action: "update_positions"
                };

                var outer_positions = {};


                $this.find('.icc-featured-wrapper').each(function (i, item) {
                    var $el = $(item);
                    if($el.data('id')) {
                        outer_positions[ $el.data('id') ] = i+1;
                    }
                    $el.data('position', i+1);
                });
/*
                if($this.hasClass('icc-featured-firmwide')) {
                    $.each(window.featured.firmwide, function (i, val) {
                        window.featured.firmwide[i].position = inner_positions[i+1];
                    });
                    window.featured.firmwide = _.sortBy(window.featured.firmwide, function(o) { return o.position; });
                }

                if($this.hasClass('icc-featured-partners')) {
                    $.each(window.featured.partners, function (i, val) {
                        window.featured.partners[i].position = inner_positions[i+1];
                    });
                    window.featured.partners = _.sortBy(window.featured.partners, function(o) { return o.position; });
                }*/

                data.positions = outer_positions;
                root.send(url, data, function (result) {
                    window.featured = prepareFeaturedArray(result);
                    //vent.trigger('refresh.featured');
                });
            }
        });

        var featuredClass = new Featured({
            collection: window.featured
        });
        featuredClass.init();



    };


})(jQuery, main, window);